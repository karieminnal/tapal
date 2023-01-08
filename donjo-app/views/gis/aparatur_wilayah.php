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
<!-- widget Aparatur Dusun/rw/rt -->
<div class="modal-body" id="maincontent">

	<div class="slider-aparatur">
		<div>
			<div class='slider-image'>
				<?php if ($penduduk['foto']) : ?>
					<img src="<?= AmbilFoto($penduduk['foto']) ?>" title="<?= $penduduk['nama'] ?> - <?= $jabatan ?>">
				<?php else : ?>
					<img src="<?= base_url("assets/files/user_pict/kuser.png") ?>" title="<?= $penduduk['nama'] ?> - <?= $jabatan ?>">
				<?php endif; ?>
			</div>
			<div class='slider-caption'>
				<h5><?= $penduduk['nama'] ?></h5>
				<span class="jabatan"><?= $jabatan ?></span>
			</div>
		</div>
	</div>
</div>