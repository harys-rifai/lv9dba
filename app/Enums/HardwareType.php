<?php

namespace App\Enums;

class HardwareType
{
    const SERVER = 'server';
    const DESKTOP = 'desktop';
    const LAPTOP = 'laptop';
    const TABLET = 'tablet';
    const ANDROID = 'android';
    const IPHONE = 'iphone';
    const PRINTER = 'printer';
    const ROUTER = 'router';
    const SWITCH = 'switch';

    public static function all(): array
    {
        return [
            self::SERVER,
            self::DESKTOP,
            self::LAPTOP,
            self::TABLET,
            self::ANDROID,
            self::IPHONE,            
            self::PRINTER,
            self::ROUTER,
            self::SWITCH,
        ];
    }

    public static function options(): array
    {
        $options = [];

        foreach (self::all() as $case => $value) {
            $options[$case] = ucfirst($value);
        }

        return $options;
    }
}
