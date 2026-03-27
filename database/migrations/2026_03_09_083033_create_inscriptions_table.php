<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('telephone');
            $table->string('password');
            $table->enum('statut', ['en_attente', 'accepte', 'refuse'])->default('en_attente');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('inscriptions');
    }
};