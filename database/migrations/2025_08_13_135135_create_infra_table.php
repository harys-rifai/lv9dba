<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('infra', function (Blueprint $table) {
            $table->integer('id')->nullable();
            $table->string('Hostname')->nullable();
            $table->string('IP_Address')->nullable();
            $table->string('VM_Name')->nullable();
            $table->string('IPBackup')->nullable();
            $table->string('Managedby')->nullable();
            $table->string('SiteLocation')->nullable();
            $table->string('Environment')->nullable();
            $table->string('Class_Name')->nullable();
            $table->string('Description')->nullable();
            $table->string('Server_PIC')->nullable();
            $table->string('Tribe_Leader')->nullable();
            $table->string('Tribe')->nullable();
            $table->string('Server_Category')->nullable();
            $table->string('Manufacturer')->nullable();
            $table->string('Model')->nullable();
            $table->string('Serial_Number')->nullable();
            $table->string('OS_Update')->nullable();
            $table->integer('CPU')->nullable();
            $table->integer('Memory_gb')->nullable();
            $table->integer('Disk_mb')->nullable();
            $table->string('Domain')->nullable();
            $table->string('Account')->nullable();
            $table->string('Build_Date')->nullable();
            $table->string('Remark')->nullable();
            $table->string('f26')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infra');
    }
};
