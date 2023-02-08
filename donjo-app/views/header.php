<?php

/**
 * File ini:
 *
 *
 * /donjo-app/views/header.php
 *
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>
		<?= $this->setting->admin_title
			. ' ' . (($desa['nama_desa']) ? ' ' . sentence_case($desa['nama_desa']) :  '')
			. get_dynamic_title_page_from_path();
		?>
	</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

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
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?= base_url() ?>rss.xml" />

	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css">
	<!-- Jquery UI -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/jquery-ui.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/dataTables.bootstrap.min.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap3-wysihtml5.min.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/select2.min.css">
	<!-- Bootstrap Color Picker -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap-colorpicker.min.css">
	<!-- Bootstrap Date time Picker -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap-datetimepicker.min.css">
	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap-datepicker.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/skins/_all-skins.min.css">
	<!-- Style Admin Modification Css -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/admin-style.css">
	<!-- OpenStreetMap Css -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/leaflet.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/leaflet-geoman.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/L.Control.Locate.min.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/MarkerCluster.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/MarkerCluster.Default.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/leaflet-measure-path.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/mapbox-gl.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/L.Control.Shapefile.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/leaflet.groupedlayercontrol.min.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/peta.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap">

	<!-- Untuk ubahan style desa -->
	<?php if (is_file("desa/css/siteman.css")) : ?>
		<link type='text/css' href="<?= base_url() ?>desa/css/siteman.css" rel='Stylesheet' />
	<?php endif; ?>

	<!-- Diperlukan untuk global automatic base_url oleh external js file -->
	<script type="text/javascript">
		var BASE_URL = "<?= base_url(); ?>";
		var SITE_URL = "<?= site_url(); ?>";
	</script>
	<!-- Diperlukan untuk script jquery khusus halaman -->
	<script src="<?= base_url() ?>assets/bootstrap/js/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/config.js"></script>

	<!-- OpenStreetMap Js-->
	<script src="<?= base_url() ?>assets/js/leaflet.js"></script>
	<script src="<?= base_url() ?>assets/js/turf.min.js"></script>
	<script src="<?= base_url() ?>assets/js/leaflet-geoman.min.js"></script>
	<script src="<?= base_url() ?>assets/js/leaflet.filelayer.js"></script>
	<script src="<?= base_url() ?>assets/js/togeojson.js"></script>
	<script src="<?= base_url() ?>assets/js/togpx.js"></script>
	<script src="<?= base_url() ?>assets/js/leaflet-providers.js"></script>
	<script src="<?= base_url() ?>assets/js/L.Control.Locate.min.js"></script>
	<script src="<?= base_url() ?>assets/js/leaflet.markercluster.js"></script>
	<script src="<?= base_url() ?>assets/js/peta.js"></script>
	<script src="<?= base_url() ?>assets/js/leaflet-measure-path.js"></script>
	<script src="<?= base_url() ?>assets/js/apbdes_manual.js"></script>
	<script src="<?= base_url() ?>assets/js/mapbox-gl.js"></script>
	<script src="<?= base_url() ?>assets/js/leaflet-mapbox-gl.js"></script>
	<script src="<?= base_url() ?>assets/js/shp.js"></script>
	<script src="<?= base_url() ?>assets/js/leaflet.shpfile.js"></script>
	<script src="<?= base_url() ?>assets/js/leaflet.groupedlayercontrol.min.js"></script>

	<!-- Highcharts JS -->
	<script src="<?= base_url() ?>assets/js/highcharts/highcharts.js"></script>
	<script src="<?= base_url() ?>assets/js/highcharts/highcharts-3d.js"></script>
	<script src="<?= base_url() ?>assets/js/highcharts/exporting.js"></script>
	<script src="<?= base_url() ?>assets/js/highcharts/highcharts-more.js"></script>
	<?php require __DIR__ . '/head_tags.php' ?>
</head>

<body class="<?= $this->setting->warna_tema_admin; ?> sidebar-mini fixed <?php /*if ($minsidebar==1): ?>sidebar-collapse<?php endif */ ?>">
	<div class="wrapper">
		<header class="main-header">
			<a href="<?= site_url() ?>" target="_blank" class="logo">
				<span class="logo-mini">
					<!-- <img src="<?= base_url() ?>assets/images/favicon/favicon-96x96.png" alt="Tapal Desa"> -->
					TD
				</span>
				<span class="logo-lg">
					<img src="<?= base_url() ?>assets/images/logo-tapaldesa-hori-white.png" alt="Tapal Desa">
				</span>
			</a>
			<nav class="navbar navbar-static-top">
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<div class="navbar-custom-menu">
					<form id="formFilterDesa" name="formFilterDesa" action="" method="post">
						<ul class="nav navbar-nav">
							<?php if($_SESSION['grup'] == 1) { ?>
								<li>
									<select name="filterDesa" class="pilihDesaHeader" onchange="formAction('formFilterDesa', '<?= site_url('/hom_sid/filterDesa') ?>')">
										<?php foreach ($listkab as $kablist) { ?>
											<optgroup label="<?php echo $kablist['nama_kabupaten'] ?>">
											<?php 
												$desaArray = $this->config_model->get_desa_by_kab($kablist['kode_kabupaten']);
												foreach ($desaArray as $desa) { 
													$kab = $desa['nama_kabupaten'];
													$newKab = str_replace("KABUPATEN","KAB. ",$kab);
												?>
												<option value="<?php echo $desa['id'] ?>" <?php if ($_SESSION['filterDesa'] == $desa['id']) : ?>selected<?php endif ?>>&#x2192; <?php echo $desa['nama_desa'] ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</li>
								<li>
									<a href="<?= site_url('identitas_desa/tambahDesa'); ?>" class="btn btn-success btn-sm" title="Tambah Desa">
										Tambah <?= $sebutandesa; ?>
									</a>
								</li>
							<?php } ?>
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<?php if ($foto) : ?>
										<img src="<?= AmbilFoto($foto) ?>" class="user-image" alt="User Image" />
									<?php else : ?>
										<img src="<?= base_url() ?>assets/files/user_pict/kuser.png" class="user-image" alt="User Image" />
									<?php endif; ?>
									<span class="hidden-xs"><?= $nama ?> </span>
								</a>
								<ul class="dropdown-menu">
									<li class="user-header">
										<?php if ($foto) : ?>
											<img src="<?= AmbilFoto($foto) ?>" class="img-circle" alt="User Image" />
										<?php else : ?>
											<img src="<?= base_url() ?>assets/files/user_pict/kuser.png" class="img-circle" alt="User Image" />
										<?php endif; ?>
										<p>Anda Login Sebagai<br><strong><?= $nama ?></strong></p>
									</li>
									<li class="user-footer">
										<div class="pull-left">
											<a href="<?= site_url() ?>user_setting/" data-remote="false" data-toggle="modal" data-tittle="Pengaturan Pengguna" data-target="#modalBox">
												<button data-toggle="modal" class="btn btn-primary btn-flat btn-sm">Profil</button>
											</a>
										</div>
										<div class="pull-right">
											<a href="<?= site_url() ?>siteman" class="btn btn-danger btn-flat btn-sm">Keluar</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</form>
				</div>
			</nav>
		</header>
		<input id="success-code" type="hidden" value="<?= $_SESSION['success'] ?>">
		<!-- Untuk menampilkan modal bootstrap umum  -->
		<div class="modal fade" id="modalBox" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
						<h4 class='modal-title' id='myModalLabel'> Pengaturan Pengguna</h4>
					</div>
					<div class="fetched-data"></div>
				</div>
			</div>
		</div>
		<!-- Untuk menampilkan dialog pengumuman  -->
		<?= $this->pengumuman; ?>