<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('regles_groupe', function (Blueprint $table) {
            if (!Schema::hasColumn('regles_groupe', 'plafond_aide')) {
                $table->decimal('plafond_aide', 15, 2)->default(50000);
            }
        });
    }
    public function down(): void {}
};