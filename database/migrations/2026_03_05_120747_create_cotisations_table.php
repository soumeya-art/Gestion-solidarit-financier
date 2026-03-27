<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cotisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained('membres')->onDelete('cascade');
            $table->foreignId('groupe_id')->constrained('groupes_solidarite')->onDelete('cascade');
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->onDelete('set null');
            $table->decimal('montant', 15, 2);
            $table->enum('statut', ['payee', 'en_attente', 'retard'])->default('en_attente');
            $table->date('date_paiement')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cotisations');
    }
};