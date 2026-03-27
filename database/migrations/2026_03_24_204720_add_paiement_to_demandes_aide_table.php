<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('demandes_aide', function (Blueprint $table) {
            $table->enum('mode_paiement', [
                'especes', 'waafi', 'dmoney'
            ])->nullable()->after('motif_refus');
            $table->string('reference_paiement')->nullable()->after('mode_paiement');
            $table->integer('score_priorite')->default(1)->after('reference_paiement');
        });
    }
    public function down(): void {}
};