<?php

/**
 * HEADER APP:
 *
 */
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>
		<?=
			$this->setting->website_title
				. ' ' .get_dynamic_title_page_from_path();
		?>
	</title>
	<meta content="utf-8" http-equiv="encoding">
	<meta name="keywords" content="<?= $this->setting->website_title ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta property="og:site_name" content="<?= $this->setting->website_title; ?> - Pintasia" />
	<meta property="og:type" content="article" />
	<meta name="description" content="Website <?= $this->setting->website_title; ?> - Pintasia" />

	<link rel="apple-touch-icon" sizes="57x57" href="<?= base_url() ?>assets/images/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>assets/images/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() ?>assets/images/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/images/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() ?>assets/images/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/images/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= base_url() ?>assets/images/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/images/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/images/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?= base_url() ?>assets/images/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/images/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() ?>assets/images/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/images/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?= base_url() ?>assets/images/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#41577c">
	<meta name="msapplication-TileImage" content="<?= base_url() ?>assets/images/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#41577c">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap">
	<link rel="stylesheet" href="<?= base_url() ?>assets/js/select2/css/select2.min.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/main.min.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/app/css/app.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/additional.css" />

	<script type="text/javascript">
		var BASE_URL = "<?= base_url() ?>";
	</script>

	<script type="text/javascript" src="<?= base_url() ?>assets/front/js/jquery.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/front/js/main.id.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/js/vendors.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/js/select2/js/select2.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/js/select2/js/i18n/id.js"></script> 
	<script type="text/javascript" src="<?= base_url() ?>assets/js/config.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/app/js/peta-mobile.js"></script>
</head>

<body class="from-app">
	<div class="loader"></div>
	<main class="site-content" role="main">
		<section class="section section-map">

			<div class="button-batas">
				<div class="control-custom">
					<label class="control control--checkbox">
						<input type="checkbox" />
						<span>Dusun</span>
						<div class="control__indicator"></div>
					</label>
				</div>
				<div class="control-custom">
					<label class="control control--checkbox">
						<input type="checkbox" />
						<span>RW</span>
						<div class="control__indicator"></div>
					</label>
				</div>
				<div class="control-custom">
					<label class="control control--checkbox">
						<input type="checkbox" />
						<span>RT</span>
						<div class="control__indicator"></div>
					</label>
				</div>
			</div>

			<div class="button-data">
			</div>

			<div id="map"></div>
			<!-- content popup -->
			<?php foreach ($desaall as $listdesa) { ?>
				<div id="isi_popup_<?php echo $listdesa['id'] ?>" style="visibility: hidden;" class="isi-popup">
					<?php $this->load->view("gis/content_desa_web.php", array('desa' => $listdesa, 'list_lap_front' => $list_lap_front, 'wilayah' => ucwords($this->setting->sebutan_desa . ' ' . $listdesa['nama_desa']))) ?>
				</div>
			<?php } ?>
			<?php foreach ($getLeuitLokasi as $leuit) { ?>
				<div id="isi_popup_leuit_<?php echo $leuit['id'] ?>" style="visibility: hidden;" class="isi-popup">
					<?php $this->load->view("gis/content_leuit_web.php", array('leuit' => $leuit, 'wilayah' => ucwords($leuit['nama']), 'desa' => ucwords($leuit['id_desa']))) ?>
				</div>
			<?php } ?>
			<?php $this->load->view("web/app/content-popup/rw.php", array('rw_gis' => $rw_gis, 'list_lap' => $list_lap, 'wilayah' => ucwords($this->setting->sebutan_dusun . ' '))) ?>
			<?php $this->load->view("web/app/content-popup/rt.php", array('rt_gis' => $rt_gis, 'list_lap' => $list_lap, 'wilayah' => ucwords($this->setting->sebutan_dusun . ' '))) ?>
		</section>
	</main>