<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('cotisations', function (Blueprint $table) {
            $table->decimal('penalite', 10, 2)->default(0)->after('montant');
            $table->decimal('montant_total', 10, 2)->default(0)->after('penalite');
            $table->boolean('en_retard')->default(false)->after('montant_total');
        });
    }
    public function down(): void {}
};