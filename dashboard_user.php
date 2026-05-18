<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'user'){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manajemen Data Alumni</title>
<link rel="stylesheet" href="style/dashboard.css">
</head>
<body>

<header class="navbar-simple">
    <div class="nav-container">
        <h2>Manajemen Data Alumni</h2>
        
        <div class="nav-right">
            <span><?= $_SESSION['username'] ?> (<b><?= $_SESSION['role'] ?></b>)</span>
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
    <div class="header-title-area">
        <h3>Data Alumni</h3>
        <span class="role-subtitle"><?= $_SESSION['role'] ?></span>
    </div>

    <div class="action-bar">
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Cari nama / jurusan..." 
                value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
            <button type="submit">Cari</button>
        </form>
    </div>
</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Angkatan</th>
                    <th>Jurusan</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;
                $search = isset($_GET['search']) ? $_GET['search'] : '';

                if ($search != '') {
                    // Mencari berdasarkan nama, jurusan, atau angkatan
                    // HAPUS bagian ORDER BY jika menyebabkan error
                    $query = "SELECT * FROM alumni 
                            WHERE nama LIKE '%$search%' 
                            OR jurusan LIKE '%$search%' 
                            OR angkatan LIKE '%$search%'";
                } else {
                    // Tampilkan semua data alumni
                    $query = "SELECT * FROM alumni";
                }

                $data = mysqli_query($koneksi, $query);

                while ($d = mysqli_fetch_array($data)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $d['nama'] ?></td>
                        <td><?= $d['angkatan'] ?></td>
                        <td><?= $d['jurusan'] ?></td>
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