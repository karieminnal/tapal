<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view($folder_themes . '/layouts/header.php'); ?>
<div id="map">
</div>

<!-- content popup -->
<?php foreach ($desaall as $listdesa) { ?>
<div id="isi_popup_<?php echo $listdesa['id'] ?>" style="visibility: hidden;" class="isi-popup">
	<?php $this->load->view("gis/content_desa_web.php", array('desa' => $listdesa, 'list_lap_front' => $list_lap_front, 'wilayah' => ucwords($this->setting->sebutan_desa . ' ' . $listdesa['nama_desa']))) ?>
</div>
<?php } ?>
<?php foreach ($getLeuitLokasi as $leuit) { ?>
<div id="isi_popup_leuit_<?php echo $leuit['id'] ?>" style="visibility: hidden;" class="isi-popup">
	<?php $this->load->view("gis/content_leuit_web.php", array('leuit' => $leuit, 'wilayah' => ucwords($leuit['nama']), 'desa' => ucwords($leuit['id_desa']))) ?>
</div>
<?php } ?>
<?php $this->load->view("gis/content_dusun_web.php", array('dusun_gis' => $dusun_gis, 'list_lap_front' => $list_lap_front, 'wilayah' => ucwords($this->setting->sebutan_dusun . ' '))) ?>
<?php $this->load->view("gis/content_rw_web.php", array('rw_gis' => $rw_gis, 'list_lap_front' => $list_lap_front, 'wilayah' => ucwords($this->setting->sebutan_dusun . ' '))) ?>
<?php $this->load->view("gis/content_rt_web.php", array('rt_gis' => $rt_gis, 'list_lap_front' => $list_lap_front, 'wilayah' => ucwords($this->setting->sebutan_dusun . ' '))) ?>

</section>
</main>
<script id="scriptJquery" type="text/javascript" src="<?= base_url() ?>assets/front/js/jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/vendors.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/select2/js/select2.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/select2/js/i18n/id.js"></script> 
<!-- <script defer src="<?= base_url() ?>assets/js/leaflet-measure-path.js"></script> -->
<script type="text/javascript">
	var loadJS = function(url, scriptOnLoad, location) {
		var scriptTag = document.createElement('script');
		scriptTag.src = url;
		scriptTag.onload = scriptOnLoad;
		scriptTag.onreadystatechange = scriptOnLoad;
		$(scriptTag).insertAfter('#scriptJquery');
	};
	var scriptOnLoad = function() {

	}

	loadJS('<?= base_url() ?>assets/js/config.js', scriptOnLoad, document.body);
	loadJS('<?= base_url() ?>assets/js/peta.js', scriptOnLoad, document.body);
	loadJS('<?= base_url() ?>assets/js/peta-new.js', scriptOnLoad, document.body);

	<?php if (isset($userdata['nama'])) : ?>
		loadJS('<?= base_url() ?>assets/front/js/main.id.min.js', scriptOnLoad, document.body);
	<?php else : ?>
		$('.main-nav ul li a.has-child').on('click', function (e) {
			e.preventDefault();
			var t = $(this).parent(),
			n = t.find('.sub-kategori').eq(0);
			n.slideToggle(function () {
				$(n).is(':visible') ? t.addClass('active') : t.removeClass('active');
			});
		});
	<?php endif; ?>
