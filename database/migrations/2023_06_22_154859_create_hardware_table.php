<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hardware', function (Blueprint $table) {
            $table->id();
            // $table->string('hostname')->nullable();
            $table->string('make', 150);
            $table->string('model', 150);
            $table->string('serial', 150);
            $table->string('os_name', 150)->nullable();
            $table->string('os_version', 150)->nullable();
            $table->string('type', 150);
            $table->string('ram', 15)->nullable();
            $table->string('cpu', 15)->nullable();

            $table->string('status', 15);
            $table->boolean('current')->default(true);

            $table->foreignId('company_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->index()->constrained()->nullOnDelete();
            $table->foreignId('provaider_id')->index()->constrained()->cascadeOnDelete();

            $table->dateTime('purchased_at');
            $table->string('note', 250);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hardware');
    }
};
