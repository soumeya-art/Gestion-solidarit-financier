<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('demandes_aide', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained('membres')->onDelete('cascade');
            $table->foreignId('groupe_id')->constrained('groupes_solidarite')->onDelete('cascade');
            $table->enum('type', ['medicale', 'deces', 'scolaire', 'autre']);
            $table->decimal('montant_demande', 15, 2);
            $table->string('motif');
            $table->enum('statut', ['en_attente', 'approuve', 'refuse'])->default('en_attente');
            $table->decimal('montant_approuve', 15, 2)->nullable();
            $table->date('date_demande');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('demandes_aide');
    }
};