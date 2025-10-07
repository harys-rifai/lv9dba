<?php

namespace App\Enums;

enum InfraCategory: string
{
    case APP = 'APP';
    case DB = 'DB';
    case FS = 'FS';
    case INFRA = 'INFRA';
    case VMWARE = 'VMware, Inc.';
    case UNKNOWN = 'UNKNOWN';

    public function icon(): string
    {
        return match ($this) {
            self::APP => 'heroicon-o-cube',
            self::DB => 'heroicon-o-database',
            self::FS => 'heroicon-o-folder',
            self::INFRA => 'heroicon-o-server',
            self::VMWARE => 'heroicon-o-chip',
            self::UNKNOWN => 'heroicon-o-question-mark-circle',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::APP => 'primary',
            self::DB => 'success',
            self::FS => 'warning',
            self::INFRA => 'purple',
            self::VMWARE => 'pink',
            self::UNKNOWN => 'gray',
        };
    }

    public static function fromCategory(?string $value): self
    {
        return match (strtoupper($value)) {
            'APP', 'APP' => self::APP,
            'DB' => self::DB,
            'FS' => self::FS,
            'INFRA' => self::INFRA,
            'VMWARE, INC.' => self::VMWARE,
            default => self::UNKNOWN,
        };
    }
}
