<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(<<<SQL
            CREATE TABLE questions (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                exam_id BIGINT UNSIGNED NOT NULL,
                enunciado TEXT NOT NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        SQL);
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS questions');
    }
};
