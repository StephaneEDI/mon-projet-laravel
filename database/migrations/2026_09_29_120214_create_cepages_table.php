<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Catalogue public: caractéristiques, prix et stock disponible pour chaque cépage.
        Schema::create('cepages', function (Blueprint $table) {
            // Clé primaire personnalisée : Nom_cepage
            $table->string('Nom_cepage', 15)->primary();
            $table->string('Couleur_cepage', 15);
            $table->decimal('Teneur_suc_cepage', 8, 2);
            $table->string('Region_cepage', 30);
            $table->string('Image_cepage', 255);
            $table->text('Description_cepage');
            $table->decimal('Prix_kg_cepage', 10, 2)->default(0);
            $table->decimal('Qte_cepage_disponible', 10, 2)->default(0);
            $table->timestamp('Date_ajout')->useCurrent();
            $table->timestamp('Date_modification')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cepages');
    }
};