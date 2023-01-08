<script>
	$(function() {
		$("#cari").autocomplete({
			source: function(request, response) {
				$.ajax({
					type: "POST",
					url: '<?= site_url("data_persil/autocomplete") ?>',
					dataType: "json",
					data: {
						cari: request.term
					},
					success: function(data) {
						response(JSON.parse(data));
					}
				});
			},
			minLength: 1,
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Daftar Persil <?= ucwords($this->setting->sebutan_desa) ?> <?= $desa["nama_desa"]; ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Daftar Persil</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="mainform" name="mainform" action="" method="post">
			<div class="row">
				<div class="col-md-4 col-lg-3">
					<?php $this->load->view('data_persil/menu_kiri.php') ?>
				</div>
				<div class="col-md-8 col-lg-9">
					<div class="box box-info">
						<div class="box-header">
							<h4 class="text-center"><strong>DAFTAR PERSIL</strong></h4>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
										<a href="<?= site_url("data_persil/ajax_map/") ?>" class="btn btn-social btn-flat btn-success btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Tambah Persil">
											<i class="fa fa-upload"></i>Import Persil
										</a>
										<hr>
										<!-- <a href="" class="btn btn-social btn-flat bg-purple btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Cetak Data" target="_blank">
											<i class="fa fa-print"></i>Cetak
										</a>
										<a href="" class="btn btn-social btn-flat bg-navy btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Unduh Data" target="_blank">
											<i class="fa fa-download"></i>Unduh
										</a>
										<a href="<?= site_url("data_persil/clear") ?>" class="btn btn-social btn-flat bg-purple btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i class="fa fa-refresh"></i>Bersihkan</a> -->

										<div class="row">
											<div class="col-sm-12">
												<!-- <div class="box-tools">
														<div class="input-group input-group-sm pull-right">
															<input name="cari" id="cari" class="form-control" placeholder="Cari..." type="text" value="<?= html_escape($cari) ?>" onkeypress="if (event.keyCode == 13){$('#'+'mainform').attr('action', '<?= site_url("data_persil/search") ?>');$('#'+'mainform').submit();}">
															<div class="input-group-btn">
																<button type="submit" class="btn btn-default" onclick="$('#'+'mainform').attr('action', '<?= site_url("data_persil/search") ?>');$('#'+'mainform').submit();"><i class="fa fa-search"></i></button>
															</div>
														</div>
													</div> -->
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12">
												<div class="table-responsive">
													<span class="loading-data">
														<span class="btn btn-block btn-info ">
															<i class="fa fa-spin fa-refresh"></i> Harap tunggu, data sedang diproses..
														</span>
														<hr>
													</span>
													<table class="table table-bordered table-striped dataTable table-hover loading-table" id="tablePersilList">
														<thead class="bg-gray disabled color-palette">
															<tr>
																<th class="no-sort">No</th>
																<!-- <th>Deskripsi</th> -->
																<th class="no-sort">Aksi</th>
																<th>Pemilik</th>
																<th>No. Surat</th>
																<th>No. SPPT</th>
																<th>NIB</th>
																<!-- <th>Jenis Persil</th> -->
																<th>Luas PTSL (m<span class="superscript">2</span>)</th>
																<!-- <th>Kelas Tanah</th> -->
																<th>Luas SPPT (m<span class="superscript">2</span>)</th>
																<!-- <th>Peruntukan</th> -->
																<!-- <th class="no-sort">Dusun</th>
																	<th class="no-sort">Blok</th>
																	<th class="no-sort">RW</th>
																	<th class="no-sort">RT</th> -->
																<!-- <th>Nama Jalan</th> -->
																<!-- <th>Keterangan</th> -->
																<th>Ditambah</th>
																<th>Diedit</th>
																<!-- <th>No. Persil : No. Urut Bidang</th>
																	<th>Kelas Tanah</th>
																	<th>Luas (M2)</th>
																	<th>Lokasi</th>
																	<th>C-Desa Awal</th>
																	<th>Jml Mutasi</th> -->
															</tr>
														</thead>
														<tbody>
															<?php foreach ($persil as $item) : ?>
																<tr>
																	<td><?= $item['no'] ?></td>
																	<!-- <td><?= $item['deskripsi'] ?></td> -->
																	<td><a href="<?= site_url("data_persil/update/" . $item["id"]) ?>" class="btn bg-orange btn-flat btn-sm" title="Ubah Data"><i class="fa fa-edit"></i></a></td>
																	<td>
																		<span data-toggle="tooltip" title="NIK : <?= $item['NIK'] ?>">
																			<?= $item['Nama_Pemil'] ?>
																		</span>
																	</td>
																	<td><?= $item['No_Surat_P'] ?></td>
																	<td><?= $item['Nomor_SPPT'] ?></td>
																	<td><?= $item['NIB'] ?></td>
																	<!-- <td><?= $item['Jenis_Pers'] ?></td> -->
																	<td><?= $item['Luas_PTSL'] ?></td>
																	<!-- <td><?= $item['Kelas_Tana'] ?></td> -->
																	<td><?= $item['Luas__SPPT'] ?></td>
																	<!-- <td><?= $item['Peruntukan'] ?></td> -->
																	<!-- <td><?= $item['Dusun'] ?></td>
																		<td><?= $item['Blok'] ?></td>
																		<td><?= $item['RW'] ?></td>
																		<td><?= $item['RT'] ?></td> -->
																	<!-- <td><?= $item['Nama_Jalan'] ?></td> -->
																	<!-- <td><?= $item['Keterangan'] ?></td> -->
																	<td><?= date("d/m/Y H:i", strtotime($item['tgl_diimport'])) ?></td>
																	<td><?= date("d/m/Y H:i", strtotime($item['tgl_diupdate'])) ?></td>
																	<!-- <td><?= $item['nomor'] . ' : ' . $item['nomor_urut_bidang'] ?></td>
																			<td><?= $persil_kelas[$item["kelas"]]['kode'] ?></td>
																			<td><?= $item['luas_persil'] ?></td>
																			<td><?= $item['alamat'] ?: $item['lokasi'] ?></td>
																			<td><a href="<?= site_url("cdesa/mutasi/$item[cdesa_awal]/$item[id]") ?>"><?= $item['nomor_cdesa_awal'] ?></a></td>
																			<td><?= $item['jml_bidang'] ?></td> -->
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<?php /*$this->load->view('global/paging'); */ ?>
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
<script>
</script>
<?php $this->load->view('global/confirm_delete'); ?>