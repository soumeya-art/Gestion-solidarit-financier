<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('regles_groupe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groupe_id')->constrained('groupes_solidarite')->onDelete('cascade');
            $table->decimal('cotisation_minimale', 15, 2);
            $table->enum('frequence', ['mensuel', 'hebdomadaire', 'trimestriel'])->default('mensuel');
            $table->decimal('plafond_pret', 15, 2)->default(0);
            $table->decimal('taux_interet', 5, 2)->default(0);
            $table->decimal('penalite_retard', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('regles_groupe');
    }
};