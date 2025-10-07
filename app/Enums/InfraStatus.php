<?php

namespace App\Enums;

class InfraStatus
{
    const PROD = 'PROD';
    const NPROD = 'NPROD';
    const PRODDMZ = 'PROD-DMZ';
    const DEVDDMZ = 'DEV-DMZ';
    const UAT = 'UAT';
    const DEV = 'DEV';
    const CLONE = 'CLONE';
    public static function all(): array
    {
        return [
            self::PROD,
            self::NPROD,
            self::PRODDMZ,
            self::DEVDDMZ,
            self::UAT,
            self::DEV,
            self::CLONE,
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

