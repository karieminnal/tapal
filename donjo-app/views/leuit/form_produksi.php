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
<div class="content-wrapper">
	<section class="content-header">
		<h1>Tambah Produksi</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?= site_url('leuit_panen') ?>"><i class="fa fa-dashboard"></i> Leuit Produksi</a></li>
			<li class="active">Tambah</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="validasi" action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<a href="<?= site_url("leuit_panen") ?>" class="btn btn-info btn-sm" title="">
								<i class="fa fa-arrow-circle-left "></i>Kembali
							</a>
						</div>
						
						<?php if($list_sawah) { ?>
							<div class="box-body">
								<div id="map"></div>
								<br>
								<br>
								<div class="form-group">
									<label class="control-label col-sm-3">Tanggal Masuk</label>
									<div class="col-sm-7">
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" name="tanggal_produksi" class="form-control pull-right datepicker required" value="<?= tgl_indo_out($produksi['tanggal_produksi']) ?>">
										</div>
									</div>
								</div>
								<div class='form-group'>
									<label class="control-label col-sm-3"><?= ucwords($this->setting->sebutan_dusun) ?></label>
									<div class="col-sm-7">
										<select name="dusun_id" class="form-control input-sm required" id="selectDusun" onchange="layerDusunClick($(this).val())">
											<option value="">Pilih <?= ucwords($this->setting->sebutan_dusun) ?></option>
											<?php foreach ($dusun as $data) : ?>
												<option value="<?= $data['id'] ?>" data-alamat="<?= $data['dusun'] ?>" <?php selected($produksi['dusun'], $data['id']) ?>><?= $data['dusun'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3">Sawah</label>
									<div class="col-sm-7">
										<img src="<?= base_url() ?>assets/images/loader.gif" class="loader-gif" style="display:none;" />
										<select name="sawah" class="form-control input-sm required select-sawah select2" id="idsawah" data-source="<?= site_url() ?>tutupan_lahan/sawarSearch/" onchange="selectSawahSelect($(this).val())" data-valueKey="sawah" data-displayKey="sawah">
											<option value="">Pilih Dusun Terlebih Dahulu</option>
											<?php if($produksi) { ?>
												<?php foreach ($list_sawah as $data) : ?>
													<option value="<?= $data['id'] ?>" <?php selected($produksi['sawah'], $data['id']) ?>><?= $data['pemilik'] ?> (<?= $data['luas'] ?> Ha)</option>
												<?php endforeach; ?>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3">Harga/Kg</label>
									<div class="col-sm-7">
										<input name="harga" class="form-control input-sm nomor_sk required" maxlength="100" type="number" value="<?= $produksi['harga'] ?>"></input>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3">Jumlah (Kg)</label>
									<div class="col-sm-7">
										<input name="jumlah_panen" class="form-control input-sm nomor_sk required" maxlength="100" type="text" value="<?= $produksi['jumlah_panen'] ?>" pattern="^\d*(\.\d{0,2})?$"></input>
									</div>
								</div>
							</div>
							<div class='box-footer'>
								<div class='col-xs-12'>
									<button type='reset' class='btn btn-social btn-flat btn-danger btn-sm' onclick="reset_form($(this).val());"><i class='fa fa-times'></i> Batal</button>
									<button type='submit' class='btn btn-social btn-flat btn-info btn-sm pull-right confirm'><i class='fa fa-check'></i> Simpan</button>
								</div>
							</div>
						<?php } else { ?>
							<div class="box-body">
								<p class="text-center mt-3 mb-3">
									Tutupan Lahan Sawah belum ada. Silahkan input sawah terlebih dahulu
								</p>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
<?php if($list_sawah) { ?>
	<script>
		function reset_form() {
			<?php if ($lokasi['enabled'] == '1' or $lokasi['enabled'] == NULL) : ?>
				$("#sx3").addClass('active');
				$("#sx4").removeClass("active");
			<?php endif ?>
			<?php if ($lokasi['enabled'] == '2') : ?>
				$("#sx4").addClass('active');
				$("#sx3").removeClass("active");
			<?php endif ?>
		};
		$(document).on('keydown', 'input[pattern]', function(e){
			var input = $(this);
			var oldVal = input.val();
			var regex = new RegExp(input.attr('pattern'), 'g');

			setTimeout(function(){
				var newVal = input.val();
				if(!regex.test(newVal)){
				input.val(oldVal); 
				}
			}, 1);
		});
		
		var infoWindow;
		var select2;
		// $("#idsawah").select2();

		window.onload = function() {
			
			// select2 = $(".select-sawah").select2();

			<?php if (!empty($list_sawah['lat']) && !empty($list_sawah['lng'])) : ?>
				var posisi = [<?= $list_sawah['lat'] . "," . $list_sawah['lng'] ?>];
				var zoom = <?= $list_sawah['zoom'] ?: 14 ?>;
			<?php else : ?>
				var posisi = [<?= $wil_atas['lat'] . "," . $wil_atas['lng'] ?>];
				var zoom = <?= $wil_atas['zoom'] ?: 14 ?>;
			<?php endif; ?>

			var peta_wilayah = L.map('map').setView(posisi, zoom);
			var marker_dusun = [];

			<?php if (!empty($dusun_gis)) : ?>
				set_marker_dusun(marker_dusun, '<?= addslashes(json_encode($dusun_gis)) ?>', '#FFFF00', 'DUSUN', 'dusun');
			<?php endif; ?>

			var baseLayers = getBaseLayers(peta_wilayah, '');
			addPetaPoly(peta_wilayah);

			var style_polygon = {
				weight: 0.5,
				color: '#FFFFFF',
				opacity: 1,
				fillOpacity: 0.3,
			};

			var layerLahan = L.geoJSON(getData(), {
				coordsToLatLng: function (coords) {
					return new L.LatLng(coords[0], coords[1]);
				},
				style: style_polygon,
				onEachFeature: function (feature, layer) {
					layer.setStyle({
						fillColor: configColor.hightlight,
						weight: 0.5,
						className: 'poly-sawah poly-sawah-' + feature.properties.id,
					});
					layer.on('load', function () {
						this.setStyle({
							fillColor: configColor.hightlight,
							fillOpacity: 0.3,
						});
					});
					layer.on('mouseover', function () {
						this.setStyle({
							fillColor: configColor.hightlight,
							fillOpacity: 0.6,
						});
					});
					layer.on('mouseout', function () {
						this.setStyle({
							fillColor: configColor.hightlight,
							fillOpacity: 0.3,
						});
					});
					layer.on('click', function () {
						layerSawahClick(feature.properties.id)
					});

					var thisLuas = parseFloat(feature.properties.luas);
					var luasDec = Number(thisLuas).toFixed(2);
					var perNamaPemilik =
						feature.properties.pemilik !== ''
						? '<tr><td>Pemilik</td><td>: ' +
							feature.properties.pemilik +
							'</td></tr>'
						: '',
					perAlamat =
						feature.properties.alamat !== ''
						? '<tr><td>Alamat</td><td>: ' +
							feature.properties.alamat +
							'</td></tr>'
						: '',
					perLuas =
						feature.properties.luas !== '0'
						? '<tr><td>Luas</td><td>: ' +
						luasDec +
							' Ha</td></tr>'
						: '',
					perKelasTanah =
						feature.properties.kelas !== ''
						? '<tr><td>Kelas Tanah</td><td>: ' +
							feature.properties.kelas +
							'</td></tr>'
						: '';
					var mergeDataSawah =
					'<table class="table-data-persil">' +
					perNamaPemilik +
					perLuas +
					perKelasTanah +
					perAlamat + 
					'</table>';
					var contentSawah = mergeDataSawah;
					// layer.bindPopup(contentSawah);
					layer.bindTooltip(contentSawah);
				},
			});
			layerLahan.addTo(peta_wilayah);

			<?php if (!empty($wil_atas['path'])) : ?>
				var overlayLayers = overlayWilDusun(marker_dusun, peta_wilayah);
				// overlayLayers.addTo(peta_wilayah);
			<?php else : ?>
				var overlayLayers = {};
			<?php endif; ?>

			// $('#idSawah').change(function(){
			// 	var thisVal = $(this).val();
			// 	// layerSawahClick(thisVal);
			// 	$('.poly-sawah').removeClass('highlight');
			// 	$('.poly-sawah-' + thisVal).addClass('highlight');
			// 	console.log(thisVal);
			// });
			
			<?php if($produksi) { ?>
				// layerDusunClick(<?php echo $produksi['dusun'] ?>);
				$('.poly-sawah').removeClass('highlight');
				$('.poly-dusun').removeClass('dusun-show');
				$('.tooltip-dusun').removeClass('tootip-show');
				$('.poly-dusun.dusun-<?php echo $produksi['dusun'] ?>').addClass('dusun-show');
				$('.tooltip-dusun.dusun-<?php echo $produksi['dusun'] ?>').addClass('tootip-show');
				<?php if($produksi['sawah']) { ?>
					$('.poly-sawah').removeClass('highlight');
					$('.poly-sawah-<?php echo $produksi['sawah'] ?>').addClass('highlight');
				<?php } ?>

				// updateZoom(peta_wilayah);
			<?php } ?>
		};
		
		function getData() { 
			return {
				"type": "FeatureCollection",
				"features": [
					<?php foreach ($list_sawah as $data) { ?>
						{
							"type": "Feature",
							"properties": {
								"id": <?= $data['id'] ?>,
								"jenis": <?= $data['jenis'] ?>,
								"kelas": '<?= $data['kelas'] ?>',
								"pemilik": "<?= $data['pemilik'] ?>",
								"luas": <?= $data['luas'] ?>,
								"alamat": "<?= $data['alamat'] ?>"
							},
							"geometry": {
								"type": "Polygon",
								"coordinates": <?= $data['path'] ?>
							}
						},
					<?php } ?>
				]
			};
		}

		function layerDusunClick(idDusun) {
			$('.poly-sawah').removeClass('highlight');
			$('.poly-dusun').removeClass('dusun-show');
			$('.tooltip-dusun').removeClass('tootip-show');
			$('.poly-dusun.dusun-' + idDusun).addClass('dusun-show');
			$('.tooltip-dusun.dusun-' + idDusun).addClass('tootip-show');
			$('#selectDusun').val(idDusun).attr('selected', 'selected');
			var thisAlamat = $('#selectDusun').find(':selected').data('alamat');

			$('#isi_sawah').hide();
			var sawah = $('#idsawah');
			select_options_sawah(sawah, urlencode(thisAlamat));
			//   layerSawahClick(idDusun);
		}
		function layerSawahClick(id) {
			$('select#idsawah option[value=' + id + ']').attr('selected', 'selected');
			$('select#idsawah').val(id).trigger('change');
			$('.poly-sawah').removeClass('highlight');
			$('.poly-sawah-' + id).addClass('highlight');
		}
		function selectSawahSelect(id) {
			$('.poly-sawah').removeClass('highlight');
			$('.poly-sawah-' + id).addClass('highlight');
			// peta_wilayah.fitBounds(layerPersil.getBounds());
		}
	</script>
	<script src="<?= base_url() ?>assets/js/leaflet.filelayer.js"></script>
	<script src="<?= base_url() ?>assets/js/togeojson.js"></script>
<?php } ?>