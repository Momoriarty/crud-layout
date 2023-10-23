<?php

//deklasrasi variabel
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "rpl_pustaka";    

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

date_default_timezone_set('Asia/Jakarta'); // Set the timezone to WIB

if($connection) {
    
} else {
     mysqli_connect_error();
}

?>