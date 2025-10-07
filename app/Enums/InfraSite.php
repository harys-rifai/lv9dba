<?php

namespace App\Enums;

class InfraSite
{
    const NTT = 'NTT';
    const DCI = 'DCI';
    const SMG = 'SMG';
    const JKT = 'JKT';
    const MDN = 'MDN';
    const DPS = 'DPS';
    const BDG = 'BDG';
    const PRUTOWER = 'PRUTOWER';
    const PRUCENTRE = 'PRUCENTRE';
    
    public static function all(): array
    {
        return [
            self::NTT,
            self::DCI,
            self::SMG,
            self::JKT,
            self::MDN,
            self::DPS,
            self::BDG,
            self::PRUTOWER,
            self::PRUCENTRE,
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

