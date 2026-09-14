<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class ImportSanggaSeeder extends Seeder
{
    public function run()
    {
        Student::truncate();

        // Mengarah tepat ke folder storage/app/Data Kelas X Tahun 2026
        $folder = storage_path('app/Data Kelas X Tahun 2026');

        $files = [
            'PA' => $folder . DIRECTORY_SEPARATOR . 'ABSENSI PA.csv',
            'PI' => $folder . DIRECTORY_SEPARATOR . 'ABSENSI PI.csv',
        ];

        foreach ($files as $defaultAmbalan => $filePath) {
            if (!file_exists($filePath)) {
                $this->command->error("File CSV tidak ditemukan di: " . $filePath);
                continue;
            }

            $handle = fopen($filePath, 'r');
            $currentSangga = null;
            $currentSubSangga = null;
            $currentAmbalan = $defaultAmbalan;

            while (($line = fgets($handle)) !== FALSE) {
                $delimiter = str_contains($line, ';') ? ';' : ',';
                $data = str_getcsv($line, $delimiter);

                $cellA = isset($data[0]) ? trim($data[0]) : '';
                $cellB = isset($data[1]) ? trim($data[1]) : '';
                $cellC = isset($data[2]) ? trim($data[2]) : '';

                // Deteksi Judul Sangga
                if (preg_match('/^(PERINTIS|PENEGAS|PENCOBA|PENDOBRAK|PELAKSANA)\s+(\d+)\s*(PA|PI)?/i', $cellA, $matches)) {
                    $currentSangga = strtoupper($matches[1]);
                    $currentSubSangga = (string) $matches[2];
                    if (!empty($matches[3])) {
                        $currentAmbalan = strtoupper($matches[3]);
                    }
                    continue;
                }

                // Deteksi Baris Data Siswa
                if (is_numeric($cellA) && !empty($cellB) && strtolower($cellB) !== 'nama lengkap') {
                    if ($currentSangga && $currentSubSangga) {
                        Student::create([
                            'nama'       => $cellB,
                            'sangga'     => $currentSangga,
                            'sub_sangga' => $currentSubSangga,
                            'ambalan'    => $currentAmbalan,
                            'kelas_asal' => $cellC,
                        ]);
                    }
                }
            }

            fclose($handle);
            $this->command->info("Selesai mengimpor: " . basename($filePath));
        }
    }
}