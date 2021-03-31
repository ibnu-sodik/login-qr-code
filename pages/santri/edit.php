<?php 
$id_santri = $_GET['id'];
$sql = $mysqli->query("SELECT * FROM tb_santri WHERE id_santri = '$id_santri'");
$data = mysqli_fetch_array($sql);

$nama_santri = ((isset($_POST['nama_santri']))?sanitize($_POST['nama_santri']):$data['nama_santri']);
$nama_santri = trim($nama_santri);

$nisn_santri = ((isset($_POST['nisn_santri']))?sanitize($_POST['nisn_santri']):$data['nisn_santri']);
$nisn_santri = trim($nisn_santri);

$no_induk = ((isset($_POST['no_induk']))?sanitize($_POST['no_induk']):$data['no_induk']);
$no_induk = trim($no_induk);

$gender = ((isset($_POST['gender']))?sanitize($_POST['gender']):$data['gender']);
$gender = trim($gender);

$tempat_lahir = ((isset($_POST['tempat_lahir']))?sanitize($_POST['tempat_lahir']):$data['tempat_lahir']);
$tempat_lahir = trim($tempat_lahir);

$tgl_lahir = ((isset($_POST['tgl_lahir']))?sanitize($_POST['tgl_lahir']):$data['tgl_lahir']);
$tgl_lahir = trim($tgl_lahir);

$alamat = ((isset($_POST['alamat']))?sanitize($_POST['alamat']):$data['alamat']);
$alamat = trim($alamat);

$angkatan_santri = ((isset($_POST['angkatan_santri']))?sanitize($_POST['angkatan_santri']):$data['angkatan_santri']);
$angkatan_santri = trim($angkatan_santri);
?>
<div class="app-title">
	<div>
		<h1>
			<a href="?page=santri" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>&nbsp;
			<i class="fa fa-graduation-cap"></i> Edit Santri
		</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="?page=santri">Santri</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
	</ul>
