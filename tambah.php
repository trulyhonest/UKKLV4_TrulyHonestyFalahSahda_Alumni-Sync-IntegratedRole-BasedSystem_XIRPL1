<?php
session_start();
include 'koneksi.php';

// Cek apakah yang akses adalah admin
if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: index.php");
    exit;
}

if(isset($_POST['simpan'])){
    // Menggunakan mysqli_real_escape_string agar lebih aman dari karakter aneh
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $angkatan = mysqli_real_escape_string($koneksi, $_POST['angkatan']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);

    // PERBAIKAN: Masukkan ke tabel 'alumni', bukan 'users'
    $query = mysqli_query($koneksi, "INSERT INTO alumni (nama, angkatan, jurusan) 
                                     VALUES ('$nama', '$angkatan', '$jurusan')");

    if($query){
        echo "<script>alert('Data Berhasil Disimpan!'); window.location='dashboard_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal Simpan: " . mysqli_error($koneksi) . "');</script>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Alumni</title>
    <link rel="stylesheet" href="style/tambah.css">
</head>
<body>

<div class="box">
    <h2>Tambah Data Alumni</h2>

    <form method="POST">
        <div class="form-group">
            <input type="text" name="nama" placeholder="Masukkan Nama Lengkap" required>
        </div>
        
        <div class="form-group">
            <input type="number" name="angkatan" placeholder="Masukkan Tahun Angkatan" required>
        </div>

        <div class="form-group">
            <select name="jurusan" required>
                <option value="" disabled selected>Pilih Jurusan</option>
                <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                <option value="Teknik Komputer Dan Jaringan">Teknik Komputer Dan Jaringan</option>
                <option value="Teknik Jaringan Akses Telekomunikasi">Teknik Jaringan Akses Telekomunikasi</option>
                <option value="Animasi">Animasi</option>
            </select>
        </div>

        <div class="button-group">
            <button type="submit" name="simpan" class="btn-save">Simpan Data</button>
            <a href="dashboard_admin.php" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>

</body>
</html>