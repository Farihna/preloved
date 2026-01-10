<?php

namespace App\Libraries;

class RajaOngkirConfig
{
    public static function get()
    {
        return (object)[
            'apiKey' => 'EWrC9PKv62a8c0434e068d86e1UuePax',
            'baseUrl' => 'https://rajaongkir.komerce.id/api/v1',
            'defaultOriginId' => '68372',
            'availableCouriers' => ['jne', 'tiki', 'jnt', 'sicepat', 'anteraja']
        ];
    }
}