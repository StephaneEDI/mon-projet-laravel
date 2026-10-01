<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Planification et état d'expédition pour chaque ligne d'une commande client.
        Schema::create('livraison_suivis', function (Blueprint $table) {
            $table->bigIncrements('Id_suivi');
            $table->unsignedBigInteger('Id_ligne');
            $table->decimal('Qte_prevue', 10, 2);
            $table->date('Date_prevue')->nullable();
            $table->string('Statut', 20)->default('a_effectuer');
            $table->date('Date_reelle')->nullable();
            $table->timestamps();

            $table->foreign('Id_ligne')
                ->references('Id_ligne')
                ->on('commande_lignes')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livraison_suivis');
    }
};