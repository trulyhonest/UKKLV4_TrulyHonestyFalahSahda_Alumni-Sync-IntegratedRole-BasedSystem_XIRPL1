<?php
session_start();
include 'koneksi.php';

// 1. Cek Login & Role
if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: index.php");
    exit;
}

// 2. Ambil ID dari URL (Pastikan link di dashboard pakai ?id_alumni=...)
if(!isset($_GET['id_alumni'])){
    header("Location: dashboard_admin.php");
    exit;
}

$id = $_GET['id_alumni'];

// 3. Ambil data lama dari tabel alumni
$data = mysqli_query($koneksi, "SELECT * FROM alumni WHERE id_alumni='$id'");
$d = mysqli_fetch_assoc($data);

// 4. Proses Update jika tombol ditekan
if(isset($_POST['update'])){
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $angkatan = mysqli_real_escape_string($koneksi, $_POST['angkatan']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);

    $query_update = "UPDATE alumni SET 
                    nama='$nama', 
                    angkatan='$angkatan', 
                    jurusan='$jurusan' 
                    WHERE id_alumni='$id'";

    if(mysqli_query($koneksi, $query_update)){
        echo "<script>alert('Data berhasil diupdate!'); window.location='dashboard_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal update data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Alumni</title>
    <link rel="stylesheet" href="style/edit.css">
</head>
<body>
    <div class="box">
        <h2>Edit Data Alumni</h2>
        <form method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?= $d['nama'] ?>" required>
            </div>

            <div class="form-group">
                <label>Tahun Angkatan</label>
                <input type="number" name="angkatan" value="<?= $d['angkatan'] ?>" required>
            </div>

            <div class="form-group">
                <label>Jurusan</label>
                <select name="jurusan" required>
                    <option value="Rekayasa Perangkat Lunak" <?= $d['jurusan']=="Rekayasa Perangkat Lunak"?"selected":"" ?>>Rekayasa Perangkat Lunak</option>
                    <option value="Teknik Komputer dan Jaringan" <?= $d['jurusan']=="Teknik Komputer dan Jaringan"?"selected":"" ?>>Teknik Komputer dan Jaringan</option>
                    <option value="Animasi" <?= $d['jurusan']=="Animasi"?"selected":"" ?>>Animasi</option>
                    <option value="Teknik Jaringan Akses Telekomunikasi" <?= $d['jurusan']=="Teknik Jaringan Akses Telekomunikasi"?"selected":"" ?>>Teknik Jaringan Akses Telekomunikasi</option>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" name="update">Simpan Perubahan</button>
                <a href="dashboard_admin.php" class="btn-batal">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>