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
        Schema::table('uatmetrics', function (Blueprint $table) {
            
    $table->integer('idleinQ')->after('LongQueryCount')->nullable(); // Ganti 'LongQueryCount' jika ingin posisi berbeda
    });

    // Jika ingin mengisi nilai default untuk data yang sudah ada
    DB::table('uatmetrics')->update(['idleinQ' => 0]);
 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uatmetrics', function (Blueprint $table) {
            $table->dropColumn('idleinQ');
        });
    }
};
