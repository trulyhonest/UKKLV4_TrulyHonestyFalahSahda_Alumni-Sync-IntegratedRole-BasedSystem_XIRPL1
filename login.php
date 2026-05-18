<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
    die("Query Error: " . mysqli_error($koneksi));
}

    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        
        if($password == $data['password']){
            $_SESSION['login'] = true;
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];

            if($data['role'] == 'admin'){
                header('location: dashboard_admin.php');
            } else {
                header('location: dashboard_user.php');
            }
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.location.href='login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location.href='login.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style/index.css">
</head>

<body>

<div class="box">
    <img src="img/tel-damni.png" alt="Logo Sekolah" class="logo">
    
    <form action="" method="POST">
    
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Masukkan Username" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Masukkan Password" required>
        </div>

        <button type="submit" name="login">Masuk</button>

    </form>

    <p class="daftar">
        Belum memiliki akun? <a href="register.php">Daftar Sekarang</a>
    </p>

</div>
</body>
</html>