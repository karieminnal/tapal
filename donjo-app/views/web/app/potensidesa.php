<?php $this->load->view('web/app/header_app.php') ?>

<script type="text/javascript" src="<?= base_url() ?>assets/app/js/saranaprasarana.js"></script>

<?php $this->load->view('web/app/base_map.php') ?>

<script type="text/javascript">
	var markerSarana = L.control.groupedLayers();
	var thisFilter = "Aset Desa";
	var thisType = false;
	var idJenis = 44;

	$.getJSON(config.apiLokasi, function(data) {
		var featureLok = setLayerCustomSaranaAll(data, '<?= base_url() . LOKASI_SIMBOL_LOKASI ?>', idJenis, thisFilter, thisType, map);
		var lokCheck = L.control.groupedLayers(baseLayers, featureLok, {
			position: 'topleft',
			collapsed: false,
		});
		markerSarana = lokCheck.addTo(map);
	});
</script>

<?php $this->load->view('web/app/footer_app.php') ?>
</body>

</html>