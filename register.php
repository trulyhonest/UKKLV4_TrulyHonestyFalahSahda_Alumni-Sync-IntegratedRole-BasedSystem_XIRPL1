<?php
include 'koneksi.php';

if (isset($_POST['register'])) {

    // MEMPERBAIKI VARIABEL YANG TERTUKAR
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $angkatan = mysqli_real_escape_string($koneksi, $_POST['angkatan']);
    $jurusan  = mysqli_real_escape_string($koneksi, $_POST['jurusan']);

    // 1. Cek apakah username sudah ada di tabel users
    $cek = mysqli_query($koneksi, "SELECT username FROM users WHERE username='$username'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah dipakai!'); window.location.href='register.php';</script>";
        exit;
    } else {
        // 2. Masukkan data akun ke tabel 'users' dengan role 'user' (Cocok dengan ENUM)
        $query_user = "INSERT INTO users (username, password, role) 
                       VALUES ('$username', '$password', 'user')";

        if (mysqli_query($koneksi, $query_user)) {
            // 3. Masukkan data profil ke tabel 'alumni'
            $query_alumni = "INSERT INTO alumni (nama, angkatan, jurusan) 
                             VALUES ('$nama', '$angkatan', '$jurusan')";
            
            mysqli_query($koneksi, $query_alumni);

            echo "<script>alert('Register berhasil!'); window.location.href='login.php';</script>";
            exit;
        } else {
            echo "<script>alert('Register gagal!'); window.location.href='register.php';</script>";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style/index.css">
</head>

<body>

<div class="box">
    <img src="img/tel-damni.png" alt="Logo Sekolah" class="logo">
    
    <form action="" method="POST">

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan Username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan Password" required>
        </div>

         <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Masukkan Nama" required>
        </div>

        <div class="form-group">
            <label>Tahun Angkatan</label>
            <input type="number" name="angkatan" placeholder="Masukkan Angkatan" required>
        </div>

        <div class="form-group">
            <label for="jurusan">Jurusan</label>
            <select name="jurusan" id="jurusan" required>
                <option value="" disabled selected>Pilih Jurusan</option>
                <option value="RPL">Rekayasa Perangkat Lunak</option>
                <option value="TKJ">Teknik Komputer Dan Jaringan</option>
                <option value="TJAT">Teknik Jaringan Akses Telekomunikasi</option>
                <option value="ANIMASI">ANIMASI</option>
            </select>
        </div>

        <button type="submit" name="register">Daftar</button>

        <p class="login">
            Sudah punya akun? <a href="login.php">Login</a>
        </p>

    </form>
</div>

</body>
</html>