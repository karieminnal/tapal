<?php $this->load->view('web/app/header_app_sebaran.php') ?>

<script type="text/javascript" src="<?= base_url() ?>assets/app/js/sebaran.js"></script>

<?php $this->load->view('web/app/base_map.php') ?>

<script type="text/javascript">
	var info = L.control({
		position: 'topright'
	});
	var legend = L.control({
		position: 'bottomright'
	});
	$('[data-trigger="showKependudukan"]').click(function(e) {
		$('.button-data-sub').addClass('loading');
		var sebaranControl = L.control.layers();
		var thisFilter = $(this).attr('data-filter');
		var idJenis = $(this).attr('data-key');
		var desaId = 0;

		$.ajax({
			// async: false,
			url: config.apiStat + '/' + idJenis+'/'+desaId+'?logApp=true',
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
				$('.button-data-sub').removeClass('loading');
			},
		});
	});
</script>

<?php $this->load->view('web/app/footer_app.php') ?>
</body>

</html>