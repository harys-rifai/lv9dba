<?php

namespace App\Enums;

class InfraManuf
{
    const VMwareINC = 'VMware, Inc.';
    const HPE = 'HPE';
    const DELL = 'DELL'; 
    const LENOVO = 'LENOVO';  
    const OTHER = 'OTHER'; 
    public static function all(): array
    {
        return [
            self::VMwareINC,
            self::HPE, 
            self::DELL, 
            self::LENOVO, 
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
