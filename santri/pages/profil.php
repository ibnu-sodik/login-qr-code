<div class="app-title">
	<div>
		<h1><i class="fa fa-user"></i> Profil</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Profil</a></li>
	</ul>
</div>

<div class="row user">
	<div class="col-md-12">
		<div class="profile">
			<div class="info">
				<?php 
				$file = file_exists(base_url('images/santri/'.$santri['foto_santri']));
				if(!$file && !empty($santri['foto_santri'])):
					?>

					<img class="user-img rounded-circle" src="<?= base_url('images/santri/'.$santri['foto_santri']); ?>" alt="<?= base_url('images/santri/'.$santri['foto_santri']); ?>" />
					<button type="button" onclick="" class="btn btn-block btn-primary">Download <i class="fa fa-download"></i></button>
					<?php else: ?>
						<img src="<?= base_url('images/logo-santri.png') ?>" class="user-img rounded-circle" alt="<?= base_url('images/logo-santri.png') ?>">
					<?php endif; ?>
					<h4><?= $santri['nama_santri']; ?></h4>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="tile p-0">
				<ul class="nav flex-column nav-tabs user-tabs">
					<li class="nav-item"><a class="nav-link active" href="#user-info" data-toggle="tab">Info</a></li>
					<li class="nav-item"><a class="nav-link" href="#user-password" data-toggle="tab">Change Password</a></li>
				</ul>
			</div>
		</div>

		<div class="col-md-9">
			<div class="tab-content">
				<div class="tab-pane active" id="user-info">
					<div class="tile user-info">
						<h4 class="line-head">Info</h4>
						<form>
							<div class="row">
								<div class="col-md-8 mb-1">
									<label>Nama </label>
									<input readonly class="form-control" type="text" name="nama_santri" value="<?= $santri['nama_santri']; ?>" placeholder="Nama " autofocus>
								</div>
								<div class="clearfix"></div>
								<div class="col-md-8 mb-1">
									<label>NISN</label>
									<input readonly class="form-control" type="text" name="nisn_santri" value="<?= $santri['nisn_santri']; ?>" placeholder="NISN">
								</div>
								<div class="clearfix"></div>
								<div class="col-md-8 mb-1">
									<label>Nomor Induk</label>
									<input readonly class="form-control" type="number" name="no_induk" value="<?= $santri['no_induk'] ?>" placeholder="Nomor Induk">
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="tab-pane fade" id="user-password">
					<div class="tile user-info">
						<h4 class="line-head">Ubah Password</h4>
						<div>
							<?php 
							$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
							$password = trim($password);

							$conf_password = ((isset($_POST['conf_password']))?sanitize($_POST['conf_password']):'');
							$conf_password = trim($conf_password);

							$errors = array();

							if (isset($_POST['cpass'])) {
								$update_id 	= sanitize($_POST['id']);
								$password = sanitize($_POST['password']);	
								$conf_password = sanitize($_POST['conf_password']);	

								if (strlen($password) < 6) {
									$errors[] = "Gunakan minisnal 6 karakter untuk password.";
								}
								if ($conf_password != $password) {
									$errors[] = "Konfirmasi password salah.";
								}

								if (!empty($errors)) {
									echo display_errors($errors);
								}else{
									$options = ['cost' => 10];					
									$password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
									$update = $mysqli->query("UPDATE tb_santri SET password_santri = '$password_hash' WHERE id_santri = '$update_id'");

									if ($update) {
										$text = "Password $santri[nama_santri] berhasil diupdate.";
										echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=profil');
									}
								}
								echo "<hr>";
							}

							?>
						</div>
						<form method="POST" action="" class="row">
							<div class="form-group col-md-4">
								<label class="control-label">New Password</label>
								<input class="form-control" name="password" type="password" placeholder="Enter your new password" value="<?= $password; ?>">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Confirm Password</label>
								<input class="form-control" name="conf_password" type="password" placeholder="Enter your confirm password" value="<?= $conf_password; ?>">
							</div>
							<div class="form-group col-md-4 align-self-end">
								<input type="hidden" name="id" value="<?= $santri['id_santri']; ?>">
								<button class="btn btn-primary" type="submit" name="cpass"><i class="fa fa-fw fa-lg fa-check-circle"></i>Change</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>