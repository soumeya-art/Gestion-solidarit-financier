<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('regles_groupe', function (Blueprint $table) {
            $table->id();
            $table->decimal('cotisation_minimale', 10, 2)->default(5000);
            $table->enum('frequence', ['mensuel', 'hebdomadaire', 'trimestriel'])->default('mensuel');
            $table->decimal('penalite_retard', 5, 2)->default(2);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('fonds_commun', function (Blueprint $table) {
            $table->id();
            $table->decimal('solde_total', 15, 2)->default(0);
            $table->decimal('solde_disponible', 15, 2)->default(0);
            $table->decimal('solde_reserve', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('adhesions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained('membres')->onDelete('cascade');
            $table->date('date_adhesion');
            $table->enum('role', ['membre', 'tresorier'])->default('membre');
            $table->enum('statut', ['actif', 'suspendu'])->default('actif');
            $table->integer('cotisations_payees')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('adhesions');
        Schema::dropIfExists('fonds_commun');
        Schema::dropIfExists('regles_groupe');
    }
};