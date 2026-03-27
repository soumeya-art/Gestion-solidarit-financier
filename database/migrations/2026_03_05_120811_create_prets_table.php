<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('prets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained('membres')->onDelete('cascade');
            $table->foreignId('groupe_id')->constrained('groupes_solidarite')->onDelete('cascade');
            $table->decimal('montant_pret', 15, 2);
            $table->decimal('taux_interet', 5, 2)->default(0);
            $table->integer('duree_en_mois');
            $table->decimal('capital_restant', 15, 2)->default(0);
            $table->string('motif')->nullable();
            $table->enum('statut', ['en_attente', 'approuve', 'refuse', 'rembourse'])->default('en_attente');
            $table->date('date_approbation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('prets');
    }
};