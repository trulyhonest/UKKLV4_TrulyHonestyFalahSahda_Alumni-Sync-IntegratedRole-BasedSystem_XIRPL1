<?php
session_start();
include 'koneksi.php';

if(isset($_GET['id_alumni'])){
    $id_alumni = $_GET['id_alumni'];

    mysqli_query($koneksi, "DELETE FROM alumni WHERE id_alumni=$id_alumni");
    header('location: dashboard_admin.php');
}
?>