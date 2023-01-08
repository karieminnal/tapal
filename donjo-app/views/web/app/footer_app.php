
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

<script type="text/javascript">
	function showBatasWilayahButton() {
		var btnContainer = $('.button-batas');
		btnContainer.toggleClass('show');

		if ($('.button-data').hasClass('show')) {
			$('.button-data').removeClass('show');
			$('.control-custom.sebaranRadio').remove();
		}

		if ($('.button-data-sub').hasClass('show')) {
			$('.button-data-sub').removeClass('show');
		}
	}

	function showDataButton() {
		var btnContainer = $('.button-data');
		btnContainer.toggleClass('show');

		if ($('.button-batas').hasClass('show')) {
			$('.button-batas').removeClass('show');
		}
	}

	function showDataSubButton() {
		var btnContainer = $('.button-data-sub');
		btnContainer.toggleClass('show');

		if ($('.button-batas').hasClass('show')) {
			$('.button-batas').removeClass('show');
		}

		if ($('.button-data').hasClass('show')) {
			$('.button-data').removeClass('show');
			$('.control-custom.sebaranRadio').remove();
		}
	}

	function showPersilButton() {
		var btnContainer = $('.search-container');
		btnContainer.toggleClass('show');

		if ($('.button-batas').hasClass('show')) {
			$('.button-batas').removeClass('show');
		}
	}

	function clearControl() {
		bersihkan();
	}

	function bersihkan() {
		$('.leaflet-interactive:not(.not-clear):not(.poly-desa), .leaflet-tooltip:not(.not-clear)').remove();

		var thisCheck = $('.leaflet-top.leaflet-left .leaflet-control-layers input[type="checkbox"]');
		$(thisCheck).each(function(index, value) {
			if ($(this).is(':checked')) {
				$(this).trigger('click');
				$(this).removeAttr('checked');
			}
		});

		var batasCheck = $('.button-batas input[type="checkbox"]');
		$(batasCheck).each(function(index, value) {
			if ($(this).is(':checked')) {
				$(this).prop("checked", false);
			}
		});

		var dataCheck = $('.button-data input[type="checkbox"]');
		$(dataCheck).each(function(index, value) {
			if ($(this).is(':checked')) {
				$(this).prop("checked", false);
			}
		});

		var dataCheckSub = $('.button-data-sub input[type="checkbox"]');
		$(dataCheckSub).each(function(index, value) {
			if ($(this).is(':checked')) {
				$(this).prop("checked", false);
			}
		});

		bersihkanSub();

		map.closePopup();

		<?php if (!empty($data_config['path'])) : ?>
			var overlayDesa = overlayWilDesa(marker_desa);
			overlayDesa.addTo(map);
		<?php endif; ?>
	}

	function clearExlude(id) {
		$('.leaflet-interactive:not(.not-clear):not(.poly-desa), .leaflet-tooltip:not(.not-clear)').remove();
		$('.leaflet-interactive.poly-desa, .leaflet-interactive.poly-wil').removeClass('fade-poly');
		$('.leaflet-interactive.poly-desa:not(.desa-'+id+')').addClass('fade-poly');
		// $('.leaflet-interactive.poly-desa.desa-'+id).fadeIn('fast');
	}

	function bersihkanSub() {
		$('.button-data').removeClass('show');
		$('.control-custom.sebaranRadio').remove();

		var thisRadio = $('.leaflet-top.leaflet-left .leaflet-control-layers input[type="radio"]');
		$(thisRadio).each(function(index, value) {
			if ($(this).is(':checked')) {
				$(this).trigger('click');
				$(this).removeAttr('checked');
			}
		});

		$('.leaflet-control-layers.leaflet-control-layers-expanded').slice(1).remove();
	}
</script>