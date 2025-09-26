<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('TblMultimedia', function (Blueprint $table) {
            $table->text('idMultimedia')->nullable()->primary();
            $table->integer('id_occ_bd');
            $table->text('type')->nullable();
            $table->text('format')->nullable();
            $table->text('identifier')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->date('created')->nullable();
            $table->text('creator')->nullable();
            $table->text('contributor')->nullable();
            $table->text('publisher')->nullable();
            $table->text('license')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('TblMultimedia');
    }
};
