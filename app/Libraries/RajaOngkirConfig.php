<?php

namespace App\Libraries;

class RajaOngkirConfig
{
    public static function get()
    {
        return (object)[
            'apiKey' => env('RAJAONGKIR_API_KEY'),
            'baseUrl' => 'https://rajaongkir.komerce.id/api/v1',
            'defaultOriginId' => '68372',
            'availableCouriers' => ['jne', 'tiki', 'jnt', 'sicepat', 'anteraja']
        ];
    }
}