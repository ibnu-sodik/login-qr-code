<?php 
session_start();

require_once '../library/config.php';
include '../library/f_baseUrl.php';
include '../library/f_library.php';
include '../library/f_notification.php';

$id = $_POST['id'];

?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sweetalert2.css'); ?>">
<script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.min.js') ?>"></script>

<?php
$sql = $mysqli->query("SELECT * FROM tb_santri WHERE nisn_santri = '$id'");
$data = mysqli_fetch_array($sql);
if (mysqli_num_rows($sql) > 0) {
	$_SESSION['logedin_santri'] = TRUE;
	$_SESSION['nisn_santri'] = $data['nisn_santri'];
	$_SESSION['id_santri'] = $data['id_santri'];
	$_SESSION['nama_santri'] = $data['nama_santri'];

 	// $url = base_url('santri');
	$text = $data['nama_santri']." berhasil login.";
	echo sweetalert('Selamat.!', $text, 'success', '3000', 'false', '.');
}else{
	$text = "NISN $id tidak ada pada data santri.";
	echo sweetalert('Oops.!', $text, 'warning', '3000', 'false', 'qr-login.php');
}

?>