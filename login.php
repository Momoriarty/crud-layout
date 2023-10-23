<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assest/login.css">
    <link rel="stylesheet" href="assest/css/bootstrap.min.css">
    <title>Form Login</title>
</head>
<body>

    <section>
        <div class="form-box">
            <div class="form-value">              
                <form action="aksi-login.php" method="post">
                    <h2>Login</h2>
                    <?php 
                    if (!empty($_SESSION['alert'])) :
                        echo $_SESSION['alert'];
                        endif;
                        unset($_SESSION['alert']);
                     ?>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" name="username" class="" required>
                        <label for="">Email</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" class="" required>
                        <label for="">Password</label>
                    </div>
                    <div class="forget">
                        <label for="" class="d-flex justify-content-between">
                            <input type="checkbox" name="remember " value="1">Remember Me <div style="width: 60px; display: inline-block;"></div>
                            <a href="#">Forget Password</a>
                        </label>
                    </div>
                    <button type="submit" class="button"name="login">Login</button>
                    <div class="register">
                        <p>Dont Have a account? <a href="register.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
