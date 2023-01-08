<script>
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

	var overlayDesa = overlayWilDesa(marker_desa);
	overlayDesa.addTo(map);
	<?php foreach ($getLeuitLokasi as $leuitLokasi) : ?>
		setPointLeuit(map, "<?= $leuitLokasi['nama'] ?>", "<?= $leuitLokasi['lat'] ?>", "<?= $leuitLokasi['lng'] ?>", "#isi_popup_leuit_<?= $leuitLokasi['id'] ?>", "<?= $leuitLokasi['id'] ?>");
	<?php endforeach; ?>

	var overlayLayers = overlayWilNew(marker_desa, marker_dusun, marker_rw, marker_rt);
	var mainlayer = L.control.groupedLayers(baseLayers, overlayLayers, {
		position: 'topleft',
		collapsed: true
	});

	mainlayer.addTo(map);

	map.fitBounds(bounds);
	map.setZoom(9);

	toggleClear(map);

	$('#isi_popup').remove();
	$('#isi_popup_dusun').remove();
	$('#isi_popup_rw').remove();
	$('#isi_popup_rt').remove();
</script>