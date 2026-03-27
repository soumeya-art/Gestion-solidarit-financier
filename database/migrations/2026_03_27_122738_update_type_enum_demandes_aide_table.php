<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::statement("ALTER TABLE demandes_aide MODIFY COLUMN type ENUM('medicale', 'deces', 'scolaire', 'logement', 'catastrophe', 'naissance', 'autre') NOT NULL");
    }

    public function down(): void {
        DB::statement("ALTER TABLE demandes_aide MODIFY COLUMN type ENUM('medicale', 'deces', 'scolaire', 'autre') NOT NULL");
    }
};
