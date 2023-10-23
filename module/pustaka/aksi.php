<?php
include "../../config/koneksi.php"; // Include File Koneksi
// Inisiasi module dan act
$module = $_GET['module'];
$act = $_GET['act'];

if ($module == 'pustaka' && $act == 'insert'):

    $isbn = $_POST['isbn'];
    $nisn = $_POST['nisn'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status = $_POST['status'];
    $id = date('dmyHis');
    $tanggal_pinjam = date('Y-m-d');

    $query = "SELECT isbn, stok FROM muda_buku WHERE isbn = '$isbn'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);

    // Masukan Jumlah Stok Ke Variabel
    $stok = $row['stok'];
    // pengurangan
    $newStok = $stok - 1;


    // Tidak ada gambar baru yang diunggah
    $existing_img_path = $_POST['lokasi_gambar_existing'];

    // Query insert peminjaman
    $query_pinjam = "INSERT INTO muda_peminjaman (id_peminjaman, nisn, isbn, tanggal_pinjam, tanggal_kembali, `status`, `lokasi_file`)
    VALUES ('$id', '$nisn', '$isbn', '$tanggal_pinjam', '$tanggal_kembali', '$status', '$existing_img_path')";



    $query_stok = "UPDATE muda_buku SET
        stok = $newStok WHERE isbn = '$isbn'";


    if ($connection->query($query_pinjam)) {
        session_start();
        $_SESSION["alert"] = "
            <div class='alert alert-info' role='alert'>
                Data Berhasil Disimpan.
            </div>
        ";

        $connection->query($query_stok);

        // Redirect ke halaman index.php
        header("location: ../../media.php?module=" . $module);
        exit();
    } else {
        // Pesan error gagal menyimpan data
    }

    // Hapus
elseif ($module == 'pustaka' and $act == 'delete') :

    $id = $_GET['id'];

    $isbn = $_GET['isbn'];

    $query = "SELECT isbn, stok FROM muda_buku WHERE isbn = $isbn";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    // Masukan Jumlah Stok Ke Variabel
    $stok = $row['stok'];
    // pengurangan
    $newStok = $stok + 1;

    //query hapus
    $query_delete = "DELETE FROM `muda_peminjaman` WHERE `id_peminjaman` = '$id'";

    $query_stok = "UPDATE muda_buku SET stok = $newStok WHERE isbn = '$isbn'";

    if ($connection->query($query_delete)) {
        session_start();
        $_SESSION["alert"] = "
        <div class='alert alert-danger' role='alert'>
        Data Berhasil Dihapus.
        </div>
        ";

        $connection->query($query_stok);

        //redirect ke halaman index.php 
        header("location: ../../media.php?module=" . $module);
    } else {
        //pesan error gagal hapus data
        echo "Data Gagal Dihapus!";
    }
endif;


// Edit
if ($module == 'pustaka' and $act == 'update'):
    $id = $_POST['id_peminjaman'];
    $nisn = $_POST['nisn'];
    $isbn = $_POST['isbn'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status = $_POST['status'];

    $query = "UPDATE muda_peminjaman 
          SET nisn = '$nisn', isbn = '$isbn', tanggal_pinjam = '$tanggal_pinjam', 
              tanggal_kembali = '$tanggal_kembali', status = '$status' 
          WHERE id_peminjaman = '$id'";

    if ($connection->query($query)) {
        session_start();
        $_SESSION["alert"] = "
      <div class='alert alert-info' role='alert'>
      Data Berhasil Diubah.
      </div>
      ";
        //redirect ke halaman index.php 
        header("location: ../../media.php?module=" . $module);
    } else {
        //pesan error gagal update data
        echo "Data Gagal Diubah!";
    }

endif;