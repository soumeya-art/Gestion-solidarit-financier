<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('comptes_membre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained('membres')->onDelete('cascade');
            $table->decimal('solde', 15, 2)->default(0);
            $table->decimal('total_cotise', 15, 2)->default(0);
            $table->decimal('credit_disponible', 15, 2)->default(0);
            $table->enum('statut', ['actif', 'bloque'])->default('actif');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('comptes_membre');
    }
};