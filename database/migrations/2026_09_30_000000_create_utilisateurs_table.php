<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Comptes web personnalisés; le rôle public par défaut ne donne aucun droit admin.
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->increments('Id_utilisateur');
            $table->string('Nom_utilisateur', 100);
            $table->string('Prenom_utilisateur', 100);
            $table->string('Email_utilisateur', 255)->unique();
            $table->string('Password_utilisateur');
            $table->string('Role_utilisateur', 30)->default('negociant');
            $table->string('Telephone_utilisateur', 15)->nullable();
            $table->string('Photo_utilisateur')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};