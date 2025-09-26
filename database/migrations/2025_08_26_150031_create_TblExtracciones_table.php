<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('TblExtracciones', function (Blueprint $table) {
            $table->text('idExtracciones')->nullable()->primary();
            $table->integer('id_occ_bd');
            $table->text('materialSampleType')->nullable();
            $table->text('idRegistros')->nullable();
            $table->date('fechaExtraccion')->nullable();
            $table->text('purificationMethod')->nullable();
            $table->text('methodDeterminationConcentrationAndRatios')->nullable();
            $table->boolean('adn_enSTOCK')->nullable();
            $table->decimal('volume', 20, 10)->nullable();
            $table->text('volumeUnit')->nullable();
            $table->decimal('concentration', 20, 10)->nullable();
            $table->text('concentrationUnit')->nullable();
            $table->decimal('ratioOfAbsorbance260_280', 20, 10)->nullable();
            $table->decimal('ratioOfAbsorbance260_230', 20, 10)->nullable();
            $table->text('preservationType')->nullable();
            $table->text('preservationTemperature')->nullable();
            $table->date('preservationDateBegin')->nullable();
            $table->text('quality')->nullable();
            $table->date('qualityCheckDate')->nullable();
            $table->text('sieving')->nullable();
            $table->text('codigoMuestraBiobanco')->nullable();
            $table->text('codigoADNBiobanco')->nullable();
            $table->text('codigoGermoplasmaBiobanco')->nullable();
            $table->text('extractionStaff')->nullable();
            $table->text('qualityRemarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('TblExtracciones');
    }
};
