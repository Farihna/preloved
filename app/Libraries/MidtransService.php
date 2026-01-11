<?php

namespace App\Libraries;

use App\Models\PaymentModel;
use App\Models\TransactionModel;

class MidtransService
{
    protected $config;
    protected $paymentModel;
    protected $transactionModel;
    
    public function __construct()
    {
        $this->config = MidtransConfig::get();
        
        $this->paymentModel = new PaymentModel();
        $this->transactionModel = new TransactionModel();
        
        // Set Midtrans SDK global configuration
        \Midtrans\Config::$serverKey    = $this->config->serverKey;
        \Midtrans\Config::$clientKey    = $this->config->clientKey;
        \Midtrans\Config::$isProduction = ($this->config->environment === 'production');
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = $this->config->is3ds;
    }
    
    /**
     * Create Snap Token for payment
     */
    public function createSnapToken($transactionId)
    {
        try {
            $transaction = $this->transactionModel->getTransactionWithDetails($transactionId);
            
            if (!$transaction) {
                throw new \Exception('Transaction not found');
            }
            
            // Generate unique order ID
            $orderId = 'ORDER-' . $transactionId . '-' . time();
            
            log_message('info', '=== Creating Snap Token ===');
            log_message('info', 'Transaction ID: ' . $transactionId);
            log_message('info', 'Order ID: ' . $orderId);
            log_message('info', 'Amount: ' . $transaction['total_amount']);
            
            // Prepare transaction details
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int)$transaction['total_amount'],
                ],
                'item_details' => [
                    [
                        'id' => 'PRODUCT-' . $transaction['product_id'],
                        'price' => (int)$transaction['product_price'],
                        'quantity' => 1,
                        'name' => substr($transaction['product_name'], 0, 50),
                    ],
                    [
                        'id' => 'SHIPPING',
                        'price' => (int)$transaction['shipping_cost'],
                        'quantity' => 1,
                        'name' => 'Ongkos Kirim - ' . $transaction['courier_name'],
                    ],
                ],
                'customer_details' => [
                    'first_name' => $transaction['buyer_name'],
                    'email' => $transaction['buyer_email'],
                    'phone' => $transaction['shipping_phone'],
                ],
                'enabled_payments' => $this->config->enabledPayments,
                'callbacks' => [
                    'finish' => $this->config->finishUrl,
                ],
                'expiry' => [
                    'unit' => 'minutes',
                    'duration' => $this->config->expiryDuration,
                ],
            ];
            
            log_message('info', 'Snap Params: ' . json_encode($params));
            
            // Get Snap Token from Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            log_message('info', 'Snap Token Created: ' . $snapToken);
            
            // Save to database
            $payment = $this->paymentModel->getByTransactionId($transactionId);
            
            $paymentData = [
                'transaction_id' => $transactionId,
                'payment_method' => 'midtrans',
                'midtrans_order_id' => $orderId,
                'snap_token' => $snapToken,
                'midtrans_gross_amount' => $transaction['total_amount'],
                'payment_status' => 'pending',
                'expired_at' => date('Y-m-d H:i:s', strtotime('+' . $this->config->expiryDuration . ' minutes')),
            ];
            
            if ($payment) {
                // Update existing
                $this->paymentModel->update($payment['id'], $paymentData);
                log_message('info', 'Payment record updated');
            } else {
                // Create new
                $this->paymentModel->insert($paymentData);
                log_message('info', 'Payment record created');
            }
            
            return [
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ];
            
        } catch (\Exception $e) {
            log_message('error', '=== Snap Token Error ===');
            log_message('error', 'Message: ' . $e->getMessage());
            log_message('error', 'File: ' . $e->getFile() . ':' . $e->getLine());
            log_message('error', 'Trace: ' . $e->getTraceAsString());
            log_message('error', 'Params saat error: ' . json_encode($params));

            return [
                'success' => false,
                'message' => 'Midtrans Error: '. $e->getMessage(),
            ];
        }
    }
    
    /**
     * Handle notification from Midtrans
     */
    public function handleNotification($postData)
    {
        try {
            $notification = new \Midtrans\Notification();
            
            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? null;
            
            log_message('info', "=== Midtrans Notification ===");
            log_message('info', "Order: {$orderId}, Status: {$transactionStatus}, Fraud: {$fraudStatus}");
            
            // Update payment record
            $this->paymentModel->updateFromMidtrans($orderId, (array)$notification);
            
            // Get payment and transaction
            $payment = $this->paymentModel->getByMidtransOrderId($orderId);
            
            if (!$payment) {
                throw new \Exception('Payment not found');
            }
            
            $transaction = $this->transactionModel->find($payment['transaction_id']);
            
            // Handle based on transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    // Payment success - UPDATE PRODUCT STATUS HERE
                    $this->transactionModel->update($transaction['id'], [
                        'status' => 'paid',
                        'payment_date' => date('Y-m-d H:i:s'),
                    ]);
                    
                    // Update product status to sold/reserved
                    $productModel = new \App\Models\ProductModel();
                    $productModel->update($transaction['product_id'], ['status' => 0]);
                    
                    log_message('info', "Payment captured - Product reserved");
                }
            } elseif ($transactionStatus == 'settlement') {
                // Payment success - UPDATE PRODUCT STATUS HERE
                $this->transactionModel->update($transaction['id'], [
                    'status' => 'paid',
                    'payment_date' => date('Y-m-d H:i:s'),
                ]);
                
                // Update product status to sold/reserved
                $productModel = new \App\Models\ProductModel();
                $productModel->update($transaction['product_id'], ['status' => 0]);
                
                log_message('info', "Payment settled - Product reserved");
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                // Payment failed - Keep product available
                $this->transactionModel->update($transaction['id'], [
                    'status' => 'cancelled',
                    'notes' => 'Payment ' . $transactionStatus,
                    'cancelled_at' => date('Y-m-d H:i:s'),
                ]);
                
                log_message('info', "Payment failed - Product still available");
            } elseif ($transactionStatus == 'pending') {
                // Payment pending - Keep product available
                $this->transactionModel->update($transaction['id'], [
                    'status' => 'pending',
                ]);
                
                log_message('info', "Payment pending");
            }
            
            return [
                'success' => true,
                'message' => 'Notification processed',
            ];
            
        } catch (\Exception $e) {
            log_message('error', 'Midtrans Notification Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}