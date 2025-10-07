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
        Schema::create('filtered_metrics', function (Blueprint $table) {
        $table->id();
        $table->timestamp('timestamp');
        $table->string('hostname');
        $table->string('environment');
        $table->float('cpu_usage');
        $table->float('memory_usage');
        $table->string('status')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filtered_metrics');
    }
};
