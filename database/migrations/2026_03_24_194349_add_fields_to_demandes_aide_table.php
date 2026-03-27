<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('demandes_aide', function (Blueprint $table) {
            $table->string('preuve')->nullable()->after('motif');
            $table->string('motif_refus')->nullable()->after('preuve');
        });
    }
    public function down(): void {}
};