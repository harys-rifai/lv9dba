<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemMetric extends Model
{
    protected $table = 'system_metrics';
    protected $connection = 'dbapru';

    public $timestamps = false;

    protected $primaryKey = 'timestamp'; // atau 'id' jika kamu menambahkannya
    public $incrementing = false;
    protected $keyType = 'string'; // atau 'datetime'
    
    protected $casts = [
            'timestamp' => 'datetime',
        ];

    protected $fillable = [
        'timestamp',
        'hostname',
        'environment',
        'cpu_usage',
        'memory_usage',
        'disk_usage',
        'network_usage',
        'status',
        'extra1',
        'extra2',
        'file_name',
        'load_status',
        'pgver','ip_address',
    ];
}
