<?php

namespace App\Enums;

class InfraClass
{
    const PhysicalServer = 'Physical Server';
    const VirtualServer = 'Virtual Server';
    const Other = 'Other'; 
    public static function all(): array
    {
        return [
            self::PhysicalServer,
            self::VirtualServer,
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

