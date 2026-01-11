<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'transaction_id', 'payment_method', 'payment_type', 'payment_channel',
        'midtrans_order_id', 'midtrans_transaction_id', 'midtrans_gross_amount',
        'midtrans_payment_type', 'midtrans_transaction_time', 'midtrans_transaction_status',
        'midtrans_fraud_status', 'midtrans_status_code', 'midtrans_signature_key',
        'snap_token', 'snap_redirect_url', 'payment_status', 'paid_at', 'expired_at',
        'raw_response', 'notes'
    ];
    protected $useTimestamps = true;
    
    /**
     * Get payment by transaction ID
     */
    public function getByTransactionId($transactionId)
    {
        return $this->where('transaction_id', $transactionId)->first();
    }
    
    /**
     * Get payment by Midtrans Order ID
     */
    public function getByMidtransOrderId($orderId)
    {
        return $this->where('midtrans_order_id', $orderId)->first();
    }
    
    /**
     * Update payment status from Midtrans notification
     */
    public function updateFromMidtrans($orderId, $data)
    {
        $payment = $this->getByMidtransOrderId($orderId);
        
        if (!$payment) {
            return false;
        }
        
        $updateData = [
            'midtrans_transaction_id' => $data['transaction_id'] ?? null,
            'midtrans_transaction_status' => $data['transaction_status'] ?? null,
            'midtrans_fraud_status' => $data['fraud_status'] ?? null,
            'midtrans_status_code' => $data['status_code'] ?? null,
            'midtrans_payment_type' => $data['payment_type'] ?? null,
            'midtrans_transaction_time' => $data['transaction_time'] ?? null,
            'payment_status' => $this->mapMidtransStatus($data['transaction_status'] ?? 'pending'),
            'raw_response' => json_encode($data),
        ];
        
        // Set payment type and channel based on payment method
        if (isset($data['payment_type'])) {
            $updateData['payment_type'] = $data['payment_type'];
            
            // Extract channel/bank
            if (isset($data['va_numbers'][0]['bank'])) {
                $updateData['payment_channel'] = strtoupper($data['va_numbers'][0]['bank']);
            } elseif (isset($data['bank'])) {
                $updateData['payment_channel'] = strtoupper($data['bank']);
            }
        }
        
        // Mark as paid if settlement/capture
        if (in_array($updateData['payment_status'], ['settlement', 'capture'])) {
            $updateData['paid_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->update($payment['id'], $updateData);
    }
    
    /**
     * Map Midtrans status to our payment status
     */
    private function mapMidtransStatus($midtransStatus)
    {
        $statusMap = [
            'capture' => 'capture',
            'settlement' => 'settlement',
            'pending' => 'pending',
            'deny' => 'deny',
            'expire' => 'expire',
            'cancel' => 'cancel',
            'failure' => 'failure',
        ];
        
        return $statusMap[$midtransStatus] ?? 'pending';
    }
}