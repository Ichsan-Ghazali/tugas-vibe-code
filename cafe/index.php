<?php 
require 'koneksi.php';

$total_menu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM menu"))['total'];
$total_pesanan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan"))['total'];
$pesanan_aktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status='Diproses'"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Pemesanan Cafe</title>
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
        <h1 class="page-title">Dashboard Restoran</h1>
        <div class="dashboard-grid">
            <div class="stat-card">
                <h3><?= $total_menu ?></h3>
                <p>Total Item Menu</p>
            </div>
            <div class="stat-card">
                <h3><?= $total_pesanan ?></h3>
                <p>Total Pesanan Masuk</p>
            </div>
            <div class="stat-card">
                <h3><?= $pesanan_aktif ?></h3>
                <p>Pesanan Sedang Diproses</p>
            </div>
        </div>
    </div>
</body>
</html>