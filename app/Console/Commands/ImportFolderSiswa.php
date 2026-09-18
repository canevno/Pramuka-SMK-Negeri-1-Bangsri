<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportFolderSiswa extends Command
{
    // Pastikan properti ini terisi nama command dan tidak kosong
    protected $signature = 'import:folder-siswa';

    protected $description = 'Import data siswa dari folder';

    public function handle()
    {
        // logika command kamu
    }
}
