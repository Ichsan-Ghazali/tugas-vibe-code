<?php require 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan - E-Order Cafe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="brand">E-Order Cafe</div>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="menu.php">Daftar Menu</a></li>
            <li><a href="pesanan.php">Daftar Pesanan</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1 class="page-title">Daftar Pesanan Masuk</h1>
        
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Waktu Pesan</th>
                        <th>Meja</th>
                        <th>Pelanggan</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "
                        SELECT p.*, m.nama_menu 
                        FROM pesanan p 
                        JOIN menu m ON p.id_menu = m.id 
                        ORDER BY p.tanggal_pesan DESC
                    ");
                    
                    if (mysqli_num_rows($query) == 0) {
                        echo "<tr><td colspan='7' style='text-align:center;'>Belum ada pesanan masuk.</td></tr>";
                    }

                    while ($row = mysqli_fetch_assoc($query)) {
                        $badge_color = ($row['status'] == 'Diproses') ? '#FEEBC8' : '#C6F6D5';
                        $text_color = ($row['status'] == 'Diproses') ? '#7B341E' : '#22543D';
                    ?>
                    <tr>
                        <td><?= date('d M Y H:i', strtotime($row['tanggal_pesan'])) ?></td>
                        <td><strong>Meja <?= $row['no_meja'] ?></strong></td>
                        <td><?= $row['nama_pelanggan'] ?></td>
                        <td><?= $row['nama_menu'] ?></td>
                        <td><?= $row['jumlah'] ?>x</td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                        <td>
                            <span style="background: <?= $badge_color ?>; color: <?= $text_color ?>; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.8rem; font-weight: bold;">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>