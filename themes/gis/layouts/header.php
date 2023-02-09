<?php

/**
 * @package Pintasia
 * @author  Tim Pengembang Pintasia
 * @link  https://pintasia.id
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="id">

<head>
	<title>
		<?= $this->setting->website_title;
		?>
	</title>
	<meta content="utf-8" http-equiv="Content-Type">
	<meta name="keywords" content="<?= $this->setting->website_title; ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta property="og:site_name" content="<?= $this->setting->website_title; ?>" />
	<meta property="og:type" content="article" />
	<meta name="description" content="Website <?= $this->setting->website_title; ?>" />

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
	<meta name="msapplication-TileColor" content="#66aa05">
	<meta name="msapplication-TileImage" content="<?= base_url() ?>assets/images/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#66aa05">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap">
	<link rel="stylesheet" href="<?= base_url() ?>assets/js/select2/css/select2.min.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/main.min.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/additional.css" />

	<script type="text/javascript">
		var BASE_URL = "<?= base_url() ?>";
	</script>
	
	<?php if ($this->config->config['csrf_protection']) : ?>
	<script type="text/javascript">
		var csrfParam = '<?= $this->security->get_csrf_token_name() ?>';
		var getCsrfToken = () => document.cookie.match(new RegExp(csrfParam + '=(\\w+)'))[1]
	</script>
	<script defer src="<?= base_url() ?>assets/js/anti-csrf.js"></script>
<?php endif ?>
</head>

<body <?php if (isset($_REQUEST['app'])) { ?> class="from-app" <?php } ?>>
	<div class="loaderAll">
		<div class="loader-content">
			<p>Loading Tutupan Lahan, mohon tunggu!</p>
		</div>
	</div>
	<div class="toggle-menu mobile">
		<a href="javascript:;" class="btn btn-sm">
			<i class="fa fa-bars"></i>
		</a>
	</div>
	<div class="left-content">
		<div class="toggle-menu">
			<a href="javascript:;" class="btn btn-sm">
				<i class="fa fa-bars"></i>
			</a>
		</div>
		<div class="logo-menu">
			<?php if (isset($_REQUEST['app'])) { ?>
				<img src="<?= base_url() ?>assets/images/logo-tapaldesa.png" alt="<?= $this->setting->website_title; ?>">
			<?php } else { ?>
				<a href="javascript:;" target="_blank">
					<img src="<?= base_url() ?>assets/images/logo-tapaldesa.png" alt="<?= $this->setting->website_title; ?>">
				</a>
			<?php } ?>
		</div>
		<header class="header">
			<div class="user-login">
				<?php if (isset($userdata['nama'])) { ?>
					<a href="javascript:;" class="btn btn-sm btn-block btn-outline-primary" data-remote="false" data-toggle="modal" data-target="#modalAkun">
						<span class="">Akun</span>
					</a>
					<?php if (empty($_REQUEST['app'])) { ?>
						<a href="<?= base_url() ?>hom_sid" class="btn btn-sm btn-block btn-outline-primary" target="_blank">
							<span class="">Dashboard</span>
						</a>
					<?php } ?>
				<?php } else { ?>
					<a href='javascript:;' class='btn btn-sm btn-block btn-outline-primary' data-toggle="modal" data-target="#modalLogin">Login</a>
				<?php } ?>
			</div>
			<div class="form-group row row-kota mt-4 mb-3 show">
				<!-- <label class="control-label col-sm-12" >Zoom Wilayah</label> -->
				<div class="col-sm-12">          
					<select class="form-control" name="kota" id="pilihDesa">
						<option value="0">Pilih Desa</option>
						<?php foreach ($listkab as $kablist) { ?>
							<optgroup label="<?php echo $kablist['nama_kabupaten'] ?>">
								<?php
									$desaArray = $this->config_model->get_desa_by_kab($kablist['kode_kabupaten']);
									foreach ($desaArray as $desa) { 
									$dataPath = $desa['path'];
									$kab = $desa['nama_kabupaten'];
									$newKab = str_replace("KABUPATEN","KAB. ",$kab);
									if($dataPath != NULL) {
										$getPath = 1;
									} else {
										$getPath = 0;
									}
									?>
									<option value="<?php echo $desa['id'] ?>" <?php echo ($getPath ? '' : 'disabled'); ?> data-path="<?php echo $getPath ?>" data-lat="<?php echo $desa['lat'] ?>" data-lng="<?php echo $desa['lng'] ?>">&#x2192; <?php echo $desa['nama_desa'] ?></option>
								<?php } ?>
							</optgroup>
						<?php } ?>
					</select>
					<img src="<?= base_url() ?>assets/images/loader.gif" id="load2" style="display:none;" />
				</div>
			</div>
		</header>
		<?php $this->load->view($folder_themes . '/partials/menu-gis.php'); ?>
	</div>

	<main class="site-content" role="main">
		<section class="section section-map">