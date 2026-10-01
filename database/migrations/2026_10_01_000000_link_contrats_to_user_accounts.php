<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            $table->integer('Id_negociant')->nullable()->change();
            $table->unsignedInteger('Id_utilisateur')->nullable()->after('Id_negociant');
            $table->foreign('Id_utilisateur')
                ->references('Id_utilisateur')
                ->on('utilisateurs')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('contrats', function (Blueprint $table) {
            $table->dropForeign(['Id_utilisateur']);
            $table->dropColumn('Id_utilisateur');
        });
    }
};