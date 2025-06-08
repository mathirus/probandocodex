<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(<<<SQL
            CREATE TABLE exams (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                titulo VARCHAR(255) NOT NULL,
                fecha_inicio DATE NOT NULL,
                fecha_fin DATE NOT NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        SQL);
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS exams');
    }
};
