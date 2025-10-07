<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Infra extends Model
{
    use HasFactory;

    protected $table = 'infra';
    protected $primaryKey = 'id';


    protected $fillable = [
        'id', 'Hostname', 'IP_Address', 'VM_Name', 'IPBackup', 'Managedby',
        'SiteLocation', 'Environment', 'Class_Name', 'Description', 'Server_PIC',
        'TribeLeader', 'Tribe', 'Server_Category', 'Manufacturer', 'Model',
        'Serial', 'OS_Update', 'CPU', 'Memory_gb', 'Disk_mb', 'Domain',
        'Account', 'Build_Date', 'Remark', 'f26','updated_at'
    ];

     protected $casts = [
        'Build_Date' => 'datetime',
    ];

      


}

