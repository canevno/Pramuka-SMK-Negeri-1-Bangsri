Transform Absensi — Petunjuk singkat

Persyaratan:
- Python 3.8+
- Paket: `pandas`, `openpyxl`

Instal paket:

```bash
pip install pandas openpyxl
```

Contoh pemakaian:

1) Transform CSV absensi PI (format seperti `ABSENSI PI.csv` di folder `storage`):

```bash
python scripts/transform_absensi.py --input "storage/app/Data Kelas X Tahun 2026/ABSENSI PI.csv" --role PI --output output/pi
```

2) Jika Anda juga memiliki file mapping Excel (`Absensi PA.xlsx` / `Absensi PI.xlsx`) yang berisi kolom nama, sangga, sub-sangga, gender, jalankan:

```bash
python scripts/transform_absensi.py --input "ABSENSI PI.csv" --mapping "Absensi PI.xlsx" --role PI --output output/pi
```

Hasil:
- `all_transformed.xlsx` — semua entri dengan kolom `Sangga` / `SubSangga` / `Gender`
- `putra.xlsx` — hanya baris dengan `Gender` = Putra
- `putri.xlsx` — hanya baris dengan `Gender` = Putri

Jika Anda mau, saya bisa langsung menjalankan skrip ini sekarang jika Anda mengunggah atau meletakkan file `Absensi PA.xlsx` dan `Absensi PI.xlsx` di folder workspace, atau beri tahu jalur file mapping Anda.
