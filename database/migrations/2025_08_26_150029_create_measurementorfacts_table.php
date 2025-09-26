<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('measurementorfacts', function (Blueprint $table) {
            $table->text('measurementID')->nullable()->primary();
            $table->integer('id_occ_bd');
            $table->text('measurementType')->nullable();
            $table->text('measurementValue')->nullable();
            $table->text('measurementAccuracy')->nullable();
            $table->text('measurementUnit')->nullable();
            $table->text('measurementDeterminedBy')->nullable();
            $table->date('measurementDeterminedDate')->nullable();
            $table->text('measurementMethod')->nullable();
            $table->text('measurementRemarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurementorfacts');
    }
};
