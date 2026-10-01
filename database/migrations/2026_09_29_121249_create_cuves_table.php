<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Chaque cuve a une lettre, une capacité et un cépage facultatif.
        Schema::create('cuves', function (Blueprint $table) {
            // Clé primaire de type CHAR(1)
            $table->char('Lettre_cuve', 1)->primary();
            $table->decimal('Capacite_cuve', 10, 2);
            $table->string('Nom_cepage', 15)->nullable();

            // Clé étrangère vers la table cepages
            $table->foreign('Nom_cepage')->references('Nom_cepage')->on('cepages')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('cuves');
    }
};