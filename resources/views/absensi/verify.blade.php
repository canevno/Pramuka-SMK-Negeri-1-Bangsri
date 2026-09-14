<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Petugas Absensi</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f1f5f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #ffffff; padding: 2.5rem; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); width: 100%; max-width: 400px; }
        .title { font-size: 1.5rem; font-weight: bold; color: #1e293b; text-align: center; margin-bottom: 0.5rem; }
        .subtitle { font-size: 0.875rem; color: #64748b; text-align: center; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.75rem; font-weight: bold; color: #475569; text-transform: uppercase; margin-bottom: 0.35rem; }
        input { width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.875rem; outline: none; }
        input:focus { border-color: #d97706; box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.2); }
        .btn { width: 100%; padding: 0.75rem; background-color: #d97706; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.2s; }
        .btn:hover { background-color: #b45309; }
        .alert { background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem; border-radius: 6px; font-size: 0.85rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="card">
        <div class="title">Verifikasi Petugas</div>
        <div class="subtitle">Sistem Absensi Pramuka</div>

        @if (session('absensi_verify_error'))
            <div class="alert">{{ session('absensi_verify_error') }}</div>
        @endif

        <form action="{{ route('absensi.verify') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap Petugas</label>
                <input type="text" name="name" required placeholder="Ahmad Subardjo">
            </div>
            <div class="form-group">
                <label>Kelas Petugas</label>
                <input type="text" name="kelas" required placeholder="XII PPLG 1">
            </div>
            <div class="form-group">
                <label>NTA Petugas</label>
                <input type="text" name="nta" required placeholder="11.22.3344">
            </div>
            <button type="submit" class="btn">Verifikasi & Masuk</button>
        </form>
    </div>
</body>
</html>