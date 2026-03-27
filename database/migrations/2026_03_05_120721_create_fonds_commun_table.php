<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fonds_commun', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groupe_id')->constrained('groupes_solidarite')->onDelete('cascade');
            $table->decimal('solde_total', 15, 2)->default(0);
            $table->decimal('solde_disponible', 15, 2)->default(0);
            $table->decimal('solde_reserve', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fonds_commun');
    }
};