<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // En-tête de livraison historique; quantité et contrat sont stockés dans concerner.
        Schema::create('livraisons', function (Blueprint $table) {
            $table->integer('Num_livraison')->primary();
            $table->date('Date_reel_livraison');
        });
    }

    public function down(): void {
        Schema::dropIfExists('livraisons');
    }
};