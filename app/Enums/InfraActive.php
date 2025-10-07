<?php

namespace App\Enums;

class InfraActive
{
    const Active = 'Active';
    const Decomise = 'Decomise';
    const Standby = 'Standby';
    const Other = 'Other'; 
    public static function all(): array
    {
        return [
            self::Active,
            self::Decomise,
            self::Standby,
            self::Other, 
        ];
    }

    
    public static function options(): array
    {
        $options = [];

        foreach (self::all() as $value) {
            $options[$value] = ucfirst(strtolower($value));
        }

        return $options;
    }

    public static function label(string $value): string
    {
        return ucfirst(strtolower($value));
    }
}
