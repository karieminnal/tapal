<link type='text/css' href="<?= base_url() ?>assets/slick/slick.css" rel='Stylesheet' />
<script src="<?= base_url() ?>assets/slick/slick.min.js"></script>
<script>
	var sliderElement = $('.slider-aparatur');
	$(sliderElement).not('.slick-initialized').slick({
		dots: false,
		arrows: true,
		autoplay: true,
		fade: true,
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		// adaptiveHeight: true
	});
</script>
<!-- widget Aparatur Desa -->
<div class="modal-body" id="maincontent">
	<div class="slider-aparatur">

		<?php foreach ($aparatur_desa['daftar_perangkat'] as $data) : ?>
			<div>
				<div class='slider-image'>
					<img src="<?= $data['foto'] ?>" title="<?= $data['nama'] ?> - <?= $data['jabatan'] ?>">
				</div>
				<div class='slider-caption'>
					<h5><?= $data['nama'] ?></h5>
					<span class="jabatan"><?= $data['jabatan'] ?></span>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<!-- <div class="box box-info box-solid">

		<div class="box-body">
			<div id="aparatur_desa" class="cycle-slideshow" data-cycle-pause-on-hover=true data-cycle-fx=scrollHorz data-cycle-timeout=2000 data-cycle-caption-plugin=caption2 data-cycle-overlay-fx-out="slideUp" data-cycle-overlay-fx-in="slideDown" data-cycle-auto-height=<?= $aparatur_desa['foto_pertama'] ?>>

				<?php if ($this->web_widget_model->get_setting('aparatur_desa', 'overlay') == true) : ?>
					<span class="cycle-prev"><img src="<?= base_url() ?>assets/images/back_button.png" alt="Back"></span>
					<span class="cycle-next"><img src="<?= base_url() ?>assets/images/next_button.png" alt="Next"></span>
					<div class="cycle-caption"></div>
					<div class="cycle-overlay"></div>
				<?php else : ?>
					<span class="cycle-pager"></span>
				<?php endif; ?>

				<?php foreach ($aparatur_desa['daftar_perangkat'] as $data) : ?>
					<img src="<?= $data['foto'] ?>" data-cycle-title="<span class='cycle-overlay-title'><?= $data['nama'] ?></span>" data-cycle-desc="<?= $data['jabatan'] ?>">
				<?php endforeach; ?>
			</div>
		</div>
	</div> -->
</div>