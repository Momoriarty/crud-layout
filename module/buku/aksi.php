<?php
include "../../config/koneksi.php"; // Include File Koneksi

// Inisiasi module dan act
$module = $_GET['module'];
$act = $_GET['act'];

if ($module == 'buku' && $act == 'insert') {
    $isbn = $_POST['isbn'];
    $judul = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $jenis_buku = $_POST['jenis_buku'];
    $stok = $_POST['stok'];

    // Validasi gambar
    if (isset($_FILES['gambar'])) {
        $img_name = $_FILES['gambar']['name'];
        $img_size = $_FILES['gambar']['size'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $error = $_FILES['gambar']['error'];

        if ($error === 0) {
            if ($img_size > 1250000) {
                $em = "Ukuran gambar terlalu besar. Maksimum 125 KB.";
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png", "webp");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;

                    $destinationFolder1 = 'uploads/';
                    $img_upload_path = $destinationFolder1 . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    // Pindahkan gambar ke folder kedua
                    $destinationFolder2 = '../../module/pustaka/uploads/';                                   
                    $img_upload_path2 = $destinationFolder2 . $new_img_name;
                    if (copy($img_upload_path, $img_upload_path2)) {
                        // File berhasil dipindahkan ke folder kedua
                        // Query insert data ke dalam database
                        $query = "INSERT INTO `muda_buku`(`isbn`, `judul_buku`, `pengarang`, `penerbit`, `tahun_terbit`, `jenis_buku`, `stok`, `lokasi_file`) 
                                VALUES ('$isbn','$judul','$pengarang','$penerbit','$tahun','$jenis_buku','$stok', '$new_img_name')";

                        if ($connection->query($query)) {
                            session_start();
                            $_SESSION["alert"] = "
                            <div class='alert alert-success' role='alert'>
                            Data berhasil disimpan.
                            </div>
                            ";

                            // Redirect ke halaman index.php 
                            header("location: ../../media.php?module=" . $module);
                            exit();
                        } else {
                            // Pesan error gagal insert data
                            echo "Data gagal disimpan!";
                        }
                    } else {
                        // Gagal memindahkan file
                        echo "Gagal memindahkan file.";
                    }
                } else {
                    $em = "Ekstensi file gambar tidak valid. Harap pilih file JPG, JPEG, atau PNG.";
                }
            }
        } else {
            $em = "Terjadi kesalahan saat mengunggah gambar.";
        }
    }
}

// Delete
elseif ($module == 'buku' && $act == 'delete') {
    $isbn = $_GET['id'];

    // Query hapus data dari database
    $query = "SELECT `lokasi_file` FROM `muda_buku` WHERE `muda_buku`.`isbn` = '$isbn'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $lokasi_file = $data['lokasi_file'];

        // Hapus file gambar dari direktori
        $file_path = 'uploads/' . $lokasi_file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $query = "DELETE FROM `muda_buku` WHERE `muda_buku`.`isbn` = '$isbn'";

    if ($connection->query($query)) {
        session_start();
        $_SESSION["alert"] = "
        <div class='alert alert-danger' role='alert'>
        Data berhasil dihapus.
        </div>
        ";

        // Redirect ke halaman index.php 
        header("location: ../../media.php?module=" . $module);
        exit();
    } else {
        // Pesan error gagal hapus data
        echo "Data gagal dihapus!";
    }
}

// UPDATE

elseif ($module == 'buku' && $act == 'update') {
    $isbn = $_POST['isbn'];
    $judul = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $jenis_buku = $_POST['jenis_buku'];
    $stok = $_POST['stok'];

    // Query select lokasi file gambar lama
    $query_select = "SELECT lokasi_file FROM muda_buku WHERE isbn = '$isbn'";
    $result_select = mysqli_query($connection, $query_select);
    $data = mysqli_fetch_assoc($result_select);
    $old_image_path = 'uploads/' . $data['lokasi_file']; // Ganti dengan path folder gambar lama

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        // Menghapus file gambar lama jika ada
        if (file_exists($old_image_path)) {
            unlink($old_image_path);
        }

        $img_name = $_FILES['gambar']['name'];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = array("jpg", "jpeg", "png", "webp");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", TRUE) . '.' . $img_ex_lc;
            $img_upload_path = 'uploads/' . $new_img_name;
            move_uploaded_file($_FILES['gambar']['tmp_name'], $img_upload_path);
            $gambar_new = $new_img_name;
        } else {
            $gambar_new = $data['lokasi_file'];
            $em = "Error Tidak Dikenal";
        }
    } else {
        $gambar_new = $data['lokasi_file'];
    }

    // Query update data ke dalam database berdasarkan ISBN
    $query = "UPDATE muda_buku SET judul_buku = '$judul', pengarang = '$pengarang', penerbit = '$penerbit',
        tahun_terbit = '$tahun', jenis_buku = '$jenis_buku', stok = '$stok', lokasi_file = '$gambar_new'
        WHERE isbn = '$isbn'";

    if ($connection->query($query)) {
        session_start();
        $_SESSION["alert"] = "
        <div class='alert alert-info' role='alert'>
        Data Berhasil Diubah.
        </div>
        ";

        // Redirect ke halaman index.php
        header("location: ../../media.php?module=" . $module);
    } else {
        // Pesan error gagal mengubah data
        echo "Data Gagal Diubah!";
    }
}

?>