<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('demandes_remboursement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained('membres')->onDelete('cascade');
            $table->decimal('montant_demande', 15, 2);
            $table->decimal('montant_approuve', 15, 2)->nullable();
            $table->string('motif');
            $table->enum('statut', ['en_attente', 'approuve', 'refuse'])->default('en_attente');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('demandes_remboursement');
    }
};