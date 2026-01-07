<?php
$title = 'Laporan Keuangan Anak';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Anak - <?= date('d M Y') ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.4;
        }

        .header {
            background: linear-gradient(135deg, #0A2547 0%, #133D57 100%);
            color: white;
            padding: 25px;
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
            opacity: 0.9;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
            color: #475569;
        }

        .info-value {
            color: #1e293b;
        }

        .section-title {
            background: #0A2547;
            color: white;
            padding: 10px 15px;
            font-size: 13px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th {
            background: #334155;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e2e8f0;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-green {
            color: #10b981;
        }

        .text-red {
            color: #ef4444;
        }

        .text-blue {
            color: #3b82f6;
        }

        .summary-box {
            display: inline-block;
            width: 20%;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin-right: 2%;
            vertical-align: top;
        }

        .summary-green {
            background: #ecfdf5;
            border: 1px solid #10b981;
        }

        .summary-red {
            background: #fef2f2;
            border: 1px solid #ef4444;
        }

        .summary-blue {
            background: #eff6ff;
            border: 1px solid #3b82f6;
        }

        .summary-box h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .summary-box p {
            font-size: 10px;
            color: #64748b;
        }

        .footer {
            margin-top: 40px;
            padding: 20px 0;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
        }

        .child-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .child-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #0A2547;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .child-name {
            font-size: 14px;
            font-weight: bold;
            color: #0A2547;
        }

        .child-nim {
            font-size: 10px;
            color: #64748b;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-hemat {
            background: #dcfce7;
            color: #166534;
        }

        .badge-normal {
            background: #fef9c3;
            color: #854d0e;
        }

        .badge-boros {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>ðŸ“Š Laporan Keuangan Anak</h1>
        <p>Sistem Keuangan Mahasiswa</p>
    </div>

    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Nama Orang Tua:</span>
            <span class="info-value"><?= e($orangtua['nama']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value"><?= e($orangtua['email']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Cetak:</span>
            <span class="info-value"><?php date_default_timezone_set('Asia/Jakarta'); echo date('d F Y, H:i'); ?> WIB</span>
        </div>
        <div class="info-row">
            <span class="info-label">Jumlah Anak:</span>
            <span class="info-value"><?= count($children) ?> anak terhubung</span>
        </div>
    </div>

    <?php
    $totalPemasukan = 0;
    $totalPengeluaran = 0;
    $totalSaldo = 0;
    foreach ($children as $child):
        $totalPemasukan += $child['stats']['pemasukan'];
        $totalPengeluaran += $child['stats']['pengeluaran'];
        $totalSaldo += $child['saldo'];
        ?>
        <div class="child-card">
            <div class="child-header">
                <div>
                    <div class="child-name"><?= e($child['nama']) ?></div>
                    <div class="child-nim">NIM: <?= e($child['nim']) ?> | <?= e($child['jurusan']) ?></div>
                </div>
                <div>
                    <?php
                    $status = $child['stats']['status'] ?? 'normal';
                    $badgeClass = $status === 'hemat' ? 'badge-hemat' : ($status === 'boros' ? 'badge-boros' : 'badge-normal');
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= strtoupper($status) ?></span>
                </div>
            </div>

            <table>
                <tr>
                    <td style="width: 25%">
                        <strong>Saldo Saat Ini</strong><br>
                        <span class="text-blue" style="font-size: 14px; font-weight: bold;">
                            Rp <?= number_format($child['saldo'], 0, ',', '.') ?>
                        </span>
                    </td>
                    <td style="width: 25%">
                        <strong>Total Pemasukan</strong><br>
                        <span class="text-green" style="font-size: 14px; font-weight: bold;">
                            Rp <?= number_format($child['stats']['pemasukan'], 0, ',', '.') ?>
                        </span>
                    </td>
                    <td style="width: 25%">
                        <strong>Total Pengeluaran</strong><br>
                        <span class="text-red" style="font-size: 14px; font-weight: bold;">
                            Rp <?= number_format($child['stats']['pengeluaran'], 0, ',', '.') ?>
                        </span>
                    </td>
                    <td style="width: 25%">
                        <strong>Rasio Pengeluaran</strong><br>
                        <span style="font-size: 14px; font-weight: bold;">
                            <?= $child['stats']['ratio'] ?? 0 ?>%
                        </span>
                    </td>
                </tr>
            </table>

            <?php if (!empty($child['transaksi'])): ?>
                <div style="font-size: 11px; font-weight: bold; margin: 10px 0 5px 0; color: #475569;">
                    Transaksi Terbaru (5 terakhir)
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 15%">Tanggal</th>
                            <th style="width: 25%">Kategori</th>
                            <th style="width: 10%">Tipe</th>
                            <th style="width: 20%" class="text-right">Jumlah</th>
                            <th style="width: 30%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($child['transaksi'], 0, 5) as $trx): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($trx['tanggal'])) ?></td>
                                <td><?= e($trx['kategori_nama']) ?></td>
                                <td>
                                    <span class="<?= $trx['tipe'] === 'pemasukan' ? 'text-green' : 'text-red' ?>">
                                        <?= ucfirst($trx['tipe']) ?>
                                    </span>
                                </td>
                                <td class="text-right <?= $trx['tipe'] === 'pemasukan' ? 'text-green' : 'text-red' ?>">
                                    <?= $trx['tipe'] === 'pemasukan' ? '+' : '-' ?> Rp
                                    <?= number_format($trx['jumlah_idr'], 0, ',', '.') ?>
                                </td>
                                <td><?= e($trx['keterangan'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <div class="section-title">ðŸ“ˆ Ringkasan Total</div>

   <div style="margin: 15px 0 30px 0; text-align: center;">
        <div class="summary-box summary-green">
            <h3 class="text-green">Rp <?= number_format($totalPemasukan, 0, ',', '.') ?></h3>
            <p>Total Pemasukan Semua Anak</p>
        </div>
        <div class="summary-box summary-red">
            <h3 class="text-red">Rp <?= number_format($totalPengeluaran, 0, ',', '.') ?></h3>
            <p>Total Pengeluaran Semua Anak</p>
        </div>
        <div class="summary-box summary-blue" style="margin-right: 0;">
            <h3 class="text-blue">Rp <?= number_format($totalSaldo, 0, ',', '.') ?></h3>
            <p>Total Saldo Semua Anak</p>
        </div>
    </div>

    <div class="footer">
        Dokumen ini digenerate otomatis oleh Sistem Keuangan Mahasiswa | <?= date('Y') ?>
    </div>
</body>

</html>