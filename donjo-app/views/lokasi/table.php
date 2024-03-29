<script type="text/javascript">
	var baseURL = "<?= base_url(); ?>";
	$(function() {
		var keyword = <?= $keyword ?>;
		$("#cari").autocomplete({
			source: keyword,
			maxShowItems: 10,
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Pengaturan Lokasi</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Pengaturan Lokasi</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="mainform" name="mainform" action="" method="post">
			<div class="row">
				<div class="col-md-3">
					<?php $this->load->view('plan/nav.php') ?>
				</div>
				<div class="col-md-9">
					<div class="box box-info">
						<div class="box-header with-border">
							<a href="<?= site_url("plan/form") ?>" class="btn btn-social btn-flat btn-success btn-sm" title="Tambah Data Baru">
								<i class="fa fa-plus"></i>Tambah Data Baru
							</a>
							<?php if ($this->CI->cek_hak_akses('h')) : ?>
								<a href="#confirm-delete" title="Hapus Data" onclick="deleteAllBox('mainform', '<?= site_url("plan/delete_all/$p/$o") ?>')" class="btn btn-danger btn-sm hapus-terpilih"><i class='fa fa-trash-o'></i> Hapus Data Terpilih</a>
							<?php endif; ?>
							<!-- <a href="<?= site_url("{$this->controller}/clear") ?>" class="btn btn-social btn-flat bg-purple btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i class="fa fa-refresh"></i>Bersihkan Filter</a> -->
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">

										<!-- <div class="row">
											<div class="col-sm-9">
												<select class="form-control input-sm" name="filter" onchange="formAction('mainform', '<?= site_url('plan/filter') ?>')">
													<option value="">Semua</option>
													<option value="1" <?php if ($filter == 1) : ?>selected<?php endif ?>>Aktif</option>
													<option value="2" <?php if ($filter == 2) : ?>selected<?php endif ?>>Tidak Aktif</option>
												</select>
												<select class="form-control input-sm" name="subpoint" onchange="formAction('mainform', '<?= site_url('plan/subpoint') ?>')">
													<option value="">Semua Jenis</option>
													<?php foreach ($list_subpoint as $data) : ?>
														<option value="<?= $data['id'] ?>" <?php if ($subpoint == $data['id']) : ?>selected<?php endif ?>><?= $data['nama'] ?></option>
													<?php endforeach; ?>
												</select>
												<select class="form-control input-sm" name="point" onchange="formAction('mainform', '<?= site_url('plan/point') ?>')">
													<option value="">Semua Kategori</option>
													<?php foreach ($list_point as $data) : ?>
														<option value="<?= $data['id'] ?>" <?php if ($point == $data['id']) : ?>selected<?php endif ?>><?= $data['nama'] ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="col-sm-3">
												<div class="box-tools">
													<div class="input-group input-group-sm pull-right">
														<input name="cari" id="cari" class="form-control" placeholder="Cari..." type="text" value="<?= html_escape($cari) ?>" onkeypress="if (event.keyCode == 13):$('#'+'mainform').attr('action', '<?= site_url("plan/search") ?>');$('#'+'mainform').submit();endif">
														<div class="input-group-btn">
															<button type="submit" class="btn btn-default" onclick="$('#'+'mainform').attr('action', '<?= site_url("plan/search") ?>');$('#'+'mainform').submit();"><i class="fa fa-search"></i></button>
														</div>
													</div>
												</div>
											</div>
										</div> -->
										<div class="row">
											<div class="col-sm-12">
												<div class="table-responsive">
													<table class="table table-bordered table-striped dataTable table-hover" id="dataTableLokasi">
														<thead class="bg-gray disabled color-palette">
															<tr>
																<th><input type="checkbox" id="checkall" /></th>
																<th>No</th>
																<th>Aksi</th>
																	<th>Nama</th>
																<th>Kategori</th>
																<th>Jenis</th>
																	<th nowrap>Dusun</th>
																	<th nowrap>Aktif</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($main as $data) : ?>
																<tr>
																	<td><input type="checkbox" name="id_cb[]" value="<?= $data['id'] ?>" /></td>
																	<td></td>
																	<td nowrap>
																		<a href="<?= site_url("plan/form/$p/$o/$data[id]") ?>" class="btn btn-warning btn-flat btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
																		<a href="<?= site_url("plan/ajax_lokasi_maps/$p/$o/$data[id]") ?>" class="btn bg-olive btn-flat btn-sm" title="Lokasi <?= $data['nama'] ?>"><i class="fa fa-map"></i></a>
																		<?php if ($data['enabled'] == '2') : ?>
																			<a href="<?= site_url('plan/lokasi_lock/' . $data['id']) ?>" class="btn bg-navy btn-flat btn-sm" title="Aktifkan"><i class="fa fa-lock">&nbsp;</i></a>
																		<?php elseif ($data['enabled'] == '1') : ?>
																			<a href="<?= site_url('plan/lokasi_unlock/' . $data['id']) ?>" class="btn bg-navy btn-flat btn-sm" title="Non Aktifkan"><i class="fa fa-unlock"></i></a>
																		<?php endif ?>
																		<a href="#" data-href="<?= site_url("plan/delete/$p/$o/$data[id]") ?>" class="btn bg-maroon btn-flat btn-sm" title="Hapus" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>
																	</td>
																	<td width="20%"><?= $data['nama'] ?></td>
																	<td nowrap><?= $data['kategori'] ?></td>
																	<td><?= $data['jenis'] ?></td>
																	<td><?= $data['dusun'] ?></td>

																	<td><?= $data['aktif'] ?></td>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
		</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</form>
</section>
</div>
<?php $this->load->view('global/confirm_delete'); ?>