</div>
<div class="row">
	<div class="col-md-3 text-center">
		<div class="tile">
			<?php
			$file = file_exists(base_url('images/santri/'.$data['foto_santri'])); 
			if (!empty($data['foto_santri']) && !$file):
				?>
				<h3 class="tile-title">Foto <?= $data['nama_santri']; ?></h3>
				<?php 
				if (isset($_POST['hapus_foto'])) {
					$update_id = sanitize($_POST['id']);
					$foto_awal = $mysqli->query("SELECT * FROM tb_santri WHERE id_santri = '$update_id'")->fetch_object()->foto_santri;
					unlink('images/santri/'.$foto_awal);
					$update = $mysqli->query("UPDATE tb_santri SET foto_santri = '' WHERE id_santri = '$update_id'");
					if ($update) {
						$text = "Foto Berhasil Dihapus.";
						echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
					}
				}
				?>
				<form action="" method="POSt">
					<div class="tile-body">
						<input type="hidden" name="id" value="<?= $data['id_santri'] ?>">
						<img class="img-responsive img-thumbnail" src="<?= base_url('images/santri/'.$data['foto_santri']); ?>">
					</div>
					<div class="tile-footer">
						<button type="submit" name="hapus_foto" class="btn btn-block btn-danger">Hapus <i class="fa fa-fw fa-trash"></i></button>
					</div>
					</form><?php else: ?>
					<h3 class="tile-title">Add Foto <?= $data['nama_santri']; ?></h3>
					<?php 
					$errors = array();
					if (isset($_POST['submit_foto'])) {
						error_reporting(0);
						// upload foto
						$nisn_santri = sanitize($_POST['nisn_santri']);
						$extensi = explode('.', $_FILES['foto']['name']);
						$nama_foto = $nisn_santri.'.'.end($extensi);
						$sumber = $_FILES['foto']['tmp_name'];
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($nama_foto, PATHINFO_EXTENSION));

						if (empty($sumber)) {
							$errors[] = "Foto tidak boleh kosong.";
						}

						$check = getimagesize($sumber);
						if ($check==false) {
							$errors[] = "Type File Harus Gambar.";
							$uploadOk = 0;
						}
						if (file_exists($nama_foto)) {
							$errors[] = "File Sudah Ada.";
							$uploadOk = 0;
						}
						if ($_FILES['foto']['size'] > 2000000) {
							$errors[] = "Ukuran File Maksimal 2Mb.";
							$uploadOk = 0;
						}
						if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
							&& $imageFileType != "gif" ) {
							$errors[] = "Etensi File Harus JPG, JPEG, PNG atau Gif.";
						$uploadOk = 0;
					}
					if ($uploadOk == 0) {
						$errors[] = "Upload foto gagal.";
					}else{
						if (!empty($errors)) {
							echo display_errors($errors);
						}else{
							$update = $mysqli->query("UPDATE tb_santri SET foto_santri = '$nama_foto' WHERE id_santri = '$id_santri'");
							if ($update) {
								// error_reporting(1);
								if(move_uploaded_file($sumber, 'images/santri/'.$nama_foto)){
									$text = "Foto $data[nama_santri] berhasil diupdate.";
									echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
								}
								
							}
						}
					}
				}
				?>
				<form enctype="multipart/form-data" action="" method="POST">
					<div class="tile-body">
						<input type="hidden" name="nisn_santri" value="<?= $data['nisn_santri']; ?>">
						<input type="file" name="foto" class="dropify" class="form-control" required>
					</div>
					<div class="tile-footer">
						<button class="btn btn-primary btn-block" type="submit" name="submit_foto"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
					</div>
				</form>
			<?php endif ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="tile">
			<h3 class="tile-title">Edit Data <?= $data['nama_santri']; ?></h3>
			<?php 
			$errors = array();
			if (isset($_POST['submit_info'])) {
				$nama_santri 	= sanitize($_POST['nama_santri']);
				$no_induk 		= sanitize($_POST['no_induk']);
				$nisn_santri 		= sanitize($_POST['nisn_santri']);
				$gender 		= sanitize($_POST['gender']);
				$tempat_lahir 		= sanitize($_POST['tempat_lahir']);
				$tgl_lahir 		= sanitize($_POST['tgl_lahir']);
				$angkatan_santri 	= sanitize($_POST['angkatan_santri']);
				$alamat 		= sanitize($_POST['alamat']);

				if (empty($nama_santri)) {
					$errors[] = "Nama santri harus diisi.";
				}

				$sqlCekEmail = $mysqli->query("SELECT * FROM tb_santri WHERE no_induk='$no_induk' and id_santri != '$id_santri'");
				if (mysqli_num_rows($sqlCekEmail) > 0) {
					$errors[] = "Nomor induk $no_induk sudah digunakan. Mohon gunakan yang lain.";
				}

				if (!empty($errors)) {
					echo display_errors($errors);
				}else{
					$update = $mysqli->query("UPDATE tb_santri SET 
						nama_santri 	= '$nama_santri', 
						nisn_santri 	= '$nisn_santri', 
						no_induk 		= '$no_induk', 
						gender 			= '$gender', 
						tempat_lahir 	= '$tempat_lahir',
						tgl_lahir 		= '$tgl_lahir', 
						angkatan_santri = '$angkatan_santri', 
						alamat 			= '$alamat' 
						WHERE id_santri = '$id_santri' ");
					if ($update) {
						$text = "Data $nama_santri berhasil diupdate.";
						echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
					}
				}
			}
			?>
			<form method="POST" action="">
				<div class="tile-body">
					<div class="form-group row">
						<label class="control-label col-md-3" for="nama_santri">Nama</label>
						<div class="col">
							<input type="text" id="nama_santri" autofocus name="nama_santri" class="form-control" value="<?= $nama_santri; ?>">
						</div>	
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="nisn_santri">NISN</label>
						<div class="col">
							<input type="text" id="nisn_santri"name="nisn_santri" class="form-control" value="<?= $nisn_santri; ?>" readonly aria-describedby="nisnHelp">
							<small class="form-text text-muted">NISN tidak dapat diubah, jika data salah silahkan hapus dan buat ulang.</small>
						</div>	
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="no_induk">Nomor Induk</label>
						<div class="col">
							<input type="number" name="no_induk" class="form-control" id="no_induk" value="<?= $no_induk; ?>" readonly aria-describedby="noIndukHelp">
							<small class="form-text text-muted">Nomor induk tidak dapat diubah, jika data salah silahkan hapus dan buat ulang.</small>
						</div>	
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="gender">Gender</label>
						<div class="col">
							<div class="anisnated-radio-button">
								<label>
									<input type="radio" name="gender" value="L" <?php if($gender=="L")echo "checked"; ?>><span class="label-text">Laki laki</span>
								</label>
							</div>
							<div class="anisnated-radio-button">
								<label>
									<input type="radio" name="gender" value="P" <?php if($gender=="P")echo "checked"; ?>><span class="label-text">Perempuan</span>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="tempat_lahir">Tempat Lahir</label>
						<div class="col">
							<input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" value="<?= $tempat_lahir ?>"  placeholder="Tempat lahir">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="tgl_lahir">Tanggal Lahir</label>
						<div class="col">
							<input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" value="<?= $tgl_lahir ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="alamat">Alamat</label>
						<div class="col">
							<textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?= $alamat ?></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="angkatan_santri">Angkatan</label>
						<div class="col">
							<select name="angkatan_santri" id="angkatan_santri" class="pilih2 form-control">
								<option value="">---Pilih Tahun Angkatan---</option>
								<?php 
								for ($year=date('Y'); $year >= 2010 ; $year--) { 
									if ($year==$angkatan_santri) {
										$cek = "selected";
									}else{
										$cek = "";
									}
									echo "<option value=$year $cek>$year</option>";
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="tile-footer">
					<button class="btn btn-primary btn-block" type="submit" name="submit_info"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-3 text-center">
		<div class="tile">
			<h3 class="tile-title">QR Code <?= $data['nama_santri'] ?></h3>
			<div class="tile-body">
				<img src="<?= base_url('images/santri/qr_code/'.$data['qr_code']); ?>" class="img-responsive img-thumbnail" alt="<?= $data['qr_code'] ?>">
			</div>
			<div class="tile-footer">
				<button type="button" onclick="javascript:window.location.href='<?=base_url('pages/santri/download.php?file='.$data['qr_code']);?>';" class="btn btn-block btn-primary">Download <i class="fa fa-fw fa-download"></i></button>
			</div>
		</div>
	</div>
</div>
