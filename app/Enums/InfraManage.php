<?php

namespace App\Enums;

class InfraManage
{
    const PTPLA = 'PTPLA';
    const REGIONAL = 'REGIONAL';
    const PTPLSA = 'PTPLSA'; 
    const OTHER = 'OTHER'; 
    public static function all(): array
    {
        return [
            self::PTPLA,
            self::REGIONAL,
            self::PTPLSA, 
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
