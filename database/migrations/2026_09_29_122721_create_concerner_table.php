<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Détaille quelle quantité d'un contrat a été livrée et à quelle date.
        Schema::create('concerner', function (Blueprint $table) {
            $table->id('numero');
            $table->integer('Num_contrat');
            $table->integer('Num_livraison');
            $table->decimal('Qte_livree', 10, 2);
            $table->date('Date_livree');

            // Clés étrangères
            $table->foreign('Num_contrat')->references('Num_contrat')->on('contrats')->onDelete('cascade');
            $table->foreign('Num_livraison')->references('Num_livraison')->on('livraisons')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('concerner');
    }
};