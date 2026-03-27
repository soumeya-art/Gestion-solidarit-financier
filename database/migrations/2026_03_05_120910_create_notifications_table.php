<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications_custom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type');
            $table->string('canal')->default('web');
            $table->text('message');
            $table->enum('statut', ['lu', 'non_lu'])->default('non_lu');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('notifications_custom');
    }
};