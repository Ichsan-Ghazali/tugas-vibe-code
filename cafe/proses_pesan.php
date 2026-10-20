<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_menu = $_POST['id_menu'];
    $nama_pelanggan = htmlspecialchars($_POST['nama_pelanggan']);
    $no_meja = htmlspecialchars($_POST['no_meja']);
    $jumlah = $_POST['jumlah'];
    $harga_satuan = $_POST['harga_satuan'];
    
    // Hitung total di backend (keamanan agar tidak di-bypass via inspect element)
    $total_harga = $jumlah * $harga_satuan;
    $tanggal = date('Y-m-d H:i:s');

    $query_insert = "INSERT INTO pesanan (nama_pelanggan, no_meja, id_menu, jumlah, total_harga, tanggal_pesan) 
                     VALUES ('$nama_pelanggan', '$no_meja', '$id_menu', '$jumlah', '$total_harga', '$tanggal')";
                     
    if(mysqli_query($conn, $query_insert)) {
        echo "<script>alert('Pesanan berhasil dibuat!'); window.location.href='pesanan.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan sistem.'); window.history.back();</script>";
    }
}
?>