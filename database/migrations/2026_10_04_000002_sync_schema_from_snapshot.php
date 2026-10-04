<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $path = database_path('schema_snapshot.json');
        if (! is_file($path)) {
            return;
        }

        $snapshot = json_decode(file_get_contents($path), true) ?: [];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($snapshot as $table => $info) {
            try {
                if (! Schema::hasTable($table)) {
                    DB::statement($info['create']);
                    continue;
                }

                foreach ($info['columns'] as $col) {
                    if (Schema::hasColumn($table, $col['name'])) {
                        continue;
                    }

                    $sql = "ALTER TABLE `{$table}` ADD COLUMN `{$col['name']}` {$col['type']}";
                    $sql .= $col['null'] ? ' NULL' : ' NOT NULL';

                    if ($col['default'] !== null) {
                        $isExpr = preg_match('/^current_timestamp/i', $col['default']) === 1;
                        $sql .= ' DEFAULT '.($isExpr ? $col['default'] : DB::getPdo()->quote($col['default']));
                    } elseif ($col['null']) {
                        $sql .= ' DEFAULT NULL';
                    }

                    DB::statement($sql);
                }
            } catch (\Throwable $e) {
                Log::warning("Sinkron struktur {$table} gagal: ".$e->getMessage());
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void
    {
        // dibiarkan kosong agar data tidak hilang
    }
};