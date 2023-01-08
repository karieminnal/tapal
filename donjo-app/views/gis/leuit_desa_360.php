<?php if($leuitLokasi) { ?>
	<?php foreach ($leuitLokasi as $leuit) { ?>
		<div class="image-360">
			<div id="viewer360"></div>
		</div>
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/sphere-viewer.css" />
		<script src="<?php echo base_url() ?>assets/js/three.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/browser.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/photo-sphere-viewer.min.js"></script>
		<script>
			setTimeout(
				function() {
				new PhotoSphereViewer.Viewer({
					container: document.querySelector('#viewer360'),
					panorama: "<?php echo base_url().LOKASI_FOTO_LOKASI.''.$leuit['panorama'] ?>",
					size: {
						width: '800px',
						height: '400px',
					},
					// maxFov: 20,
					// defaultZoomLvl: 0
				});
			}, 1000);
		</script>
	<?php } ?>
<?php } else { ?>
	<p class="my-5 text-center">Belum ada data</p>
<?php } ?>