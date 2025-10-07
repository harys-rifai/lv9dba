<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilteredMetric extends Model
{
    protected $table = 'filtered_metrics';

    protected $fillable = [
        'timestamp',
        'hostname',
        'environment',
        'cpu_usage',
        'memory_usage',
        'status',
    ];

    public static array $hostnameColors = [
        'VIDDCLXPAOBDB06' => 'rgba(255, 99, 132, 0.8)',
        'VIDDCLXPSMEDB01' => 'rgba(54, 162, 235, 0.8)',
        'VIDDCLXPENTDB01' => 'rgba(255, 206, 86, 0.8)',
        'VIDDCLXPAOBDB03' => 'rgba(75, 192, 192, 0.8)',
        'VIDDCLXPBSEDB06' => 'rgba(153, 102, 255, 0.8)',
        'VIDDCLXPAOBDB04' => 'rgba(255, 159, 64, 0.8)',
        'VIDDCLXPAOBDB02' => 'rgba(199, 199, 199, 0.8)',
        'VIDHOLXPODSDB01' => 'rgba(255, 99, 71, 0.8)',
        'VIDDCLXPAICDB01' => 'rgba(100, 149, 237, 0.8)',
        'VIDDCLXPAOBDB05' => 'rgba(0, 128, 128, 0.8)',
    ]; 

    public static array $environmentColors = [
        'PRUWORKS'     => 'rgba(255, 99, 132, 0.8)',
        'EPOLICY'      => 'rgba(54, 162, 235, 0.8)',
        'epolicy'      => 'rgba(54, 162, 235, 0.6)', // lowercase variant
        'TRAINING'     => 'rgba(255, 206, 86, 0.8)',
        'LEADS'        => 'rgba(75, 192, 192, 0.8)',
        'NEWODS'       => 'rgba(153, 102, 255, 0.8)',
        'postgres'     => 'rgba(199, 199, 199, 0.8)',
        'COMPLIANCE'   => 'rgba(255, 159, 64, 0.8)',
        'ESUB'         => 'rgba(255, 99, 71, 0.8)',
        'fuse'         => 'rgba(100, 149, 237, 0.8)',
        'PRUDBCLM'     => 'rgba(0, 128, 128, 0.8)',
        'edb'          => 'rgba(128, 128, 128, 0.8)',
        'BASE'         => 'rgba(255, 105, 180, 0.8)',
        'MAGNUMPURE'   => 'rgba(0, 255, 127, 0.8)',
        'NBWF'         => 'rgba(70, 130, 180, 0.8)',
        'AICOE'        => 'rgba(218, 165, 32, 0.8)',
        'OMNI'         => 'rgba(123, 104, 238, 0.8)',
    ];

    public static function getHostnameColor(string $hostname): string
    {
        return self::$hostnameColors[$hostname] ?? 'rgba(128, 128, 128, 0.5)';
    }

    public static function getEnvironmentColor(string $environment): string
    {
        return self::$environmentColors[$environment] ?? 'rgba(128, 128, 128, 0.5)';
    }
}
