<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periphels', function (Blueprint $table) {
            $table->id();
            $table->string('make', 150);
            $table->string('model', 150);
            $table->string('serial', 150)->nullable();
            $table->string('type', 150);

            $table->foreignId('company_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->index()->constrained()->nullOnDelete();
            $table->foreignId('provaider_id')->index()->constrained()->cascadeOnDelete();

            $table->boolean('current')->default(true);

            $table->dateTime('purchased_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periphels');
    }
};
