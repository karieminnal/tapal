<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<link type='text/css' href="<?= base_url() ?>assets/slick/slick.css" rel='Stylesheet' />
<script src="<?= base_url() ?>assets/slick/slick.min.js"></script>
<div class="slider-profil-lembaga">
	<?php foreach ($slider_gambar['gambar'] as $gambar) : ?>
		<?php if (is_file($slider_gambar['lokasi'] . 'sedang_' . $gambar['gambar'])) : ?>
			<div>
				<div class='slider-image'>
					<img src="<?php echo base_url() . $slider_gambar['lokasi'] . 'sedang_' . $gambar['gambar'] ?>">
				</div>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>