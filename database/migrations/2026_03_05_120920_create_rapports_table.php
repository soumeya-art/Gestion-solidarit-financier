<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rapports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groupe_id')->constrained('groupes_solidarite')->onDelete('cascade');
            $table->enum('type', ['mensuel', 'annuel', 'prets', 'cotisations']);
            $table->string('titre');
            $table->date('periode_debut');
            $table->date('periode_fin');
            $table->decimal('total_cotisations', 15, 2)->default(0);
            $table->decimal('total_prets', 15, 2)->default(0);
            $table->decimal('total_remboursements', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rapports');
    }
};