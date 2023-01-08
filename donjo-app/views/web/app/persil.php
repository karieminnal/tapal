<?php $this->load->view('web/app/header_app.php') ?>

<script type="text/javascript" src="<?= base_url() ?>assets/app/js/persil.js"></script>

<?php $this->load->view('web/app/base_map.php') ?>

<script type="text/javascript">
	var persilGroup = L.layerGroup().addTo(map);

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


	$.getJSON(window.location.origin + '/api_mobile/getPersil', function(data) {
		var featureLayer = setLayerCustomPersil(data, map, '#FC4E2A').addTo(persilGroup);

		var searchControlAdd = mainlayer.getContainer();
		var searchContainerLayer = L.control({
			position: 'topleft',
		});
		searchContainerLayer.onAdd = function(map) {
			let searchDiv = L.DomUtil.create("div");
			$(searchDiv).addClass("leaflet-control-layers leaflet-control search-container");
			$(searchDiv).attr("id", "search-check-container");
			var selectForm = '<div class="select"><select id="selectSearchType" class="form-control form-control-sm" onchange="selectSearch()"><option value="1">Nomor SPPT</option><option value="2">Nama Pemilik</option><option value="3">NIB</option></select><div class="select__arrow"></div></div>';
			$(searchDiv).html('<div class="control-custom"><label>Cari berdasarkan</label>' + selectForm + '</div>');
			// searchDiv.innerHTML = '<label></label>';
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

	});

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
	persilGroup.addTo(map);
</script>

<?php $this->load->view('web/app/footer_app.php') ?>
</body>

</html>