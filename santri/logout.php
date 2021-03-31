<?php 
session_start();
session_destroy();
unset($_SESSION['logedin_santri']);
unset($_SESSION['nisn_santri']);
header('Location: qr-login.php');
?>