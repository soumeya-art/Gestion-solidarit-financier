<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('adhesions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained('membres')->onDelete('cascade');
            $table->foreignId('groupe_id')->constrained('groupes_solidarite')->onDelete('cascade');
            $table->date('date_adhesion');
            $table->enum('role', ['membre', 'tresorier', 'president'])->default('membre');
            $table->enum('statut', ['actif', 'suspendu', 'exclu'])->default('actif');
            $table->integer('cotisations_payees')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('adhesions');
    }
};