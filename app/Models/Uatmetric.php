<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uatmetric extends Model
{
    protected $table = 'uatmetrics';

    protected $fillable = [
        'timestamp', 'Hostname', 'IP_Address', 'Database', 'CPU', 'Memory',
        'DiskVolGroupAvg', 'DiskDataAvg', 'ServerStatus', 'LongQueryCount',
        'IdleInQ', 'LockingCount', 'PostgresVersion', 'flag', 'state'
    ];

    public $timestamps = true;
}