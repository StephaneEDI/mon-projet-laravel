<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Référentiel des négociants associés aux contrats historiques.
        Schema::create('negociants', function (Blueprint $table) {
            // Clé primaire : Id_negociant
            $table->integer('Id_negociant')->primary();
            $table->string('Nom_negociant', 20);
            $table->string('Prenom_negociant', 30);
            $table->string('Telephone_negociant', 15);
            $table->timestamp('Date_inscription')->useCurrent();
            $table->timestamp('Date_modification')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('negociants');
    }
};