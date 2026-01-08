<?php

if (!function_exists('format_courier_name')) {
    function format_courier_name($code)
    {
        $couriers = [
            'jne' => 'JNE',
            'pos' => 'POS Indonesia',
            'tiki' => 'TIKI',
            'rpx' => 'RPX',
            'pandu' => 'Pandu Logistics',
            'wahana' => 'Wahana',
            'sicepat' => 'SiCepat',
            'jnt' => 'J&T Express',
            'anteraja' => 'AnterAja',
            'lion' => 'Lion Parcel',
            'ninja' => 'Ninja Xpress',
            'idexpress' => 'ID Express'
        ];
        
        return $couriers[strtolower($code)] ?? strtoupper($code);
    }
}

if (!function_exists('format_shipping_cost')) {
    function format_shipping_cost($cost)
    {
        return 'Rp ' . number_format($cost, 0, ',', '.');
    }
}

if (!function_exists('format_weight')) {
    function format_weight($grams)
    {
        if ($grams >= 1000) {
            return ($grams / 1000) . ' kg';
        }
        return $grams . ' gram';
    }
}