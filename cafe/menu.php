<?php require 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu - E-Order Cafe</title>
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
        <h1 class="page-title">Katalog Menu</h1>
        
        <div class="controls">
            <input type="text" id="searchInput" placeholder="Cari nama menu...">
            <select id="kategoriFilter">
                <option value="all">Semua Kategori</option>
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
                <option value="Cemilan">Cemilan</option>
            </select>
        </div>

        <div class="item-grid" id="menuGrid">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM menu ORDER BY nama_menu ASC");
            while ($row = mysqli_fetch_assoc($query)) {
                $status_class = $row['tersedia'] ? 'tersedia' : 'habis';
                $status_text = $row['tersedia'] ? 'Tersedia' : 'Habis';
                $btn_state = $row['tersedia'] ? '' : 'disabled';
            ?>
            <div class="item-card" data-nama="<?= strtolower($row['nama_menu']) ?>" data-kategori="<?= $row['kategori'] ?>">
                <div>
                    <span class="tag <?= $status_class ?>"><?= $status_text ?></span>
                    <h3><?= $row['nama_menu'] ?></h3>
                    <p style="color: #718096; font-size: 0.9rem;"><?= $row['deskripsi'] ?></p>
                    <div class="price">Rp <?= number_format($row['harga'], 0, ',', '.') ?></div>
                </div>
                <button class="btn" <?= $btn_state ?> onclick="bukaModal(<?= $row['id'] ?>, '<?= addslashes($row['nama_menu']) ?>', <?= $row['harga'] ?>)">Buat Pesanan</button>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- Modal Form Pemesanan -->
    <div class="modal" id="pesanModal">
        <div class="modal-content">
            <span class="close-modal" onclick="tutupModal()">&times;</span>
            <h2 style="margin-bottom: 1.5rem;">Form Pemesanan</h2>
            <form action="proses_pesan.php" method="POST">
                <input type="hidden" name="id_menu" id="id_menu">
                <input type="hidden" name="harga_satuan" id="harga_satuan">
                
                <div class="form-group">
                    <label>Menu Dipilih</label>
                    <input type="text" id="nama_menu_tampil" readonly style="background: #edf2f7;">
                </div>
                <div class="form-group">
                    <label>Nama Pemesan</label>
                    <input type="text" name="nama_pelanggan" required placeholder="Nama Anda">
                </div>
                <div class="form-group">
                    <label>Nomor Meja</label>
                    <input type="number" name="no_meja" required placeholder="Contoh: 12">
                </div>
                <div class="form-group">
                    <label>Jumlah Pesanan</label>
                    <input type="number" name="jumlah" id="jumlah" required min="1" value="1" oninput="hitungTotal()">
                </div>
                <div class="form-group">
                    <label>Total Harga</label>
                    <input type="text" id="total_harga_tampil" readonly style="background: #edf2f7; font-weight: bold; color: var(--primary-color);">
                </div>
                <button type="submit" class="btn">Kirim Pesanan</button>
            </form>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const filterSelect = document.getElementById('kategoriFilter');
        const cards = document.querySelectorAll('.item-card');

        function filterMenu() {
            const query = searchInput.value.toLowerCase();
            const kategori = filterSelect.value;
            cards.forEach(card => {
                const nama = card.getAttribute('data-nama');
                const cat = card.getAttribute('data-kategori');
                const matchSearch = nama.includes(query);
                const matchCat = kategori === 'all' || cat === kategori;
                card.style.display = (matchSearch && matchCat) ? 'flex' : 'none';
            });
        }
        searchInput.addEventListener('input', filterMenu);
        filterSelect.addEventListener('change', filterMenu);

        // Modal & Perhitungan Total Harga
        const modal = document.getElementById('pesanModal');
        let hargaAktif = 0;

        function bukaModal(id, nama, harga) {
            document.getElementById('id_menu').value = id;
            document.getElementById('nama_menu_tampil').value = nama;
            document.getElementById('harga_satuan').value = harga;
            document.getElementById('jumlah').value = 1;
            hargaAktif = harga;
            hitungTotal();
            modal.classList.add('active');
        }
        
        function hitungTotal() {
            const jumlah = document.getElementById('jumlah').value;
            const total = jumlah * hargaAktif;
            document.getElementById('total_harga_tampil').value = 'Rp ' + total.toLocaleString('id-ID');
        }

        function tutupModal() { modal.classList.remove('active'); }
        window.onclick = function(event) { if (event.target == modal) tutupModal(); }
    </script>
</body>
</html>