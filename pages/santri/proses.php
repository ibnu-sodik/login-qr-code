<?php 


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
if (isset($_POST['submit'])) {
	
	include '../../../library/config.php';
	include '../../../library/f_baseUrl.php';
	include '../../../library/f_qrCode.php';
	require '../../../vendor/autoload.php';
	require '../../../phpqrcode/qrlib.php';

	$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

	if(isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {

		$arr_file = explode('.', $_FILES['berkas_excel']['name']);
		$extension = end($arr_file);

		if('csv' == $extension) {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		} else {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}

		$spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);

		$sheetData = $spreadsheet->getActiveSheet()->toArray();
		for($i = 1;$i <= count($sheetData);$i++)
		{
			$nama_santri 		= $sheetData[$i]['2'];
			$no_induk 			= $sheetData[$i]['0'];
			$nisn_santri		= $sheetData[$i]['1'];
			$tempat_lahir		= $sheetData[$i]['3'];
			$tgl_lahir			= $sheetData[$i]['4'];
			$alamat				= $sheetData[$i]['5'];
			$angkatan_santri	= $sheetData[$i]['6'];

			$tgl_baru = date('Y-m-d', strtotime($tgl_lahir));

		// qr code script
			$tempdir = "../../../images/santri/qr_code/";
			$pathLogo = "../../../images/logo-qr-code.png";
			$ex = explode(" ", $nama_santri);
			$im = implode("-", $ex);
			$file_qr = strtolower($im).'-'.$nisn_santri.'.png';
			$value = $nisn_santri;
			$nama_file = $file_qr;

			echo qr_code_logo($tempdir, $pathLogo, $value, $nama_file);

			$password = "123456";
			$options = ['cost' => 10];					
			$password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
			$mysqli->query("INSERT INTO tb_santri SET 
				nama_santri = '$nama_santri', 
				no_induk = '$no_induk',
				nisn_santri = '$nisn_santri',
				tempat_lahir = '$tempat_lahir',
				tgl_lahir = '$tgl_baru',
				alamat = '$alamat',
				angkatan_santri = '$angkatan_santri',
				password_santri = '$password_hash',
				qr_code = '$file_qr'
				");
		}
		header("Location: ".base_url('admin/?page=santri')); 
	}
}

?>