<?php
?>

<style>
	#map {
		width: 100%;
		height: 62vh
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
</style>
<!-- Menampilkan OpenStreetMap -->
<div class="content-wrapper">
	<section class="content-header">
		<h1>Peta Tutupan Lahan <?= $tutupan_lahan['nomor'] ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<?php foreach ($breadcrumb as $tautan) : ?>
				<li><a href="<?= $tautan['link'] ?>"> <?= $tautan['judul'] ?></a></li>
			<?php endforeach; ?>
			<li class="active">Peta Tutupan Lahan <?= $tutupan_lahan['id'] ?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<form action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
						<div class="box-body">
							<div class="row">
								<div class="col-sm-12">
									<div id="map">
										<input type="hidden" id="path" name="path" value="<?= $tutupan_lahan['path'] ?>">
										<input type="hidden" name="id" id="id" value="<?= $tutupan_lahan['id'] ?>" />
										<input type="hidden" name="zoom" id="zoom" value="<?= $tutupan_lahan['zoom'] ?>" />
									</div>
								</div>
							</div>
							<br><br>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="jenis" class="col-sm-3 control-label">Jenis</label>
										<div class="col-sm-9">
											<select <?php if (empty($tutupan_lahan)) echo "disabled" ?> class="form-control input-sm" id="jenis" name="jenis" type="text" placeholder="Jenis Tutpan Lahan">
												<option value>-- Pilih Jenis Tutupan Lahan--</option>
												<?php foreach ($tutupan_lahan_jenis  as $k => $v) : ?>
													<option value="<?= $v['id'] ?>" <?php selected($v['id'], $tutupan_lahan["jenis"]); ?>><?= $v['nama'] ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="luas" <?php if (empty($tutupan_lahan['id'])) echo 'style="display:none;"' ?> class="col-sm-3 control-label">Luas</label>
										<div class="col-sm-9">
											<input type="text" name="luas" id="luas" value="<?= $tutupan_lahan['luas'] ?>" <?php if (empty($tutupan_lahan['id'])) echo 'style="display:none;"' ?> class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label for="pemilik" <?php if (empty($tutupan_lahan['id'])) echo 'style="display:none;"' ?> class="col-sm-3 control-label">Pemilik</label>
										<div class="col-sm-9">
											<input type="text" name="pemilik" id="pemilik" value="<?= $tutupan_lahan['pemilik'] ?>" <?php if (empty($tutupan_lahan['id'])) echo 'style="display:none;"' ?> class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label for="pemilik" <?php if (empty($tutupan_lahan['id'])) echo 'style="display:none;"' ?> class="col-sm-3 control-label">Alamat</label>
										<div class="col-sm-9">
											<input type="text" name="alamat" id="alamat" value="<?= $tutupan_lahan['alamat'] ?>" <?php if (empty($tutupan_lahan['id'])) echo 'style="display:none;"' ?> class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label for="kelas" <?php if (empty($tutupan_lahan['id'])) echo 'style="display:none;"' ?> class="col-sm-3 control-label">Kelas</label>
										<div class="col-sm-9">
											<input type="text" name="kelas" id="kelas" value="<?= $tutupan_lahan['kelas'] ?>" <?php if (empty($tutupan_lahan['id'])) echo 'style="display:none;"' ?> class="form-control input-sm">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="more_info" <?php if (empty($tutupan_lahan['id'])) echo 'style="display:none;"' ?> class="col-sm-3 control-label">Deskripsi</label>
										<div class="col-sm-9">
											<textarea <?php if (empty($tutupan_lahan['id']))  echo 'style="display:none;"';
														else echo 'style="min-height: 200px;"' ?> class="form-control" name="more_info" id="more_info"><?= $tutupan_lahan['deskripsi'] ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class='box-footer'>
							<div class='col-xs-12'>
								<a href="<?= $tautan['link'] ?>" class="btn btn-flat bg-purple btn-sm" title="Kembali"><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
								<button type='reset' class='btn btn-flat btn-danger btn-sm' id="resetme"><i class='fa fa-times'></i> Reset</button>
								<button type='submit' class='btn btn-flat btn-info btn-sm pull-right'><i class='fa fa-check'></i> Simpan</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
	var infoWindow;
	window.onload = function() {
		//Jika posisi kantor dusun belum ada, maka posisi peta akan menampilkan peta desa
		<?php if (!empty($tutupan_lahan['lat']) && !empty($tutupan_lahan['lng'])) : ?>
			var posisi = [<?= $tutupan_lahan['lat'] . "," . $tutupan_lahan['lng'] ?>];
			// var zoom = <?= $tutupan_lahan['zoom'] ?>;
			var zoom = <?= $tutupan_lahan['zoom'] ?: 14 ?>;
		<?php else : ?>
			var posisi = [<?= $wil_atas['lat'] . "," . $wil_atas['lng'] ?>];
			// var zoom = <?= $wil_atas['zoom'] ?>;
			var zoom = <?= $wil_atas['zoom'] ?: 14 ?>;
		<?php endif; ?>

		//Inisialisasi tampilan peta
		var peta_wilayah = L.map('map').setView(posisi, zoom);

		//1. Menampilkan overlayLayers Peta Semua Wilayah
		var marker_desa = [];
		var marker_dusun = [];
		var marker_rw = [];
		var marker_rt = [];

		//OVERLAY WILAYAH DESA
		<?php if (!empty($desa['path'])) : ?>
			set_marker_desa(marker_desa, <?= json_encode($desa) ?>, "<?= ucwords($this->setting->sebutan_desa) . ' ' . $desa['nama_desa'] ?>", "<?= favico_desa() ?>");
		<?php endif; ?>

		//OVERLAY WILAYAH DUSUN
		<?php if (!empty($dusun_gis)) : ?>
			set_marker(marker_dusun, '<?= addslashes(json_encode($dusun_gis)) ?>', '#FFFF00', '<?= ucwords($this->setting->sebutan_dusun) ?>', 'dusun');
		<?php endif; ?>

		//OVERLAY WILAYAH RW
		<?php if (!empty($rw_gis)) : ?>
			set_marker(marker_rw, '<?= addslashes(json_encode($rw_gis)) ?>', '#8888dd', 'RW', 'rw');
		<?php endif; ?>

		//OVERLAY WILAYAH RT
		<?php if (!empty($rt_gis)) : ?>
			set_marker(marker_rt, '<?= addslashes(json_encode($rt_gis)) ?>', '#008000', 'RT', 'rt');
		<?php endif; ?>

		//Menampilkan overlayLayers Peta Semua Wilayah
		<?php if (!empty($wil_atas['path'])) : ?>
			var overlayLayers = overlayWil(marker_desa, marker_dusun, marker_rw, marker_rt);
		<?php else : ?>
			var overlayLayers = {};
		<?php endif; ?>

		//Menampilkan BaseLayers Peta
		var baseLayers = getBaseLayers(peta_wilayah, '<?= $this->setting->google_key ?>');

		//Menampilkan Peta wilayah yg sudah ada
		<?php if (!empty($tutupan_lahan['path'])) : ?>
			var wilayah = <?= $tutupan_lahan['path'] ?>;
			showCurrentPolygon(wilayah, peta_wilayah);
		<?php endif; ?>

		//Menambahkan zoom scale ke peta
		L.control.scale().addTo(peta_wilayah);

		//Menambahkan toolbar ke peta
		peta_wilayah.pm.addControls(editToolbarPoly());

		//Menambahkan Peta wilayah
		addPetaPoly(peta_wilayah);

		// update value zoom ketika ganti zoom
		updateZoom(peta_wilayah);

		//Export/Import Peta dari file GPX
		// L.Control.FileLayerLoad.LABEL = '<img class="icon" src="<?= base_url() ?>assets/images/gpx.png" alt="file icon"/>';
		// L.Control.FileLayerLoad.TITLE = 'Impor GPX/KML';
		// control = eximGpxPoly(peta_wilayah);

		//Import Peta dari file SHP
		eximShpPersil(peta_wilayah, "tutupan_lahan");

		//Geolocation IP Route/GPS
		// geoLocation(peta_wilayah);

		//Menghapus Peta wilayah
		hapusPeta(peta_wilayah);

		//Menampilkan baseLayers dan overlayLayers
		L.control.layers(baseLayers, overlayLayers, {
			position: 'topleft',
			collapsed: true
		}).addTo(peta_wilayah);

		$('form').bind('submit', function() {
			$(this).find(':input').prop('disabled', false);
		});

	}; //EOF window.onload
</script>
<script src="<?= base_url() ?>assets/js/leaflet.filelayer.js"></script>
<script src="<?= base_url() ?>assets/js/togeojson.js"></script>