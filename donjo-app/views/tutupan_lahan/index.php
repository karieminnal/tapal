<div class="content-wrapper">
	<section class="content-header">
		<h1>Daftar Tutupan Lahan <?= ucwords($this->setting->sebutan_desa) ?> <?= $desa["nama_desa"]; ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Daftar Tutupan Lahan</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<!-- <div class="col-md-4 col-lg-3">
				<?php /* $this->load->view('data_persil/menu_kiri.php') */ ?>
			</div> -->
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header">
						<h4 class="text-center"><strong>DAFTAR TUTUPAN LAHAN</strong></h4>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
									<a href="<?= site_url("tutupan_lahan/ajax_map/") ?>" class="btn btn-social btn-flat btn-success btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Import Tutupan Lahan">
										<i class="fa fa-upload"></i>Import Tutupan Lahan
									</a>
									<a data-toggle="modal" data-target="#hapusmodal" title="Hapus Data" class="btn btn-social btn-flat btn-danger btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block">
										<i class='fa fa-trash-o'></i> Hapus Berdasarkan Jenis
									</a>
									</br></br>
									<form id="mainform" name="mainform" action="" method="post">
										<label> Tampilkan Jenis: </label>
										<select class="form-control input-sm" name="jenis" onchange="formAction('mainform', '<?= site_url('tutupan_lahan/filter_jenis') ?>')">
											<option value="">Semua Jenis</option>
											<?php foreach ($tutupan_lahan_jenis as $data) : ?>
												<option value="<?= $data['id'] ?>" <?php if ($filter_jenis == $data['id']) : ?>selected<?php endif ?>><?= $data['nama'] ?></option>
											<?php endforeach; ?>
										</select>
									</form>
									<div class="row">
										<div class="col-sm-12">
											<div class="table-responsive">
												<table class="table table-bordered table-striped dataTable table-hover">
													<thead class="bg-gray disabled color-palette">
														<tr>
															<th>No</th>
															<th></th>
															<th>Jenis</th>
															<th>Luas (Ha)</th>
															<th>Pemilik</th>
															<th>Alamat</th>
															<th>Ditambahkan</th>
															<th>Diedit</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($tutupan_lahan as $item) : ?>
															<tr>
																<td><?= $item['no'] ?></td>
																<td><a href="<?= site_url("tutupan_lahan/update/" . $item["id"]) ?>" class="btn bg-orange btn-flat btn-sm" title="Ubah Data"><i class="fa fa-edit"></i></a></td>
																<td><?= $item['jenis_nama'] ?></td>
																<td><?= $item['luas'] ?></td>
																<td><?= $item['pemilik'] ?></td>
																<td><?= $item['alamat'] ?></td>
																<td><?= date("d/m/Y H:i", strtotime($item['tgl_diimport'])) ?></td>
																<td><?= date("d/m/Y H:i", strtotime($item['tgl_diupdate'])) ?></td>
															</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<?php $this->load->view('global/paging'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="hapusmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Hapus Tutupan Lahan dengan Jenis berikut: </h4>
			</div>
			<div class="modal-body">
				<form id="deleteform" name="deleteform" action="" method="post">

					<?php foreach ($tutupan_lahan_jenis as $data) : ?>
						<input type="checkbox" name="id_cb[]" value="<?= $data['id'] ?>" /> <label> <?= $data['nama'] ?></label><br>
					<?php endforeach; ?>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-social btn-flat btn-warning btn-sm" data-dismiss="modal"><i class="fa fa-sign-out"></i> Batal</button>
				<a href="#confirm-delete" title="Hapus Data" onclick="deleteAllBox('deleteform', '<?= site_url("tutupan_lahan/delete") ?>')" class="btn btn-social btn-flat btn-danger btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block hapus-terpilih"><i class='fa fa-trash-o'></i> Hapus Data Terpilih</a>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('global/confirm_delete'); ?>