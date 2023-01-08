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
		<h1>Wilayah Provinsi <?php echo $wil_atas['nama_provinsi'] ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<?php foreach ($breadcrumb as $tautan) : ?>
				<li><a href="<?= $tautan['link'] ?>"> <?= $tautan['judul'] ?></a></li>
			<?php endforeach; ?>
			<li class="active">Peta</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<form action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
						<div class="box-body">
							<div class="clone-input">
								<input id="nama_propinsi" name="nama_propinsi" class="form-control input-sm required" type="hidden" placeholder="Nama Provinsi" value="<?= $provinsi["nama_provinsi"]; ?>" />
							</div>
							<div class="form-group row row-provinsi">
								<label class="control-label col-sm-3" >Provinsi</label>
								<div class="col-sm-8">
									<select class="form-control required" name="pilihProvinsi" id="pilihProvinsi">
										<option></option>
										<?php foreach ($listprovinsi as $data) { ?>
											<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($provinsi['id_provinsi']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
										<?php } ?>
									</select>
									<img src="<?= base_url() ?>assets/images/loader.gif" id="load2" style="display:none;" />
								</div>
							</div>
							<div class="form-group row row-kota">
								<label class="control-label col-sm-3" >Kota/Kabupaten</label>
								<div class="col-sm-8">          
									<select class="form-control required" name="pilihKota" id="pilihKota">
										<option></option>
										<?php if($provinsi["id_kota"]) { ?>
											<?php foreach ($listkota as $data) { ?>
												<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($provinsi['id_kota']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
											<?php } ?>
										<?php } ?>
									</select>
									<img src="<?= base_url() ?>assets/images/loader.gif" id="load2" style="display:none;" />
								</div>
							</div>
							<div class="form-group row row-kecamatan">
								<label class="control-label col-sm-3" >Kecamatan</label>
								<div class="col-sm-8">          
									<select class="form-control required" name="pilihKecamatan" id="pilihKecamatan">
										<option></option>
										<?php if($provinsi["id_kecamatan"]) { ?>
											<?php foreach ($listkec as $data) { ?>
												<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($provinsi['id_kecamatan']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
											<?php } ?>
										<?php } ?>
									</select>
									<div class="text-center"></div>
									<img src="<?= base_url() ?>assets/images/loader.gif" id="load3" style="display:none;" />
								</div>
							</div>
							<div class="form-group row row-desa">
								<label class="control-label col-sm-3" >Kelurahan/Desa</label>
								<div class="col-sm-8">          
									<select class="form-control required" name="pilihKelurahan" id="pilihKelurahan">
										<option></option>
										<?php if($provinsi["id_kelurahan"]) { ?>
											<?php foreach ($listkel as $data) { ?>
												<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($provinsi['id_kelurahan']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="kode_pos">Kode Pos</label>
								<div class="col-sm-2">
									<input id="kode_pos" name="kode_pos" class="form-control input-sm number" maxlength="6" type="text" placeholder="Kode Pos" value="<?= $provinsi["kode_pos"]; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="nama_jalan">Nama Jalan</label>
								<div class="col-sm-2">
									<input id="nama_jalan" name="nama_jalan" class="form-control input-sm" type="text" placeholder="Nama Jalan" value="<?= $provinsi["nama_jalan"]; ?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label" for="gubernur">Gubernur</label>
								<div class="col-sm-8">
									<input id="gubernur" name="gubernur" class="form-control input-sm required" maxlength="50" type="text" placeholder="Gubernur" value="<?= $provinsi["gubernur"] ?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label" for="lat">Lat</label>
								<div class="col-sm-9">
									<input type="text" class="form-control input-sm number" name="lat" id="lat" value="<?= $provinsi['lat']?>"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="lat">Lng</label>
								<div class="col-sm-9">
									<input type="text" class="form-control input-sm number" name="lng" id="lng" value="<?= $provinsi['lng']?>" />
								</div>
							</div>
						</div>
									<!-- <input type="text" id="path" name="path" value="<?= $provinsi['path'] ?>"> -->
									<input type="text" name="id" id="id" value="<?= $provinsi['id'] ?>" />
									<input type="text" name="zoom" id="zoom" value="" />
									<textarea id="path" name="path" cols="30" rows="10"><?= $provinsi['path'] ?></textarea>
							<div class="row">
								<div class="col-sm-12">
									<div id="map">
									</div>
								</div>
							</div>
						</div>
						<div class='box-footer'>
							<div class='col-xs-12'>
								<a href="<?= $tautan['link'] ?>" class="btn bg-purple btn-sm" title="Kembali"><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
								<button type='submit' class='btn btn-info btn-sm pull-right'><i class='fa fa-check'></i> Simpan</button>
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
		<?php if (!empty($provinsi['lat']) && !empty($provinsi['lng'])) : ?>
			var posisi = [<?= $provinsi['lat'] . "," . $provinsi['lng'] ?>];
			var zoom = 9;
		<?php else : ?>
			var posisi = [<?= $wil_atas['lat'] . "," . $wil_atas['lng'] ?>];
			var zoom = 9;
		<?php endif; ?>

		//Inisialisasi tampilan peta
		var peta_wilayah = L.map('map').setView(posisi, zoom);
		var overlayLayers = {};

		//Menampilkan BaseLayers Peta
		var baseLayers = getBaseLayers(peta_wilayah);

		//Menambahkan zoom scale ke peta
		L.control.scale().addTo(peta_wilayah);

		//Menambahkan toolbar ke peta
		peta_wilayah.pm.addControls(editToolbarPoly());

		//Menambahkan Peta wilayah
		addPetaPoly(peta_wilayah);

		// update value zoom ketika ganti zoom
		updateZoom(peta_wilayah);

		//Import Peta dari file SHP
		shpProv(peta_wilayah);

		//Geolocation IP Route/GPS
		// geoLocation(peta_wilayah);

		//Menghapus Peta wilayah
		hapusPeta(peta_wilayah);

		//Menampilkan baseLayers dan overlayLayers
		L.control.layers(baseLayers, overlayLayers, {
			position: 'topleft',
			collapsed: true
		}).addTo(peta_wilayah);

		//Menampilkan Peta wilayah yg sudah ada
		<?php if (!empty($provinsi['path'])) : ?>
			var wilayah = <?php echo $provinsi['path'] ?>;
			
			showCurrentPolygonProv(wilayah, peta_wilayah);
		<?php endif; ?>

		$('form').bind('submit', function() {
			$(this).find(':input').prop('disabled', false);
		});

	}; //EOF window.onload
</script>
<script src="<?= base_url() ?>assets/js/leaflet.filelayer.js"></script>
<script src="<?= base_url() ?>assets/js/togeojson.js"></script>