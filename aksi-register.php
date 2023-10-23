<?php
include "config/koneksi.php";

// Inisialisasi
$nama = $_POST['nama_user'];
$username = $_POST['username'];
$pass = $_POST['password'];
$level = $_POST['level'];
$konfirmasi_password = $_POST['konfirmasi_password'];

// Hashing password menggunakan bcrypt
$password = password_hash($pass, PASSWORD_BCRYPT);

// Memeriksa apakah nama pengguna sudah ada dalam database
$query_check_nama = "SELECT * FROM muda_user WHERE nama_user = '$nama'";
$result_check_nama = $connection->query($query_check_nama);

// Memeriksa apakah username sudah ada dalam database
$query_check_username = "SELECT * FROM muda_user WHERE username = '$username'";
$result_check_username = $connection->query($query_check_username);

if ($result_check_nama->num_rows > 0) {
    // Jika nama pengguna sudah ada dalam database
    session_start();
    $_SESSION["alert"] = "
        <div class='alert alert-danger' role='alert'>
        Nama pengguna sudah digunakan!
        </div>";

    header("location: register.php");
    // Atau lakukan tindakan lain seperti pengalihan atau pengiriman pesan kesalahan
} elseif ($result_check_username->num_rows > 0) {
    // Jika username sudah ada dalam database
    session_start();
    $_SESSION["alert"] = "
        <div class='alert alert-danger' role='alert'>
        Username sudah digunakan!
        </div>";

    header("location: register.php");
    // Atau lakukan tindakan lain seperti pengalihan atau pengiriman pesan kesalahan
} elseif (!password_verify($konfirmasi_password, $password)) {
    // Jika konfirmasi password tidak sesuai
    session_start();
    $_SESSION["alert"] = "
        <div class='alert alert-danger' role='alert'>
        Konfirmasi password tidak sesuai!
        </div>";

    header("location: register.php");
    // Atau lakukan tindakan lain seperti pengalihan atau pengiriman pesan kesalahan
} else {
    // Lakukan tindakan lainnya, misalnya menyimpan data ke database

    // Query untuk memasukkan data ke database
    $query = "INSERT INTO muda_user (nama_user, username, password, level, is_active)
    VALUES ('$nama', '$username', '$password', '$level', '1')";

    // Eksekusi query
    if ($connection->query($query)) {
        // Pendaftaran berhasil

        // Contoh: Menyimpan data ke file teks
        $data = "Nama: $nama\nEmail: $username\nPassword: $password\n\n";
        file_put_contents('pendaftar.txt', $data, FILE_APPEND);

        session_start();
        $_SESSION["alert"] = "
        <div class='alert alert-danger' role='alert'>
        Pendaftaran Berhasil
        </div>";

        header("location: login.php");

        // Atau lakukan tindakan lain seperti pengalihan ke halaman sukses
    } else {
        // Jika query gagal dieksekusi
        echo "Gagal menyimpan data pendaftaran!";
    }
}
?>
