<?php
/*
 * File ini:
 *
 * View di Modul Identitas Desa di OpenSID
 *
 * /donjo-app/views/sid/wilayah/maps_wilayah.php
 *
 */

/**
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:

 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.

 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package OpenSID
 * @author  Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license http://www.gnu.org/licenses/gpl.html  GPL V3
 * @link  https://github.com/OpenSID/OpenSID
 */
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
		<h1>Peta Persil <?= $persil['nomor'] ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<?php foreach ($breadcrumb as $tautan) : ?>
				<li><a href="<?= $tautan['link'] ?>"> <?= $tautan['judul'] ?></a></li>
			<?php endforeach; ?>
			<li class="active">Peta Wilayah Persil <?= $persil['id'] ?></li>
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
										<input type="hidden" id="path" name="path" value="<?= $persil['path'] ?>">
										<input type="hidden" name="id" id="id" value="<?= $persil['id'] ?>" />
										<input type="hidden" name="zoom" id="zoom" value="<?= $persil['zoom'] ?>" />
									</div>
								</div>
							</div>
							<input type="hidden" id="more_info" name="more_info" value="">
							<?php if (!empty($persil['id'])) : ?>
								<div class="row">
									</br>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="Nama_Pemil" class="col-sm-3 control-label">Nama Pemilik</label>
											<div class="col-sm-8">
												<input name="Nama_Pemil" class="form-control input-sm" type="text" value="<?= $persil['Nama_Pemil'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="No_Surat_P" class="col-sm-3 control-label">No. Surat Persil</label>
											<div class="col-sm-8">
												<input name="No_Surat_P" class="form-control input-sm" type="text" value="<?= $persil['No_Surat_P'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="NIB" class="col-sm-3 control-label">NIB</label>
											<div class="col-sm-8">
												<input name="NIB" class="form-control input-sm angka" type="text" value="<?= $persil['NIB'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="Luas_PTSL" class="col-sm-3 control-label">Luas PTSL</label>
											<div class="col-sm-8">
												<input name="Luas_PTSL" class="form-control input-sm angka" type="text" value="<?= $persil['Luas_PTSL'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="Luas__SPPT" class="col-sm-3 control-label">Luas SPPT</label>
											<div class="col-sm-8">
												<input name="Luas__SPPT" class="form-control input-sm angka" type="text" value="<?= $persil['Luas__SPPT'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="Dusun" class="col-sm-3 control-label">Dusun</label>
											<div class="col-sm-8">
												<input name="Dusun" class="form-control input-sm" type="text" value="<?= $persil['Dusun'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="RW" class="col-sm-3 control-label">RW</label>
											<div class="col-sm-8">
												<input name="RW" class="form-control input-sm angka" type="text" value="<?= $persil['RW'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="Alamat" class="col-sm-3 control-label">Alamat</label>
											<div class="col-sm-8">
												<input name="Alamat" class="form-control input-sm" type="text" value="<?= $persil['Alamat'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="Nama_Jalan" class="col-sm-3 control-label">Nama Jalan</label>
											<div class="col-sm-8">
												<input name="Nama_Jalan" class="form-control input-sm" type="text" value="<?= $persil['Nama_Jalan'] ?>">
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="NIK" class="col-sm-3 control-label">NIK</label>
											<div class="col-sm-8">
												<input name="NIK" class="form-control input-sm angka" type="text" value="<?= $persil['NIK'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="Nomor_SPPT" class="col-sm-3 control-label">No. SPPT</label>
											<div class="col-sm-8">
												<input name="Nomor_SPPT" class="form-control input-sm" type="text" value="<?= $persil['Nomor_SPPT'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="Jenis_Pers" class="col-sm-3 control-label">Jenis Persil</label>
											<div class="col-sm-8">
												<input name="Jenis_Pers" class="form-control input-sm" type="text" value="<?= $persil['Jenis_Pers'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="Kelas_Tana" class="col-sm-3 control-label">Kelas Tanah</label>
											<div class="col-sm-8">
												<input name="Kelas_Tana" class="form-control input-sm" type="text" value="<?= $persil['Kelas_Tana'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="Peruntukan" class="col-sm-3 control-label">Peruntukan</label>
											<div class="col-sm-8">
												<input name="Peruntukan" class="form-control input-sm" type="text" value="<?= $persil['Peruntukan'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="Blok" class="col-sm-3 control-label">Blok</label>
											<div class="col-sm-8">
												<input name="Blok" class="form-control input-sm angka" type="text" value="<?= $persil['Blok'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="RT" class="col-sm-3 control-label">RT</label>
											<div class="col-sm-8">
												<input name="RT" class="form-control input-sm angka" type="text" value="<?= $persil['RT'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="Keterangan" class="col-sm-3 control-label">Keterangan</label>
											<div class="col-sm-8">
												<input name="Keterangan" class="form-control input-sm" type="text" value="<?= $persil['Keterangan'] ?>">
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>


						<div class='box-footer'>
							<div class='col-xs-12'>
								<a href="<?= $tautan['link'] ?>" class="btn btn-social btn-flat bg-purple btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Kembali"><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
								<a href="#" class="btn btn-social btn-flat btn-success btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" download="OpenSID.gpx" id="exportGPX"><i class='fa fa-download'></i> Export ke GPX</a>
								<button type='reset' class='btn btn-social btn-flat btn-danger btn-sm' id="resetme"><i class='fa fa-times'></i> Reset</button>
								<button type='submit' class='btn btn-social btn-flat btn-info btn-sm pull-right'><i class='fa fa-check'></i> Simpan</button>
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
		<?php if (!empty($persil['lat']) && !empty($persil['lng'])) : ?>
			var posisi = [<?= $persil['lat'] . "," . $persil['lng'] ?>];
			// var zoom = <?= $persil['zoom'] ?>;
			var zoom = <?= $persil['zoom'] ?: 14 ?>;
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
		<?php if (!empty($persil['path'])) : ?>
			var wilayah = <?= $persil['path'] ?>;
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
		L.Control.FileLayerLoad.LABEL = '<img class="icon" src="<?= base_url() ?>assets/images/gpx.png" alt="file icon"/>';
		L.Control.FileLayerLoad.TITLE = 'Impor GPX/KML';
		// control = eximGpxPoly(peta_wilayah);

		//Import Peta dari file SHP
		eximShpPersil(peta_wilayah, 'persil');

		//Geolocation IP Route/GPS
		// geoLocation(peta_wilayah);

		//Menghapus Peta wilayah
		hapusPeta(peta_wilayah);

		//Menampilkan baseLayers dan overlayLayers
		L.control.layers(baseLayers, overlayLayers, {
			position: 'topleft',
			collapsed: true
		}).addTo(peta_wilayah);

	}; //EOF window.onload
</script>
<script src="<?= base_url() ?>assets/js/leaflet.filelayer.js"></script>
<script src="<?= base_url() ?>assets/js/togeojson.js"></script>