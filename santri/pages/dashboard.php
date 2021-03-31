
		<div class="row">
			<div class="col-md-9">
				<div class="tile">
					<h3 class="tile-title">Informasi Data</h3>
					<div class="tile-body">
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th>Nama</th>
									<td>:</td>
									<td><?= $santri['nama_santri'] ?></td>
								</tr>
								<tr>
									<th>Nomor Induk</th>
									<td>:</td>
									<td><?= $santri['no_induk'] ?></td>
								</tr>
								<tr>
									<th>NISN</th>
									<td>:</td>
									<td><?= $santri['nisn_santri'] ?></td>
								</tr>
								<tr>
									<th>Jenis Kelamin</th>
									<td>:</td>
									<td><?= $santri['gender'] ?></td>
								</tr>
								<tr>
									<th>Tempat Tanggal Lahir</th>
									<td>:</td>
									<td><?= $santri['tempat_lahir'].', '.$santri['tgl_lahir'] ?></td>
								</tr>
								<tr>
									<th>Tahun Angkatan</th>
									<td>:</td>
									<td><?= $santri['angkatan_santri'] ?></td>
								</tr>
								<tr>
									<th>Alamat</th>
									<td>:</td>
									<td><?= $santri['alamat'] ?></td>
								</tr>
							</table>
						</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 text-center">
					<div class="tile">
						<h3 class="tile-title">QR Code <?= $santri['nama_santri']; ?></h3>
						<div class="tile-body">
							<img src="<?= base_url('images/santri/qr_code/'.$santri['qr_code']); ?>" class="img-responsive img-thumbnail" alt="<?= $santri['qr_code'] ?>">
						</div>
						<div class="tile-footer">
							<button type="button" onclick="javascript:window.location.href='<?=base_url('admin/pages/santri/download.php?file='.$santri['qr_code']);?>';" class="btn btn-block btn-primary">Download <i class="fa fa-fw fa-download"></i></button>
						</div>
					</div>
				</div>
			</div>

			<div id="img" class="modal fade" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body" id="modal-gambar">
							<div style="padding-bottom: 5px;">
								<center>
									<img src="" id="pict" alt="" class="img-responsive img-thumbnail">
								</center>
							</div>
						</div>
					</div>
				</div>
			</div>