<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Une commande appartient à un compte client et conserve ses propres lignes tarifées.
        Schema::create('commandes', function (Blueprint $table) {
            $table->bigIncrements('Id_commande');
            $table->unsignedInteger('Id_utilisateur');
            $table->decimal('Montant_total', 12, 2);
            $table->string('Statut_commande', 30)->default('En attente');
            $table->timestamps();

            $table->foreign('Id_utilisateur')
                ->references('Id_utilisateur')
                ->on('utilisateurs')
                ->onDelete('cascade');
        });

        Schema::create('commande_lignes', function (Blueprint $table) {
            $table->bigIncrements('Id_ligne');
            $table->unsignedBigInteger('Id_commande');
            $table->string('Nom_cepage', 15);
            $table->decimal('Quantite', 10, 2);
            $table->decimal('Prix_unitaire', 10, 2);
            $table->decimal('Sous_total', 12, 2);

            $table->foreign('Id_commande')
                ->references('Id_commande')
                ->on('commandes')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commande_lignes');
        Schema::dropIfExists('commandes');
    }
};