</script>
<script defer type="text/javascript">
	<?php if (!empty($data_prov['lat']) && !empty($data_prov['lng'])) : ?>
		var posisi = [<?= $data_prov['lat'] . "," . $data_prov['lng'] ?>];
		var zoom = 9;
	<?php else : ?>
		var posisi = [-6.90232, 107.618766];
		var zoom = 9;
	<?php endif; ?>

	var bounds = new L.LatLngBounds(
		new L.LatLng(<?= $data_prov['lat'] . "," . $data_prov['lng'] ?>),
		new L.LatLng(<?= $data_prov['lat'] . "," . $data_prov['lng'] ?>));

	var map = L.map('map', {
		zoomControl: false,
		zoomDelta: 0.25,
		zoomSnap: 0
	}).fitBounds(bounds);
	L.control.zoom({
		position: 'topright',
		loadingControl: true
	}).addTo(map);

	petaProv(map);
	
	var style_polygon = {};

	var marker_desa = [];
	var marker_dusun = [];
	var marker_rw = [];
	var marker_rt = [];
	var marker_leuit = [];
	
	<?php foreach ($desaall as $listdesa) { ?>
		<?php if (!empty($listdesa['path'])) { ?>
			setPolygonDesa(marker_desa, <?= json_encode($listdesa) ?>, "<?= ucwords($this->setting->sebutan_desa) . ' ' . $listdesa['nama_desa'] ?>", "<?= gambar_desa($listdesa['logo']); ?>", "#isi_popup_<?= $listdesa['id'] ?>", "<?= $listdesa['id'] ?>");
		<?php } ?>
	<?php } ?>
	<?php if (!empty($desa['path'])) : ?>
		
	<?php endif; ?>
	<?php if (!empty($dusun_gis)) : ?>
		setPolygonContent(marker_dusun, '<?= addslashes(json_encode($dusun_gis)) ?>', '', '<?= ucwords($this->setting->sebutan_dusun) ?>', 'dusun', '#isi_popup_dusun_', '<?= $dusun_gis['id_desa'] ?>');
	<?php endif; ?>
	<?php if (!empty($rw_gis)) : ?>
		setPolygonContent(marker_rw, '<?= addslashes(json_encode($rw_gis)) ?>', '#8888dd', 'RW', 'rw', '#isi_popup_rw_', '<?= $rw_gis['id_desa'] ?>');
	<?php endif; ?>
	<?php if (!empty($rt_gis)) : ?>
		setPolygonContent(marker_rt, '<?= addslashes(json_encode($rt_gis)) ?>', '#008000', 'RT', 'rt', '#isi_popup_rt_', '<?= $rt_gis['id_desa'] ?>');
	<?php endif; ?>

	var baseLayers = getBaseLayers(map, zoom);

	$(window).on("load", function() {
		setTimeout(
		function() {
			var overlayDesa = overlayWilDesa(marker_desa);
			overlayDesa.addTo(map);
			<?php foreach ($getLeuitLokasi as $leuitLokasi) : ?>
				setPointLeuit(map, "<?= $leuitLokasi['nama'] ?>", "<?= $leuitLokasi['lat_lokasi'] ?>", "<?= $leuitLokasi['lng_lokasi'] ?>", "#isi_popup_leuit_<?= $leuitLokasi['id'] ?>", "<?= $leuitLokasi['id'] ?>");
			<?php endforeach; ?>
		}, 1000);

		var overlayLayers = overlayWilNew(marker_desa, marker_dusun, marker_rw, marker_rt);
		var mainlayer = L.control.groupedLayers(baseLayers, overlayLayers, {
			position: 'topleft',
			collapsed: true
		});

		mainlayer.addTo(map);
	});

	map.fitBounds(bounds);
	map.setZoom(9);
	var loadingAset = L.control({
		position: 'topleft',
	});
	loadingControl(loadingAset, map);

	<?php if (isset($userdata['nama'])) : ?>
		
	<?php endif; ?>

	toggleClear(map);

	var info = L.control({
		position: 'topright'
	});
	var legend = L.control({
		position: 'bottomright'
	});
	var lahanControl = L.control.groupedLayers();
	var lahanControlUkuran = L.control({
		position: 'topleft',
		collapsed: false,
	});
	var persilGroup = L.layerGroup().addTo(map);
	var markerGroup = L.layerGroup().addTo(map);

	var searchContainer = L.control({
		position: 'topleft',
		collapsed: true,
	});
	var searchControlGroup = L.control({
		position: 'topleft'
	});
	var searchControlGroup2 = L.control({
		position: 'topleft'
	});
	var searchControlGroup3 = L.control({
		position: 'topleft'
	});

	var sebaranControl = L.control.layers();
	var markerSarana = L.control.groupedLayers();

	$('#isi_popup').remove();
	$('#isi_popup_dusun').remove();
	$('#isi_popup_rw').remove();
	$('#isi_popup_rt').remove();

	$('#pilihDesa').select2({
		placeholder: 'Pilih Desa',
		language: 'id',
		width: '100%',
	});
	$('#pilihDesa').change(function () {
		var id = $(this).val();
		var getId = $(this).select2("val");
		if(getId !=0) {
			var latDesa = $(this).find(":selected").data("lat");
			var lngDesa = $(this).find(":selected").data("lng");
			var pathDesa = $(this).find(":selected").data("path");
			var toDesa = new L.LatLngBounds(
			new L.LatLng(latDesa, lngDesa),
			new L.LatLng(latDesa, lngDesa));
			if(pathDesa != '') {
				map.flyTo([latDesa, lngDesa], 14, {
					animate: true,
					duration: 3
				});
			}
			clearExlude(getId);
		} else {
			$('.leaflet-interactive.poly-desa, .leaflet-interactive.poly-wil').removeClass('fade-poly');
			map.flyTo([<?= $data_prov['lat'] . "," . $data_prov['lng'] ?>], 9, {
				animate: true,
				duration: 1.5
			});
		}
		$.ajax({
			type: 'POST',
			dataType: 'html',
			url: '/first/filterIdDesa?',
			data: 'filterIdDesa=' + getId,
			success: function (msg) {
				bersihkan();
				if(getId=0) {
					$('.leaflet-interactive.poly-desa, .leaflet-interactive.poly-wil').removeClass('fade-poly');
				}
			},
		});
		changeSesi(getId);
	});

	function changeSesi(val) {
		$('input#sesiDesa').val(val);
		$('.main-nav ul li a:not(.has-child)').attr('data-desaid', val);
	}
	
	$('[data-trigger="showWilayahAdministrasi"]').click(function(e) {
		clearControl();
		menuActive(e.currentTarget);
		triggerMenu(map);
		mainlayer.addTo(map);
	});

	$('[data-trigger="showMarkerAllSub"]').click(function(e) {
		clearControl();
		menuActive(e.currentTarget);

		var thisFilter = $(this).attr('data-filter');
		var thisType = $(this).attr('filter-kategori');
		var idJenis = $(this).attr('id-jenis');
		var desaId = $(this).attr('data-desaid');

		$.getJSON(config.apiLokasi+'/'+desaId, function(data) {
			var featureLok = setLayerCustomSaranaAll(data, '<?= base_url() . LOKASI_SIMBOL_LOKASI ?>', idJenis, thisFilter, thisType, map);
			var lokCheck = L.control.groupedLayers(baseLayers, featureLok, {
				position: 'topleft',
				collapsed: false,
				groupCheckboxes: true
			});
			markerSarana = lokCheck.addTo(map);
			map.removeControl(loadingAset);
			triggerMenu(map);
		});
		return markerSarana;
	});

	$('[data-trigger="showPersil"]').click(function(e) {
		clearControl();
		menuActive(e.currentTarget);
		$.getJSON(config.apiPersil, function(data) {
			var featureLayer = setLayerCustomPersil(data, map, '#FC4E2A').addTo(persilGroup);

			var searchControlAdd = mainlayer.getContainer();
			var searchContainerLayer = L.control({
				position: 'topleft',
			});
			searchContainerLayer.onAdd = function(map) {
				let searchDiv = L.DomUtil.create("div");
				$(searchDiv).addClass("leaflet-control-layers leaflet-control search-container");
				$(searchDiv).attr("id", "search-check-container");
				var selectForm = '<select id="selectSearchType" class="form-control form-control-sm" onchange="selectSearch()"><option value="1">Nomor SPPT</option><option value="2">Nama Pemilik</option><option value="3">NIB</option></select>';
				$(searchDiv).html('<div class="form-group"><label for="selectSearchType">Cari berdasarkan :</label>' + selectForm + '</div>');
				$(searchDiv).appendTo(searchControlAdd);
				L.DomEvent.disableClickPropagation(searchDiv);
				return searchDiv;
			};
			searchContainer = searchContainerLayer.addTo(map);

			var searchControl = new L.Control.Search({
				layer: featureLayer,
				propertyName: 'Nomor_SPPT',
				marker: false,
				zoom: 18,
				idUnique: 'searchSppt',
				container: 'search-check-container',
				textPlaceholder: 'ketik...',
				textErr: 'Data tidak ditemukan',
				moveToLocation: function(latlng, title, map) {
					map.setView(latlng, 18);
				}
			});

			searchControl.on('search:locationfound', function(e) {
				e.layer.setStyle({
					fillColor: configColor.hightlight,
				});
				if (e.layer._popup) {
					e.layer.openPopup();
				}
			}).on('search:collapsed', function(e) {
				featureLayer.eachLayer(function(layer) {
					featureLayer.resetStyle(layer);
				});
			});

			var searchControl2 = new L.Control.Search({
				layer: featureLayer,
				propertyName: 'Nama_Pemil',
				marker: false,
				zoom: 18,
				idUnique: 'searchNama',
				container: 'search-check-container',
				textPlaceholder: 'ketik...',
				textErr: 'Data tidak ditemukan',
				moveToLocation: function(latlng, title, map) {
					map.setView(latlng, 18);
				}
			});

			searchControl2.on('search:locationfound', function(e) {
				e.layer.setStyle({
					fillColor: configColor.hightlight,
				});
				if (e.layer._popup) {
					e.layer.openPopup();
				}
			}).on('search:collapsed', function(e) {
				featureLayer.eachLayer(function(layer) {
					featureLayer.resetStyle(layer);
				});
			});

			var searchControl3 = new L.Control.Search({
				layer: featureLayer,
				propertyName: 'NIB',
				marker: false,
				zoom: 18,
				idUnique: 'searchNib',
				container: 'search-check-container',
				textPlaceholder: 'ketik...',
				textErr: 'Data tidak ditemukan',
				moveToLocation: function(latlng, title, map) {
					map.setView(latlng, 18);
				}
			});

			searchControl3.on('search:locationfound', function(e) {
				e.layer.setStyle({
					fillColor: configColor.hightlight,
				});
				if (e.layer._popup) {
					e.layer.openPopup();
				}
			}).on('search:collapsed', function(e) {
				featureLayer.eachLayer(function(layer) {
					featureLayer.resetStyle(layer);
				});
			});

			searchControlGroup = searchControl.addTo(map);
			searchControlGroup2 = searchControl2.addTo(map);
			searchControlGroup3 = searchControl3.addTo(map);

			map.removeControl(loadingAset);
			triggerMenu(map);
		});
		persilGroup.addTo(map);
		return searchContainer, searchControlGroup, searchControlGroup2, searchControlGroup3;
	});

	$('[data-trigger="showTutupanLahan"]').click(function(e) {
		clearControl();
		menuActive(e.currentTarget);
		lahanControl.addTo(map);
		map.removeControl(loadingAset);
		triggerMenu(map);
		var lahanControlAdd = lahanControl.getContainer();
		lahanControlAdd.setAttribute("id", "lahan-check-container");
		var lahanControlUkuranLayer = L.control({
			position: 'topleft',
		});
		lahanControlUkuranLayer.onAdd = function(map) {
			let checkboxDiv = L.DomUtil.create("div");
			checkboxDiv.setAttribute("class", "leaflet-control-layers leaflet-control-layers-expanded leaflet-control lahan-check-container");
			checkboxDiv.innerHTML = '<label><input type="checkbox" value="1" checked="checked" onclick="checkUkuran()"><span>Tampilkan ukuran</span></label>';
			$(checkboxDiv).appendTo(lahanControlAdd);
			L.DomEvent.disableClickPropagation(checkboxDiv);
			return checkboxDiv;
		};
	});
	loadDataTutupanLahan();
	function loadDataTutupanLahan() {
		$.getJSON(config.apiLahan, function(data) {
			var featureLayer = setLayerCustomLahan(data, map);
			var lahanCheck = L.control.groupedLayers(baseLayers, featureLayer, {
				position: 'topleft',
				collapsed: false,
			});
			
			lahanControl = lahanCheck;
			return lahanControl, lahanControlUkuran;
		});
	}
	
	$('[data-trigger="showKependudukan"]').click(function(e) {
		clearControl();
		menuActive(e.currentTarget);
		var thisFilter = $(this).attr('data-filter');
		var idJenis = $(this).attr('data-key');
		var desaId = $(this).attr('data-desaid');

		$.ajax({
			url: config.apiStat + '/' + idJenis+'/'+desaId,
			dataType: 'json',
			success: function(data) {
				var featureLayer = setLayerSebaran(data, idJenis, thisFilter, map);
				var sebaranCheck = L.control.groupedLayers(baseLayers, featureLayer, {
					position: 'topleft',
					collapsed: false,
					exclusiveGroups: ['<b style="text-transform:uppercase;">' + thisFilter + '</b>'],
					groupCheckboxes: true
				});

				sebaranControl = sebaranCheck.addTo(map);
				map.removeControl(loadingAset);
				triggerMenu(map);
			},
		});
		return sebaranControl;
	});

	function loadDataSebaranPenduduk(idJenis,desaId) {
	}

	function leuitLokasi(lat, lng, nama, volume, kekeringan, alamat, foto) {
		clearControl();
		$('.list_kategori').find('li').removeClass('current-menu');
		$('#modalStruktur').modal('hide');
		map.panTo(new L.LatLng(lat, lng));
		var contentJabatan = '<div class="popup-aparatur">' +
			'<div class="popup-img"><img src="' + foto + '" class="align-self-start mr-3" /></div>' +
			'<div class="popup-caption">' +
			'<h5>' + nama + '</h5>' +
			'<div class="mt-1">' + alamat + '</div>' +
			'<hr>'+
			'<div class="mt-1 text-left">Volume: ' + volume + '</div>' +
			'<div class="mt-1 text-left">Tingkat Kekeringan: ' + kekeringan + '</div>' +
			'<div class="mt-1 text-left">Produksi: 0</div>' +
			'<div class="button mt-3"><a href="javascript:;" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modalLeuit">Liha Data</a></div>' +
			'</div>' +
			'</div>';
		var markerAparat = L.marker([lat, lng]).bindTooltip(nama, {
			sticky: true,
			direction: 'center',
			permanent: true,
		}).bindPopup(contentJabatan).addTo(markerGroup);
		map.removeControl(loadingAset);
		markerGroup.addTo(map);
		markerAparat.openPopup();
		triggerMenu(map);
	}

	toggleMenu(map);
	resizeWindow(map);

	function selectSearch() {
		$('.leaflet-control-search').hide();
		var thisVal = $('#selectSearchType').val();
		if (thisVal == 1) {
			$('.leaflet-control-search').hide();
			$('#searchSppt').show();
		} else if (thisVal == 2) {
			$('.leaflet-control-search').hide();
			$('#searchNama').show();
		} else if (thisVal == 3) {
			$('.leaflet-control-search').hide();
			$('#searchNib').show();
		} else {
			$('.leaflet-control-search').hide();
			map.invalidateSize();
			map.setZoom(16);
		}
	}

	function clearControl() {
		bersihkan();
		loadingAset.addTo(map);
	}

	function bersihkan() {
		$('.leaflet-interactive:not(.not-clear):not(.poly-desa), .leaflet-tooltip:not(.not-clear)').remove();
		markerGroup.clearLayers();

		var thisCheck = $('.leaflet-top.leaflet-left .leaflet-control-layers:not(.lahan-check-container) input[type="checkbox"]');
		$(thisCheck).each(function(index, value) {
			if ($(this).is(':checked')) {
				$(this).trigger('click');
				$(this).removeAttr('checked');
			}
		});

		$('.info-sebaran').remove();

		map.removeControl(lahanControl);
		map.removeControl(lahanControlUkuran);
		map.removeControl(sebaranControl);
		map.removeControl(markerSarana);
		map.removeControl(searchContainer);
		map.removeControl(searchControlGroup);
		map.removeControl(searchControlGroup2);
		map.removeControl(searchControlGroup3);
		map.removeLayer(persilGroup);
		map.closePopup();
		$('.list_kategori').find('li').removeClass('current-menu');
	}

	function clearExlude(id) {
		$('.leaflet-interactive:not(.not-clear):not(.poly-desa), .leaflet-tooltip:not(.not-clear)').remove();
		$('.leaflet-interactive.poly-desa, .leaflet-interactive.poly-wil').removeClass('fade-poly');
		$('.leaflet-interactive.poly-desa:not(.desa-'+id+')').addClass('fade-poly');
	}

	function menuActive(el) {
		$('.list_kategori').find('li').removeClass('current-menu');
		$(el).parent('li').addClass('current-menu');
	}

	$('document').ready(function() {
		checkSandi('<?= $_SESSION['user'] ?>');
		submitSetting('<?= $_SESSION['user'] ?>');
	});
	
	function filterFormDesa(idForm, action, target = '') {
		csrf_semua_form();
		if (target != '') {
			$('#' + idForm).attr('target', target);
		}
		$('#' + idForm).attr('action', action);
		$('#' + idForm).submit();
	}
