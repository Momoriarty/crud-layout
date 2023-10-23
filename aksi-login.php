<?php
session_start();
include "config/koneksi.php";

// Inisiasi
$username = $_POST['username'];
$password = $_POST['password'];

// query cek username
$query = "SELECT * FROM muda_user WHERE username = '$username'";
$conn = mysqli_query($connection, $query);
$data = mysqli_fetch_array($conn);

// verify password
$pass = password_verify($password, $data['password']);

// cek apakah username ada
if (mysqli_num_rows($conn) > 0) {
    // cek password
    if ($password == $pass) {
        session_start();
        $_SESSION['namauser'] = $data['nama_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['level_user'] = $data['level'];

        header("location: media.php?module=home ");
    } else {
        session_start();
        $_SESSION["alert"] = "
        <div class='alert alert-warning' role='alert'>
        Password Salah
        </div>";

        header("location: login.php");
    }
} else {
    session_start();
    $_SESSION["alert"] = "
    <div class='alert alert-warning' role='alert'>
    Username Tidak ada
    </div>";

    header("location: login.php");
}
?>