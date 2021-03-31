<div class="app-title">
	<div>
		<h1><i class="fa fa-graduation-cap"></i> Santri</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Santri</a></li>
	</ul>
</div>
<a href="?page=add_santri" class="btn btn-primary tombol-layang tombol-modal"><i class="fa fa-fw fa-plus"></i></a>	
<div class="row">
	<div class="col-md-12">

		<div class="tile">
			<div class="tile-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered" id="tabelKu" width="100%">
						<thead>
							<tr>
								<th class="text-center">Nama</th>
								<th class="text-center">NISN</th>
								<th class="text-center">Nomor Induk</th>
								<th class="text-center">Angkatan</th>
								<th class="text-center">QR Code</th>
								<th class="text-center">Foto</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$sql = $mysqli->query("SELECT * FROM tb_santri ORDER BY tgl_input DESC");
							while($data = mysqli_fetch_assoc($sql)):
								$file = file_exists(base_url('images/thumbs/santri/'.$data['foto_santri']));
								$file_qr = file_exists(base_url('images/santri/qr_code/'.$data['qr_code']));
								?>
								<tr>
									<td><?= $data['nama_santri'] ?></td>
									<td class="text-center"><?= $data['nisn_santri'] ?></td>
									<td class="text-center"><?= $data['no_induk'] ?></td>
									<td class="text-center"><?= $data['angkatan_santri'] ?></td>
									<td class="text-center">
										<?php if(!$file_qr && !empty($data['qr_code'])): ?>
											<a href="<?=base_url('pages/santri/download.php?file='.$data['qr_code']);?>" title="Download QR Code">
												<img class="img-responsive user-img-data img-thumbnail" alt="<?= $data['qr_code']; ?>" src="<?= base_url('images/santri/qr_code/'.$data['qr_code']); ?>" />
											</a>
											<?php else: ?>
												<i class="fa fa-qrcode fa-fw"></i>
											<?php endif; ?>
										</td>
										<td class="text-center">
											<?php if(!$file && !empty($data['foto_santri'])): ?>
												<a id="show_foto" data-toggle="modal" data-target="#img" href="javascript:void(0)" data-id="<?= $data['id_santri']; ?>" data-foto="<?= $data['foto_santri']; ?>">
													<img class="img-responsive user-img-data img-thumbnail" alt="<?= $data['foto_santri']; ?>" src="<?= base_url('images/santri/'.$data['foto_santri']); ?>" />
												</a>
												<?php else: ?>
													<i class="fa fa-graduation-cap fa-fw"></i>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<a href="?page=edit_santri&id=<?= $data['id_santri']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>

												<a href="?page=delete_santri&id=<?= $data['id_santri']; ?>" class="btn btn-sm btn-danger tombol-hapus"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
		<div id="img" class="modal fade" role="dialog">
			<div class="modal-dialog">
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
		<!-- Modal -->
		<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="fileModalLabel">Import File Excel</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="post" enctype="multipart/form-data" action="">
						<div class="modal-body">
							<div class="form-group">
								<label for="exampleInputFile">File Upload</label>
								<input type="file" name="berkas_excel" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
								<small class="form-text text-muted" id="fileHelp">Sebelum upload download dulu template file excel nya.</small>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
							<button type="submit" name="submit_excel" class="btn btn-primary">Upload</button>
						</div>						
					</form>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			$(document).on("click", "#show_foto", function() {
				var id = $(this).data('id');
				var ft = $(this).data('foto');
				$("#modal-gambar #id").val(id);
				$("#modal-gambar #pict").attr("src", "images/santri/"+ft);
			});
		</script>