<?php include "config/koneksi.php"; ?>
<?php session_start();
if (empty($_SESSION['username'])) {
    $_SESSION["alert"] = "
    <div class='alert alert-primary' role='alert'>
    Silahkan Login dulu
    </div>";

    header("location:login.php");
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>MZ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assest/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css">
    <link rel="stylesheet" href="assest/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

    * {
        margin: 0;
        padding: 0;
        font-family: 'Poppins';
    }

    /* Mobile View */
    @media (max-width: 767px) {
        .dashboard-content {
            padding-top: 80px;
            /* Adjust the value as needed */
        }
    }

    /* Tablet View */
    @media (min-width: 768px) and (max-width: 991px) {
        .dashboard-content {
            padding-top: 60px;
            /* Adjust the value as needed */
        }
    }

    /* Desktop View */
    @media (min-width: 992px) {
        .dashboard-content {
            padding-top: 30px;
            /* Adjust the value as needed */
        }
    }


    .logo-icon {
        font-size: 24px;
    }

    .dashboard-toolbar {
        transition: all 0.1s ease-in-out;
        background-color: rgba(60, 46, 39, 0.2);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    @keyframes rotate {
        100% {
            transform: rotate(1turn);
        }
    }

    .rainbow {
        position: relative;
        z-index: 0;
        width: 100px;
        height: 40px;
        border-radius: 10px;
        overflow: hidden;
        padding: 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: sans-serif;
        font-weight: bold;
        color: white;

        &::before {
            content: '';
            position: absolute;
            z-index: -2;
            left: -50%;
            top: -50%;
            width: 200%;
            height: 200%;
            background-color: #399953;
            background-repeat: no-repeat;
            background-size: 50% 50%, 50% 50%;
            background-position: 0 0, 100% 0, 100% 100%, 0 100%;
            background-image: linear-gradient(#399953, #399953), linear-gradient(#fbb300, #fbb300), linear-gradient(#d53e33, #d53e33), linear-gradient(#377af5, #377af5);
            animation: rotate 4s linear infinite;
        }

        &::after {
            content: '';
            position: absolute;
            z-index: -1;
            left: 6px;
            top: 6px;
            width: calc(100% - 12px);
            height: calc(100% - 12px);
            background: black;
            border-radius: 5px;
        }
    }

    body {
        background-color: #6AA4BA;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    }

    body div.darkmode {
        display: inline-block;
        font-size: 2rem;
        padding: 1rem 1rem 0.75rem 1rem;
        cursor: pointer;
    }

    body.dark .darkmode .light,
    body:not(.dark) .darkmode .dark {
        display: none;
    }

    .fa {
        cursor: pointer;
    }
</style>

<body>
    <!-- partial:index.partial.html -->
    <div class='dashboard'>

        <?php include "template/template-navbar.php"; ?>

        <div class='dashboard-app'>
            <header class="dashboard-toolbar">
                <a href="#!" class="menu-toggle" onclick="changeLogo()">
                    <i id="logo-icon" class="fas fa-lock-open logo-icon mr-4"></i>
                </a>

                <div class="mt-2">
                    <h5>Hallo Selamat Datang <b>
                            <?= ucwords($_SESSION['namauser']); ?>
                        </b></h5>
                    <p>Kamu Login Sebagai <b>
                            <?= ucwords($_SESSION['level_user']); ?>
                        </b></p>
                </div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col ">
                    <span id="jam" class="rainbow"></span>
                </div>
                <div class="col">
                    <div class="darkmode">
                        <div class="light fa fa-sun"></div>
                        <div class="dark fa fa-moon"></div>
                    </div>
                </div>


            </header>
            <div class='dashboard-content'>
                <div class='container'>
                    <!-- Content -->
                    <?php include "content.php"; ?>
                    <!-- End Content -->
                </div>
            </div>
        </div>
    </div>
    <!-- partial -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
    <script src="assest/script.js"></script>
    <script src="assest/js/bootstrap.js"></script>

    <script>
        function changeLogo() {
            var logoIcon = document.getElementById('logo-icon');

            // Cek kelas ikon saat ini
            if (logoIcon.classList.contains('fa-lock-open')) {
                // Ubah kelas ikon pertama menjadi ikon baru
                logoIcon.classList.remove('fa-lock-open');
                logoIcon.classList.add('fa-lock');

            } else {
                // Kembalikan kelas ikon pertama ke awal
                logoIcon.classList.remove('fa-lock');
                logoIcon.classList.add('fa-lock-open');

            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('pinjamModal<?= $data_buku['isbn']; ?>'));
    </script>
    <script>
        function jam() {
            var elementJam = document.getElementById("jam");

            var waktu = new Date(); // Dapatkan waktu saat ini

            var jam = waktu.getHours();
            var menit = waktu.getMinutes();
            var detik = waktu.getSeconds();

            // Tambahkan angka 0 di depan angka jam, menit, dan detik jika nilainya kurang dari 10
            if (jam < 10) {
                jam = "0" + jam;
            }
            if (menit < 10) {
                menit = "0" + menit;
            }
            if (detik < 10) {
                detik = "0" + detik;
            }

            var jamLengkap = jam + ":" + menit + ":" + detik;

            elementJam.innerHTML = jamLengkap;
        }

        // Panggil fungsi perbaruiJam setiap 1 detik (1000 milidetik)
        setInterval(jam, 1000);

    </script>

    <script>$(".darkmode").click(function () {
            $("body").toggleClass("dark")
                .css( //3
                    $("body").hasClass("dark") ?
                        { background: "#000000", color: "#AEAFAE" } : { background: "#6AA4BA", color: "#202225" }
                );
        });
    </script>
</body>

</html>