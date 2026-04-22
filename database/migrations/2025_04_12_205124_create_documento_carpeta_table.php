<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documento_carpeta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained('documentos')->cascadeOnDelete();
            $table->foreignId('carpeta_id')->constrained('carpetas')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['documento_id', 'carpeta_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documento_carpeta');
    }
};
