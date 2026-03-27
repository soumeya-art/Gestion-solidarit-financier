<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('membres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('date_naissance')->nullable();
            $table->text('adresse')->nullable();
            $table->string('piece_identite')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('membres');
    }
};