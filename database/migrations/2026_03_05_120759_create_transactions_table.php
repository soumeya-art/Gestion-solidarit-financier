<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['cotisation', 'pret', 'remboursement', 'aide', 'penalite']);
            $table->decimal('montant', 15, 2);
            $table->enum('statut', ['complete', 'en_attente', 'annule'])->default('en_attente');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};