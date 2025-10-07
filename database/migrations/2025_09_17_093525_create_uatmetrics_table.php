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
        
        
Schema::create('uatmetrics', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->nullable();
            $table->string('Hostname');
            $table->string('IP_Address');
            $table->string('Database');
            $table->string('CPU');
            $table->string('Memory');
            $table->double('DiskVolGroupAvg');
            $table->double('DiskDataAvg');
            $table->string('ServerStatus');
            $table->integer('LongQueryCount');
            $table->integer('IdleInQ');
            $table->integer('LockingCount');
            $table->string('PostgresVersion');
            $table->string('flag')->nullable();
            $table->string('state')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uatmetrics');
    }
};
