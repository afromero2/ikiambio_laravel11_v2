<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('TblPrimersR', function (Blueprint $table) {
            $table->text('idPrimersr')->nullable()->primary();
            $table->text('genAbrev')->nullable();
            $table->text('genName')->nullable();
            $table->text('primerName')->nullable();
            $table->text('primerSequence')->nullable();
            $table->text('primerReferenceCitation')->nullable();
            $table->integer('id_primerDirection');
            $table->text('grupo_Taxonomico')->nullable();
            $table->text('region')->nullable();
            $table->text('tecnologia')->nullable();
            $table->text('proyecto_Tesis')->nullable();
            $table->integer('longitud_Primer')->nullable();
            $table->integer('Longitud_amplicon')->nullable();
            $table->decimal('gc', 20, 10)->nullable();
            $table->decimal('dnaMeltingPoint', 20, 10)->nullable();
            $table->decimal('annealing_Temperature', 20, 10)->nullable();
            $table->text('primerStaff')->nullable();
            $table->date('fecha_orden')->nullable();
            $table->text('proveedor')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('TblPrimersR');
    }
};
