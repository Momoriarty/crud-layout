<?php 

include "../../config/koneksi.php"; // Include File Koneksi

// inisiasi module dan act
$module = $_GET['module'];
$act = $_GET['act'];

if ($module == 'siswa' AND $act == 'insert') {

    $nisn = $_POST['nisn'];
    $nama = $_POST['nama_siswa'];
    $jurusan = $_POST['jurusan'];
    $jekel = $_POST['jenis_kelamin'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO muda_siswa (nisn, nama_siswa, jurusan, no_hp, alamat, jenis_kelamin)
    VALUES ('$nisn','$nama','$jurusan','$no_hp','$alamat', '$jekel')";

    if ($connection->query($query)) {
        session_start();
        $_SESSION["alert"] = "
        <div class='alert alert-success' role='alert'>
        Data Berhasil Disimpan.
        </div>
        ";
        //redirect ke halaman index.php 
        header("location: ../../media.php?module=" . $module);
    } else {
        //pesan error gagal insert data
        echo "Data Gagal Disimpan, Dikarenakan NISN Sudah Ada!";
    }

} 



// Hapus
elseif ($module == 'siswa' AND $act == 'delete') { 
    $id = $_GET['id'];

    //query hapus
    $query = "DELETE FROM `muda_siswa` WHERE `muda_siswa`.`nisn` = '$id'";

    if ($connection->query($query)) {
        session_start();
        $_SESSION["alert"] = "
        <div class='alert alert-danger' role='alert'>
        Data Berhasil Dihapus.
        </div>
        ";
        //redirect ke halaman index.php 
        header("location: ../../media.php?module=" . $module);
    } else {
        //pesan error gagal hapus data
        echo "Data Gagal Dihapus!";
    }
}

// Edit
elseif ($module == 'siswa' AND $act == 'update') {
    $nisn = $_POST['nisn'];
    $jekel = $_POST['jenis_kelamin'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    //query update data ke dalam database berdasarkan ID
    $query = "UPDATE `muda_siswa` SET `nisn`='$nisn',`nama_siswa`='$nama',`jurusan`='$jurusan', `no_hp`='$no_hp',`jenis_kelamin`='$jekel',`alamat`='$alamat' WHERE nisn = '$nisn'";

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
  }
?>
