<?php 
$id_santri = $_GET['id'];
$sql = $mysqli->query("SELECT * FROM tb_santri WHERE id_santri = '$id_santri'");

$foto_awal = $mysqli->query("SELECT * FROM tb_santri WHERE id_santri = '$id_santri'")->fetch_object()->foto_santri;
unlink('../images/thumbs/rounded/'.$foto_awal);
unlink('../images/thumbs/santri/'.$foto_awal);
unlink('../images/santri/'.$foto_awal);

$qr_code = $mysqli->query("SELECT * FROM tb_santri WHERE id_santri = '$id_santri'")->fetch_object()->qr_code;
unlink('../images/santri/qr_code/'.$qr_code);

$update = $mysqli->query("DELETE FROM tb_santri WHERE id_santri = '$id_santri'");
if ($update) {
	$text = "Data Berhasil Dihapus.";
	echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=santri');
}
?>