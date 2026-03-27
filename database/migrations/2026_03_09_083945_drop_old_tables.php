<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::dropIfExists('remboursements');
        Schema::dropIfExists('prets');
        Schema::dropIfExists('adhesions');
        Schema::table('cotisations', function($table) {
            $table->dropForeign(['groupe_id']);
            $table->dropColumn('groupe_id');
        });
        Schema::table('demandes_aide', function($table) {
            $table->dropForeign(['groupe_id']);
            $table->dropColumn('groupe_id');
        });
        Schema::dropIfExists('regles_groupe');
        Schema::dropIfExists('fonds_commun');
        Schema::dropIfExists('groupes_solidarite');
    }
    public function down(): void {}
};