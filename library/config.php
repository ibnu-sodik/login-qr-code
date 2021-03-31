<?php 

/* Membuat variabel, ubah sesuai dengan nama host dan database pada hosting */
$host	= "localhost";
$user	= "root";
$pass	= "";
$db		= "belajar_qrcode";

//Menggunakan objek mysqli untuk membuat koneksi dan menyimpanya dalam variabel $mysqli	//
$mysqli = new mysqli($host, $user, $pass, $db);
$config = mysqli_connect($host,$user,$pass,$db) or die(mysqli_error($config));


//Menentukan timezone //
date_default_timezone_set('Asia/Jakarta'); 

 ?>