<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Contrats d'approvisionnement reliés à un négociant et, si connu, à un cépage.
        Schema::create('contrats', function (Blueprint $table) {
            $table->integer('Num_contrat')->primary();
            $table->date('Date_contrat');
            $table->decimal('Qte_commande', 10, 2);
            $table->date('Date_echeance_contrat');
            $table->integer('Id_negociant');
            $table->string('Nom_cepage', 15)->nullable();
            $table->date('Date_modification')->nullable();

            // Clés étrangères
            $table->foreign('Id_negociant')->references('Id_negociant')->on('negociants')->onDelete('cascade');
            $table->foreign('Nom_cepage')->references('Nom_cepage')->on('cepages')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('contrats');
    }
};