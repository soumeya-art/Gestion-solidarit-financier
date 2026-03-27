<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('groupes_solidarite', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->enum('type', ['tontine', 'mutuelle', 'cooperative']);
            $table->date('date_creation');
            $table->integer('nombre_membres')->default(0);
            $table->enum('statut', ['actif', 'inactif', 'cloture'])->default('actif');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('groupes_solidarite');
    }
};