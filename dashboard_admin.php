<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style/dashboard.css">
</head>
<body>

<header class="navbar-simple">
    <div class="nav-container">
        <h2>Manajemen Data Alumni</h2>
        
        <div class="nav-right">
            <span class="user-name"><b><?= $_SESSION['role'] ?></b></span>
            <a href="logout.php" class="btn-logout-minimal">LOGOUT</a>
        </div>
    </div>
</header>

<script>
function toggleDropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}

window.onclick = function(event) {
  if (!event.target.closest('.avatar-container')) {
    document.getElementById("myDropdown").classList.remove("show");
  }
}
</script>

<div class="container">
    <div class="card">

        <div class="card-header">
            <h3>Data Alumni</h3>

            <div class="action-bar">
                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari nama / jurusan..." 
                           value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                    <button type="submit">Cari</button>
                </form>

                <a class="tambah" href="tambah.php">+ Tambah Data</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Angkatan</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>


            <?php
            
            $no = 1;
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            if ($search != '') {
                // Mencari di tabel alumni berdasarkan nama, jurusan, atau angkatan
                $data = mysqli_query($koneksi, "SELECT * FROM alumni 
                        WHERE nama LIKE '%$search%' 
                        OR jurusan LIKE '%$search%' 
                        OR angkatan LIKE '%$search%'");
            } else {
                // Menampilkan semua data dari tabel alumni
                $data = mysqli_query($koneksi, "SELECT * FROM alumni");
            }

            while ($d = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $d['nama'] ?></td>
                    <td><?= $d['angkatan'] ?></td>
                    <td><?= $d['jurusan'] ?></td>
                    <td>
                        <a class="edit" href="edit.php?id_alumni=<?= $d['id_alumni'] ?>">Edit</a>
                        <a class="hapus" href="delete.php?id_alumni=<?= $d['id_alumni'] ?>" onclick="return confirm('Hapus data?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>

    </div>
</div>

<footer>
    &copy; <?= date('Y') ?> Truly Honesty Falah Sahda - All Rights Reserved
</footer>

</body>
</html>