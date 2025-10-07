<?php

namespace App\Enums;

class InfraCate
{
    const APP = 'APP';
    const DB = 'DB';
    const INFRA = 'INFRA'; 
    const NETWORK = 'NETWORK'; 
    const FS = 'FS'; 
    const OTHER = 'OTHER'; 
    public static function all(): array
    {
        return [
            self::APP,
            self::DB,
            self::INFRA, 
            self::FS, 
            self::NETWORK, 
            self::OTHER, 
        ];
    }

   

public static function options(): array
{
    $options = [];

    foreach (self::all() as $value) {
        $options[$value] = strtoupper($value);
    }

    return $options;
}

public static function label(string $value): string
{
    return strtoupper($value);
}

}