</script>


<!-- konten popup -->

<div class="modal fade" id="modalKecil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class="modal-title" id="modalProfilLabel"><i class='fa fa-exclamation-triangle text-red'></i></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="fetched-data"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalSedang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
	<div class="modal-dialog modal-dialog-centered">
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class="modal-title" id="modalProfilLabel"><i class='fa fa-exclamation-triangle text-red'></i></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="fetched-data"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalBesar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class="modal-title" id="modalProfilLabel"><i class='fa fa-exclamation-triangle text-red'></i></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="fetched-data"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalLeuit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class="modal-title" id="modalProfilLabel"><i class='fa fa-exclamation-triangle text-red'></i></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="fetched-data"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalLeuit360" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class="modal-title" id="modalProfilLabel"><i class='fa fa-exclamation-triangle text-red'></i></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="fetched-data">
					<div class="loading py-5 px-5 text-center"><img src="<?php echo base_url() ?>assets/images/loader.gif" alt=""></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalFoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class="modal-title" id="modalProfilLabel"><i class='fa fa-exclamation-triangle text-red'></i></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="fetched-data"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalAparatur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class="modal-title" id="modalProfilLabel"><i class='fa fa-exclamation-triangle text-red'></i></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="fetched-data"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered">
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class="modal-title" id="modalProfilLabel">Silahkan Masuk</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!-- <script type="text/javascript">
				var csrfParam = '<?= $this->security->get_csrf_token_name() ?>';
				var getCsrfToken = () => document.cookie.match(new RegExp(csrfParam + '=(\\w+)'))[1]
			</script>
			<script defer src="<?= base_url() ?>assets/js/anti-csrf.js"></script> -->
			<form class="login-form" action="<?= site_url('siteman/auth') ?><?php if (isset($_REQUEST['app'])) { ?>?app=1<?php } ?>" method="post">
				<div class="modal-body">
					<div class="form-group">
						<label>Nama pengguna</label>
						<input type="text" name="username" value="" required class="form-username form-control form-control-sm input-error">
					</div>
					<div class="form-group">
						<label>Kata sandi</label>
						<div class="input-group">
							<input type="password" name="password" value="" required class="form-username form-control form-control-sm input-error">
							<div class="input-group-append">
								<a haref="javascript:;" class="btn show-pass">
									<i class="fa fa-eye"></i>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-sm btn-success">Masuk</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modalAkun" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
	<div class='modal-dialog modal-dialog-centered'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class="modal-title" id="modalStrukturLabel">Pengaturan Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php if (isset($userdata['nama'])) { ?>
				<form action="#" id="validasi" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="erm">
						</div>
						<div class="form-group">
							<label>Username</label>
							<input name="nama" type="hidden" value="<?= $userdata['username'] ?>" />
							<input type="text" value="<?= $userdata['username'] ?>" disabled="" class="form-control form-control-sm"></input>
						</div>
						<div class="form-group">
							<label for="namaLengkap">Nama Lengkap</label>
							<input type="text" name="nama" id="namaLengkap" value="<?= $userdata['nama'] ?>" class="form-control form-control-sm"></input>
						</div>
						<div class="password-container" style="display: none;">
							<hr>
							<div class="form-group">
								<label for="pass_baru">Kata Sandi Saat ini</label>
								<div class="input-group">
									<input type="password" name="pass_lama" id="pass_lama" placeholder="masukkan kata sandi saat ini" class="form-control form-control-sm"></input>
									<div class="input-group-append">
										<a href="javascript:;" class="btn btn-info check-sandi" style="display: none;">
											<i class="fa fa-chevron-right" aria-hidden="true"></i>
										</a>
										<a haref="javascript:;" class="btn btn-outline-secondary show-pass">
											<i class="fa fa-eye"></i>
										</a>
									</div>
								</div>
							</div>
							<div class="form-group input-sandi-baru" style="display: none;">
								<label for="pass_baru">Kata Sandi Baru</label>
								<div class="input-group">
									<input type="password" name="pass_baru" id="pass_baru" placeholder="masukan kata sandi baru" class="form-control form-control-sm pwdLengthNist_atau_kosong"></input>
									<div class="input-group-append">
										<a haref="javascript:;" class="btn btn-outline-secondary show-pass">
											<i class="fa fa-eye"></i>
										</a>
									</div>
								</div>
							</div>
							<div class="form-group input-sandi-baru" style="display: none;">
								<label for="pass_baru1">Kata Sandi Baru (Ulangi)</label>
								<div class="input-group">
									<input type="password" name="pass_baru1" id="pass_baru1" placeholder="masukan ulang kata sandi Baru" class="form-control form-control-sm"></input>
									<div class="input-group-append">
										<a haref="javascript:;" class="btn btn-outline-secondary show-pass">
											<i class="fa fa-eye"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
						<a href="javascript:;" class="toggle-ubah-sandi">Ubah sandi?</a>
					</div>

					<div class="modal-footer">
						<a href="<?= site_url('siteman/keluar') ?><?php if (isset($_REQUEST['app'])) { ?>?app=1<?php } ?>" class="btn btn-sm btn-danger btn-logout" title="Keluar">Logout</a>
						<a href="javascript:;" id="btnSubmit" class="btn btn-success btn-sm">Simpan</a>
					</div>
				</form>
			<?php } ?>
		</div>
	</div>
</div>
</body>

</html>