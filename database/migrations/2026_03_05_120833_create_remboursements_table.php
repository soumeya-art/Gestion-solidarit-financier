<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('remboursements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pret_id')->constrained('prets')->onDelete('cascade');
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->onDelete('set null');
            $table->decimal('montant', 15, 2);
            $table->date('date_remboursement');
            $table->enum('statut', ['paye', 'en_attente', 'retard'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('remboursements');
    }
};