<style>
	#mapx{
		width:100%;
		height:50vh
	}
	.icon {
		max-width: 70%;
		max-height: 70%;
		margin: 4px;
	}
	.leaflet-control-layers {
		display: block;
		position: relative;
	}
	.leaflet-control-locate a {
		font-size: 2em;
	}
	.content {
		min-height: unset;
	}
</style>
<script type="text/javascript">

	var infoWindow;
	window.onload = function() {
		<?php if (!empty($lokasi['lat']) && !empty($lokasi['lng'])): ?>
			var posisi = [<?=$lokasi['lat'].",".$lokasi['lng']?>];
			var zoom = 16;
		<?php else: ?>
			var posisi = [<?=$desa['lat'].",".$desa['lng']?>];
			var zoom = <?=$desa['zoom'] ?: 16?>;
		<?php endif; ?>
		
		var peta_leuit = L.map('mapx').setView(posisi, zoom);
		
		var marker_desa = [];
		var marker_dusun = [];
		var marker_rw = [];
		var marker_rt = [];

		//WILAYAH DESA
		<?php if (!empty($desa['path'])): ?>
			set_marker_desa(marker_desa, <?=json_encode($desa)?>, "<?=ucwords($this->setting->sebutan_desa).' '.$desa['nama_desa']?>", "<?= favico_desa()?>");
		<?php endif; ?>

		//WILAYAH DUSUN
		<?php if (!empty($dusun_gis)): ?>
			set_marker(marker_dusun, '<?=addslashes(json_encode($dusun_gis))?>', '#FFFF00', '<?=ucwords($this->setting->sebutan_dusun)?>', 'dusun');
		<?php endif; ?>

		//WILAYAH RW
		<?php if (!empty($rw_gis)): ?>
			set_marker(marker_rw, '<?=addslashes(json_encode($rw_gis))?>', '#8888dd', 'RW', 'rw');
		<?php endif; ?>

		//WILAYAH RT
		<?php if (!empty($rt_gis)): ?>
			set_marker(marker_rt, '<?=addslashes(json_encode($rt_gis))?>', '#008000', 'RT', 'rt');
		<?php endif; ?>

			//2. Menampilkan overlayLayers Peta Semua Wilayah
		<?php if (!empty($wil_atas['path'])): ?>
			var overlayLayers = overlayWil(marker_desa, marker_dusun, marker_rw, marker_rt);
		<?php else: ?>
			var overlayLayers = {};
		<?php endif; ?>

		var baseLayers = getBaseLayers(peta_leuit, '<?=$this->setting->google_key?>');

		//Menampilkan dan Menambahkan Peta wilayah + Geolocation GPS
		showCurrentPoint(posisi, peta_leuit);

		//Menambahkan zoom scale ke peta
		L.control.scale().addTo(peta_leuit);

		L.control.layers(baseLayers, overlayLayers, {position: 'topleft', collapsed: true}).addTo(peta_leuit);

	}; //EOF window.onload
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Pengaturan Lokasi Leuit</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Pengaturan Lokasi Leuit</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="mainform" name="mainform" action="" method="post">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
										<div class="row">
											<div class="col-sm-12">
												<div class="table-responsive">
													<table class="table table-bordered table-striped dataTable table-hover">
														<thead class="bg-gray disabled color-palette">
															<tr>
																<th>Foto Leuit</th>
																<th>Panorama</th>
																<th>Nama</th>
																<th>Volume</th>
																<th>Tingkat Kekeringan</th>
																<th>Produksi</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<tbody>
															<?php if($main) { ?>
																<?php foreach ($main as $data) : ?>
																	<tr>
																		<td style="width: 140px;">
																			<img src="<?= base_url().LOKASI_FOTO_LOKASI?>kecil_<?= $data['foto']?>" alt="">
																		</td>
																		<td style="width: 140px;">
																			<a href="<?= base_url().LOKASI_FOTO_LOKASI?><?= $data['panorama']?>" target="_blank">
																				<img src="<?= base_url().LOKASI_FOTO_LOKASI?><?= $data['panorama']?>" alt="" style="width:100%;height: auto!important;">
																			</a>
																		</td>
																		<td>
																			<?= $data['nama'] ?><br>
																			Dusun <?= $data['dusun'] ?>
																		</td>
																		<td><?= ton($data['volume']) ?></td>
																		<td><?= rp($data['tingkat_kekeringan']) ?>%</td>
																		<td><?= $data['produksi'] ?></td>
																		<td nowrap>
																			<a href="<?= site_url("leuit_lokasi/form/$p/$o/$data[id]") ?>" class="btn btn-warning btn-flat btn-sm" title="Ubah">
																				<i class="fa fa-edit"></i>
																			</a>
																		</td>
																	</tr>
																<?php endforeach; ?>
															<?php } else { ?>
																<tr>
																	<td colspan="7" class="text-center">
																		<p class="mt-2">Belum ada data</p>
																		<a href="<?= site_url("leuit_lokasi/form/$p/$o/$data[id]") ?>" class="btn btn-success btn-flat btn-sm mt-2" title="Tambah">
																			<i class="fa fa-edit"></i> Tambah
																		</a>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>

	<?php if($main) { ?>
	<section class="content">
		<!-- MAPS -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<?php foreach ($main as $peta) : ?>
						<form action="<?=$form_action_maps?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-12">
										<div id="mapx">
										</div>
									</div>
								</div>
							</div>
							<div class='box-footer'>
								<input type="hidden" name="id_desa" id="id_desa"  value="<?= $desaid ?>"/>
								<div class='col-xs-12'>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="lat">Lat</label>
										<div class="col-sm-9">
											<input type="text" class="form-control number" name="lat" id="lat" value="<?= $peta['lat_lokasi']?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="lat">Lng</label>
										<div class="col-sm-9">
											<input type="text" class="form-control number" name="lng" id="lng" value="<?= $peta['lng_lokasi']?>" />
										</div>
									</div>
									<button type='submit' class='btn btn-social btn-flat btn-info btn-sm pull-right'>
										<i class='fa fa-check'></i> Simpan
									</button>
								</div>
							</div>
						</form>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<script>
	// 	$(document).ready(function(){
	// 		$('#simpan_lokasi').click(function(){

	// 			$("#validasi1").validate({
	// 				errorElement: "label",
	// 				errorClass: "error",
	// 				highlight:function (element){
	// 					$(element).closest(".form-group").addClass("has-error");
	// 				},
	// 				unhighlight:function (element){
	// 					$(element).closest(".form-group").removeClass("has-error");
	// 				},
	// 				errorPlacement: function (error, element) {
	// 					if (element.parent('.input-group').length) {
	// 						error.insertAfter(element.parent());
	// 					} else {
	// 						error.insertAfter(element);
	// 					}
	// 				}
	// 			});

	// 			if (!$('#validasi1').valid()) return;

	// 			// window.location.reload(false);

	// 			var id_desa = <?= $data['id_desa']?>;
	// 			var lat = $('#lat').val();
	// 			var lng = $('#lng').val();

	// 			$.ajax({
	// 				type: "POST",
	// 				url: "<?=$form_action_maps?>",
	// 				dataType: 'json',
	// 				data: {lat: lat, lng: lng, id_desa: id_desa},
	// 			});
	// 		});
	// 	});
	// </script>

	<script src="<?= base_url()?>assets/js/leaflet.filelayer.js"></script>
	<script src="<?= base_url()?>assets/js/togeojson.js"></script>
	<?php } ?>
</div>
<?php $this->load->view('global/confirm_delete'); ?>