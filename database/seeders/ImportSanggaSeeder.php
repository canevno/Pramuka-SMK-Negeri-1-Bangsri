<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportSanggaSeeder extends Seeder
{
    public function run(): void
    {
        $files = [
            [
                'path' => storage_path('app/Data Kelas X Tahun 2026/ABSENSI PA.csv'),
                'ambalan' => 'PA',
            ],
            [
                'path' => storage_path('app/Data Kelas X Tahun 2026/ABSENSI PI.csv'),
                'ambalan' => 'PI',
            ],
        ];

        foreach ($files as $file) {
            $filePath = $file['path'];
            $ambalan  = $file['ambalan'];

            if (!file_exists($filePath)) {
                continue;
            }

            if (($handle = fopen($filePath, 'r')) !== false) {
                // Deteksi otomatis pembatas kolom (koma atau titik koma)
                $firstLine = fgets($handle);
                $delimiter = (strpos($firstLine, ';') !== false) ? ';' : ',';
                rewind($handle);

                // Melewati baris pertama (Header CSV)
                fgetcsv($handle, 1000, $delimiter);

                while (($data = fgetcsv($handle, 1000, $delimiter)) !== false) {
                    $nama = trim($data[1] ?? '');

                    // Mengabaikan baris kosong atau header tabel
                    if (!empty($nama) && !in_array(strtolower($nama), ['nama', 'nama siswa', 'nama lengkap'])) {
                        DB::table('students')->insert([
                            'nama'       => $nama,
                            'kelas_asal' => trim($data[2] ?? ''),
                            'sangga'     => trim($data[3] ?? ''),
                            'sub_sangga' => trim($data[4] ?? ''),
                            'ambalan'    => $ambalan,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
                fclose($handle);
            }
        }
    }
}