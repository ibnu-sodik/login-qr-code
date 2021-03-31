<?php 

$nama_santri = ((isset($_POST['nama_santri']))?sanitize($_POST['nama_santri']):'');
$nama_santri = trim($nama_santri);

$nisn_santri = ((isset($_POST['nisn_santri']))?sanitize($_POST['nisn_santri']):'');
$nisn_santri = trim($nisn_santri);

$no_induk = ((isset($_POST['no_induk']))?sanitize($_POST['no_induk']):'');
$no_induk = trim($no_induk);

$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);

$conf_password = ((isset($_POST['conf_password']))?sanitize($_POST['conf_password']):'');
$conf_password = trim($conf_password);

$errors = array();

?>

<div class="app-title">
	<div>
		<h1>
			<a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>&nbsp;
			<i class="fa fa-graduation-cap"></i> Add Santri
		</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="?page=santri">Santri</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Add</a></li>
	</ul>
</div>
<div class="row">
	<div class="col-md-12 col-xs-12 col-sm-12">
		<div class="tile">
			<form method="POST" action="">
				<h3 class="tile-title">Add Data</h3>
				<?php 

				if (isset($_POST['submit'])) {
					require_once 'phpqrcode/qrlib.php';

					$nama_santri = sanitize($_POST['nama_santri']);
					$nisn_santri = sanitize($_POST['nisn_santri']);
					$no_induk = sanitize($_POST['no_induk']);
					$password = sanitize($_POST['password']);
					$conf_password = sanitize($_POST['conf_password']);

					if (empty($no_induk)) {
						$errors[] = "Nomor induk harus diisi.";
					}
					if (empty($nisn_santri)) {
						$errors[] = "NISN harus diisi.";
					}
					if (empty($nama_santri)) {
						$errors[] = "Nama harus diisi.";
					}
					if (strlen($nisn_santri) < 10) {
						$errors[] = "Mohon masukkan NISN dengan benar.";
					}

					$sqlCeNim = $mysqli->query("SELECT * FROM tb_santri WHERE nisn_santri='$nisn_santri'");
					if (mysqli_num_rows($sqlCeNim) > 0) {
						$errors[] = "NISN $nisn_santri sudah digunakan. Mohon gunakan yang lain.";
					}

					$sqlCekNoInduk = $mysqli->query("SELECT * FROM tb_santri WHERE no_induk='$no_induk'");
					if (mysqli_num_rows($sqlCekNoInduk) > 0) {
						$errors[] = "Nomor induk $no_induk sudah digunakan. Mohon gunakan yang lain.";
					}

					if (strlen($password) < 6) {
						$errors[] = "Gunakan minisnal 6 karakter untuk password.";
					}
					if ($conf_password != $password) {
						$errors[] = "Konfirmasi password salah.";
					}


					if (!empty($errors)) {
						echo display_errors($errors);
					}else{
						// qr code script
						$tempdir = "images/santri/qr_code/";
						$pathLogo = "images/logo-qr-code.png";
						$ex = explode(" ", $nama_santri);
						$im = implode("-", $ex);
						$file_qr = strtolower($im).'-'.$nisn_santri.'.png';
						$value = $nisn_santri;
						$nama_file = $file_qr;

						echo qr_code_logo($tempdir, $pathLogo, $value, $nama_file);

						$options = ['cost' => 10];					
						$password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
						$insert = $mysqli->query("INSERT INTO tb_santri SET nama_santri = '$nama_santri', nisn_santri = '$nisn_santri', no_induk = '$no_induk', password_santri = '$password_hash', qr_code = '$file_qr'");
						if ($insert) {
							// cek id tertinggi dari tabel
							$sqlId = $mysqli->query("SELECT MAX(id_santri) as id_santri FROM tb_santri");
							$dataId = mysqli_fetch_assoc($sqlId);
							$url = "?page=edit_santri&id=".$dataId['id_santri'];

							$text = "Berhasil menambah $nama_santri pada data santri.";
							echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', $url);
						}
					}
				}

				?>
				<div class="tile-body">
					<div class="form-group row">
						<label class="control-label col-md-3" for="no_induk">Nomor Induk</label>
						<div class="col-md-9">
							<input class="form-control" type="number" name="no_induk" placeholder="Masukkan Nomor Induk" maxlength="4" value="<?= $no_induk; ?>" id="no_induk" >
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="nisn_santri">NISN Santri</label>
						<div class="col-md-9">
							<input type="number" name="nisn_santri" id="nisn_santri" class="form-control" placeholder="NISN Santri" maxlength="10" value="<?= $nisn_santri ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="nama_santri">Nama Santri</label>
						<div class="col-md-9">
							<input type="text" name="nama_santri" id="nama_santri" class="form-control" placeholder="Nama Santri" value="<?= $nama_santri ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="password">Password *</label>
						<div class="col-md-9">
							<input class="form-control" type="password" name="password" placeholder="Masukkan santri Password" value="<?= $password; ?>" id="password">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="conf_password">Confirm Password</label>
						<div class="col-md-9">
							<input class="form-control" type="password" name="conf_password" placeholder="Masukkan santri Password Confirmation" id="conf_password" value="<?= $conf_password; ?>">
						</div>
					</div>
				</div>
				<div class="tile-footer">
					<div class="row">
						<div class="col-md-8 col-md-offset-3">
							<button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>