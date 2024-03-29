<?php
?>

<script>
var infoWindow;
window.onload = function()
{
	<?php if (!empty($lokasi['lat']) && !empty($lokasi['lng'])): ?>
		var posisi = [<?=$lokasi['lat'].",".$lokasi['lng']?>];
		var zoom = 16;
	<?php else: ?>
		var posisi = [<?=$desa['lat'].",".$desa['lng']?>];
		var zoom = <?=$desa['zoom'] ?: 16?>;
	<?php endif; ?>

	//Inisialisasi tampilan peta
	var peta_kantor = L.map('mapx').setView(posisi, zoom);

	//1. Menampilkan overlayLayers Peta Semua Wilayah
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

	//Menampilkan BaseLayers Peta
  var baseLayers = getBaseLayers(peta_kantor, '<?=$this->setting->google_key?>');

	//Menampilkan dan Menambahkan Peta wilayah + Geolocation GPS
	showCurrentPoint(posisi, peta_kantor);

	//Export/Import Peta dari file GPX
	L.Control.FileLayerLoad.LABEL = '<img class="icon" src="<?= base_url()?>assets/images/gpx.png" alt="file icon"/>';
	L.Control.FileLayerLoad.TITLE = 'Impor GPX/KML';
	controlGpxPoint = eximGpxPoint(peta_kantor);

	//Menambahkan zoom scale ke peta
	L.control.scale().addTo(peta_kantor);

	L.control.layers(baseLayers, overlayLayers, {position: 'topleft', collapsed: true}).addTo(peta_kantor);

}; //EOF window.onload
</script>
<style>
	#mapx
	{
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
</style>
<!-- Menampilkan OpenStreetMap dalam Box modal bootstrap (AdminLTE)  -->
<div class="content-wrapper">
	<section class="content-header">
		<h1>Lokasi <?= $lokasi['nama']?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?= site_url('leuit_lokasi')?>"> Pengaturan Lokasi Leuit</a></li>
			<li class="active">Lokasi <?= $lokasi['nama']?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<form id="validasi1" action="<?= $form_action?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
						<div class="box-body">
							<div class="row">
								<div class="col-sm-12">
									<div id="mapx">
										<input type="hidden" name="id" id="id"  value="<?= $lokasi['id']?>"/>
									</div>
								</div>
							</div>
						</div>
						<div class='box-footer'>
							<div class='col-xs-12'>
								<div class="form-group">
									<label class="col-sm-3 control-label" for="lat">Lat</label>
									<div class="col-sm-9">
										<input type="text" class="form-control number" name="lat" id="lat" value="<?= $lokasi['lat']?>"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label" for="lat">Lng</label>
									<div class="col-sm-9">
										<input type="text" class="form-control number" name="lng" id="lng" value="<?= $lokasi['lng']?>" />
									</div>
								</div>
								<a href="<?= site_url('leuit_lokasi')?>" class="btn btn-social btn-flat bg-purple btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Kembali"><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
								<button type='reset' class='btn btn-social btn-flat btn-danger btn-sm' id="resetme"><i class='fa fa-times'></i> Reset</button>
								<button type='submit' class='btn btn-social btn-flat btn-info btn-sm pull-right' id="simpan_kantor"><i class='fa fa-check'></i> Simpan</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
	$(document).ready(function(){
		$('#simpan_kantor').click(function(){

			$("#validasi1").validate({
				errorElement: "label",
				errorClass: "error",
				highlight:function (element){
					$(element).closest(".form-group").addClass("has-error");
				},
				unhighlight:function (element){
					$(element).closest(".form-group").removeClass("has-error");
				},
				errorPlacement: function (error, element) {
					if (element.parent('.input-group').length) {
						error.insertAfter(element.parent());
					} else {
						error.insertAfter(element);
					}
				}
			});

			if (!$('#validasi1').valid()) return;

			window.location.reload(false);

			var id = $('#id').val();
			var lat = $('#lat').val();
			var lng = $('#lng').val();

			$.ajax({
				type: "POST",
				url: "<?=$form_action?>",
				dataType: 'json',
				data: {lat: lat, lng: lng, id: id},
			});
		});
	});
</script>

<script src="<?= base_url()?>assets/js/leaflet.filelayer.js"></script>
<script src="<?= base_url()?>assets/js/togeojson.js"></script>
