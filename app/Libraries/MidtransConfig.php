<?php

namespace App\Libraries;

class MidtransConfig
{
    public static function get()
    {
        // Tentukan base URL secara dinamis
        $baseUrl = base_url();

        return (object)[
            'serverKey'      => env('MIDTRANS_SERVER_KEY'),
            'clientKey'      => env('MIDTRANS_CLIENT_KEY'),
            'merchantId'     => env('MIDTRANS_MERCHANT_ID'),
            'environment'    => 'sandbox', 
            'is3ds'          => true,
            'expiryDuration' => 1440, 
            
            'notificationUrl' => $baseUrl . 'payment/midtrans/notification',
            'finishUrl'       => $baseUrl . 'payment/finish',
            'unfinishUrl'     => $baseUrl . 'payment/unfinish',
            'errorUrl'        => $baseUrl . 'payment/error',

            'enabledPayments' => [
                'credit_card', 'bca_va', 'bni_va', 'bri_va', 
                'permata_va', 'gopay', 'shopeepay', 'qris', 'dana',
            ],
        ];
    }
}