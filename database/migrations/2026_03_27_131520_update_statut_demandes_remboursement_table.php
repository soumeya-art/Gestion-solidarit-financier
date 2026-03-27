<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::statement("ALTER TABLE demandes_remboursement MODIFY COLUMN statut ENUM('en_attente', 'approuve', 'paye', 'refuse') DEFAULT 'en_attente'");
    }

    public function down(): void {
        DB::statement("ALTER TABLE demandes_remboursement MODIFY COLUMN statut ENUM('en_attente', 'approuve', 'refuse') DEFAULT 'en_attente'");
    }
};
