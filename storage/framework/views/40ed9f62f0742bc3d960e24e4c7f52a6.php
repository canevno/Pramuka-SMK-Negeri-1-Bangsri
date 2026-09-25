<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <?php
        // Hitung rekapan status kehadiran
        $hadirCount = $records->filter(fn($r) => trim(strtolower($r->status ?? '')) === 'hadir')->count();
        $izinCount  = $records->filter(fn($r) => trim(strtolower($r->status ?? '')) === 'izin')->count();
        $sakitCount = $records->filter(fn($r) => trim(strtolower($r->status ?? '')) === 'sakit')->count();
        $alphaCount = $records->filter(fn($r) => in_array(trim(strtolower($r->status ?? '')), ['alpha', 'alpa', '-', '']))->count();
        
        $ambalanClean = trim($ambalan ?? '');
        $kelasClean   = trim($kelas ?? '-');

        $calculatedTotalKas = 0;
    ?>

    <table>
        <!-- Header Judul -->
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold; font-size: 14pt; font-family: 'Times New Roman';">
                ABSENSI MINGGUAN <?php echo e(strtoupper($ambalanClean)); ?>

            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold; font-size: 14pt; font-family: 'Times New Roman';">
                KELAS <?php echo e(strtoupper($kelasClean)); ?>

            </td>
        </tr>
        <tr><td colspan="4"></td></tr>
        <tr>
            <td colspan="4" style="font-weight: bold; font-size: 11pt; font-family: 'Times New Roman';">
                Tanggal : <?php echo e($date ? \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('d F Y') : '-'); ?>

            </td>
        </tr>
        <tr><td colspan="4"></td></tr>

        <!-- Table Header (Inline Style Kuning di Setiap TH) -->
        <thead>
            <tr>
                <th style="background-color: #FFFF00; border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle; width: 50px; font-family: 'Times New Roman';">No</th>
                <th style="background-color: #FFFF00; border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle; width: 250px; font-family: 'Times New Roman';">Nama Peserta</th>
                <th style="background-color: #FFFF00; border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle; width: 120px; font-family: 'Times New Roman';">Status Kehadiran</th>
                <th style="background-color: #FFFF00; border: 1px solid #000000; font-weight: bold; text-align: center; vertical-align: middle; width: 150px; font-family: 'Times New Roman';">Pembayaran Kas</th>
            </tr>
        </thead>

        <!-- Data Anggota -->
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $iuranRaw = trim((string)($r->nominal_iuran ?? $r->iuran ?? '0'));
                $isBayar = in_array(strtolower($iuranRaw), ['ya', '2000', '1', 'true']);
                $nominal = $isBayar ? 2000 : (is_numeric($iuranRaw) ? (int)$iuranRaw : 0);
                
                $calculatedTotalKas += $nominal;

                $statusRaw = trim($r->status ?? '');
                $statusClean = in_array(strtolower($statusRaw), ['alpha', 'alpa', '-', '']) ? 'Alpha' : ucfirst(strtolower($statusRaw));
            ?>
            <tr>
                <td style="border: 1px solid #000000; text-align: center; vertical-align: middle; font-family: 'Times New Roman';"><?php echo e($index + 1); ?></td>
                <td style="border: 1px solid #000000; text-align: left; vertical-align: middle; font-family: 'Times New Roman';"><?php echo e(trim($r->participant_name ?? $r->nama_siswa ?? 'Tanpa Nama')); ?></td>
                <td style="border: 1px solid #000000; text-align: center; vertical-align: middle; font-family: 'Times New Roman';"><?php echo e($statusClean); ?></td>
                <td style="border: 1px solid #000000; text-align: right; vertical-align: middle; font-family: 'Times New Roman';"><?php echo e($nominal); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>

        <!-- Total Uang Kas & Rekapitulasi (Kuning Hanya di Dalam Sel A-D) -->
        <tfoot>
            <tr>
                <td colspan="3" style="background-color: #FFFF00; border: 1px solid #000000; font-weight: bold; text-align: right; vertical-align: middle; font-family: 'Times New Roman';">TOTAL UANG KAS TERKUMPUL</td>
                <td style="background-color: #FFFF00; border: 1px solid #000000; font-weight: bold; text-align: right; vertical-align: middle; font-family: 'Times New Roman';">Rp <?php echo e(number_format($totalUang ?? $calculatedTotalKas, 0, ',', '.')); ?></td>
            </tr>

            <!-- Spasi Pembatas -->
            <tr><td colspan="4"></td></tr>
            <tr><td colspan="4"></td></tr>

            <!-- Ringkasan Rekap Kehadiran Peserta -->
            <tr>
                <td colspan="4" style="font-weight: bold; font-size: 11pt; font-family: 'Times New Roman';">REKAPITULASI KEHADIRAN PESERTA</td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #000000; font-family: 'Times New Roman';">Hadir</td>
                <td colspan="2" style="border: 1px solid #000000; text-align: center; font-family: 'Times New Roman';"><?php echo e($hadirCount); ?> Peserta</td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #000000; font-family: 'Times New Roman';">Izin</td>
                <td colspan="2" style="border: 1px solid #000000; text-align: center; font-family: 'Times New Roman';"><?php echo e($izinCount); ?> Peserta</td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #000000; font-family: 'Times New Roman';">Sakit</td>
                <td colspan="2" style="border: 1px solid #000000; text-align: center; font-family: 'Times New Roman';"><?php echo e($sakitCount); ?> Peserta</td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #000000; font-family: 'Times New Roman';">Alpha</td>
                <td colspan="2" style="border: 1px solid #000000; text-align: center; font-family: 'Times New Roman';"><?php echo e($alphaCount); ?> Peserta</td>
            </tr>
            <tr>
                <td colspan="2" style="background-color: #FFFF00; border: 1px solid #000000; font-weight: bold; font-family: 'Times New Roman';">TOTAL ANGGOTA</td>
                <td colspan="2" style="background-color: #FFFF00; border: 1px solid #000000; font-weight: bold; text-align: center; font-family: 'Times New Roman';"><?php echo e($records->count()); ?> Peserta</td>
            </tr>
        </tfoot>
    </table>
</body>
</html><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\exports\kas_excel.blade.php ENDPATH**/ ?>