<?php $this->load->view('web/app/header_app.php') ?>

<script type="text/javascript" src="<?= base_url() ?>assets/app/js/tutupanlahan.js"></script>

<?php $this->load->view('web/app/base_map.php') ?>

<script type="text/javascript">
	var lahanControl = L.control.groupedLayers();
	// var lahanControlUkuran = L.control({
	// 	position: 'topleft',
	// 	collapsed: false,
	// });

	$.getJSON(config.apiLahan, function(data) {
		var featureLayer = setLayerCustomLahan(data, map);
		var lahanCheck = L.control.groupedLayers(baseLayers, featureLayer, {
			position: 'topleft',
			collapsed: false,
		});

		lahanControl = lahanCheck.addTo(map);

		// var lahanControlAdd = lahanCheck.getContainer();
		// lahanControlAdd.setAttribute("id", "lahan-check-container");
		// var lahanControlUkuranLayer = L.control({
		// 	position: 'topleft',
		// });
		// lahanControlUkuranLayer.onAdd = function(map) {
		// 	let checkboxDiv = L.DomUtil.create("div");
		// 	checkboxDiv.setAttribute("class", "leaflet-control-layers leaflet-control-layers-expanded leaflet-control lahan-check-container");
		// 	checkboxDiv.innerHTML = '<label><input type="checkbox" value="1" checked="checked" onclick="checkUkuran()"><span>Tampilkan ukuran</span></label>';
		// 	$(checkboxDiv).appendTo(lahanControlAdd);
		// 	L.DomEvent.disableClickPropagation(checkboxDiv);
		// 	return checkboxDiv;
		// };
		// lahanControlUkuran = lahanControlUkuranLayer.addTo(map);
	});
</script>

<?php $this->load->view('web/app/footer_app.php') ?>
</body>

</html>