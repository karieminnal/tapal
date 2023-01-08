<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>
		<?= $this->setting->admin_title . ' ' . ucwords($this->setting->sebutan_desa) . ' ' . $desa['nama_desa'] ?: '' . 'Layanan Mandiri';
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

	<link type='text/css' href="<?= base_url() ?>assets/front/css/first.css" rel='Stylesheet' />
	<!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/bootstrap/css/bootstrap.bar.css"> -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/front/css/artikel.css" />

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
	<!-- Jquery Confirm -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/front/css/jquery-confirm.min.css">

	<!-- Style Admin Modification Css -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/admin-style.css">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/header-mandiri.css" />

	<script type="text/javascript">
		const BASE_URL = "<?= base_url(); ?>";
		const SITE_URL = "<?= site_url(); ?>";
	</script>

	<script src="<?= base_url() ?>assets/bootstrap/js/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/front/js/artikel.js"></script>

	<style type="text/css">
	</style>
	<?php $this->load->view('head_tags_front') ?>
</head>

<body class="skin-blue layout-top-nav body-artikel">
	<div class="toggle-menu mobile">
		<div class="logo-desa">
			<a href="<?= site_url(); ?><?php if (isset($_REQUEST['app'])) { ?>?app=1<?php } ?>">
				<img src="<?= gambar_desa($desa['logo']); ?>" alt="<?= $desa['nama_desa'] ?>" />
			</a>
			<span class="nama-desa">
				Layanan Mandiri
				<!-- <?= ucwords($this->setting->sebutan_desa) ?> <?= $desa['nama_desa'] ?> -->
			</span>
		</div>
		<a href="javascript:;" class="btn btn-sm">
			<i class="fa fa-bars"></i>
		</a>
	</div>
	<div class="left-content">
		<div class="logo-menu">
			<?php if (isset($_REQUEST['app'])) { ?>
				<img src="<?= base_url() ?>assets/images/pintasia-logo-white.png" alt="pintasia">
			<?php } else { ?>
				<a href="https://pintasia.id/" target="_blank">
					<img src="<?= base_url() ?>assets/images/pintasia-logo-white.png" alt="pintasia">
				</a>
			<?php } ?>
		</div>
		<header class="header">
			<div class="header-logo">
				<a href="<?= site_url(); ?><?php if (isset($_REQUEST['app'])) { ?>?app=1<?php } ?>">
					<img src="<?= gambar_desa($desa['logo']); ?>" alt="<?= $desa['nama_desa'] ?>" />
				</a>
			</div>
			<div class="header-web-name">
				<h1>
					Layanan Mandiri<br>
					<!-- <span class="d-block d-md-none">GIS</span>
					<span class="d-none d-md-block d-lg-none"><?= ucwords($this->setting->sebutan_desa) ?> <?= $desa['nama_desa'] ?></span>
					<span class="d-none d-lg-block"><?= ucwords($this->setting->sebutan_desa) ?> <?= $desa['nama_desa'] ?></span> -->
					<span class=""><?= ucwords($this->setting->sebutan_desa) ?> <?= $desa['nama_desa'] ?></span>
				</h1>
			</div>
		</header>

		<div class="main-nav">
			<?php include('donjo-app/views/web/mandiri/layanan_mandiri.php'); ?>
		</div>
	</div>

	<main class="site-content" role="main">
		<section class="section">
			<?php
			if (isset($_SESSION['lg']) and $_SESSION['lg'] == 1) {
			?>
				<div style="padding: 15px 15px 0;">
					<div class="alert alert-warning" role="alert">
						Untuk keamanan, <a href='javascript:;' data-toggle="modal" data-target="#modalGantiPin"><b>klik disini</b></a> untuk mengubah kode PIN Anda.
					</div>
				</div>
			<?php } ?>
			<?php if (isset($_SESSION['lg']) and $_SESSION['lg'] == 1) { ?>

				<div class="modal fade" id="modalGantiPin" tabindex="-1" role="dialog" aria-labelledby="modalGantiPinLabel" aria-hidden="true" data-backdrop="false">
					<div class="modal-dialog modal-dialog-centered">
						<div class='modal-content'>
							<div class='modal-header'>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="modalGantiPinLabel">Ubah PIN</h4>
							</div>
							<form action="<?php echo site_url('mandiri_web/ganti') ?>" method="post">
								<div class="modal-body">
									<div class="row">
										<div class="form-group col-md-6">
											<label>PIN baru</label>
											<input name="pin1" type="text" value="" required class="form-control form-control-sm">
										</div>
										<div class="form-group col-md-6">
											<label>Ulangi PIN baru</label>
											<input name="pin2" type="text" value="" required class="form-control form-control-sm">
										</div>
									</div>
									<?php if ($flash_message) { ?>
										<div id="notification" class='box-header label-danger'><?php echo $flash_message ?></div>
										<script type="text/javascript">
											$('document').ready(function() {
												$('#notification').delay(4000).fadeOut();
											});
										</script>
									<?php } ?>
								</div>
								<div class="modal-footer">
									<button type="submit" id="but" class="btn btn-sm btn-primary">Ganti</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			<?php } else if (isset($_SESSION['lg']) and $_SESSION['lg'] == 2) { ?>

				<div class="modal fade" id="modalGantiPin" tabindex="-1" role="dialog" aria-labelledby="modalGantiPinLabel" aria-hidden="true" data-backdrop="false">
					<div class="modal-dialog modal-dialog-centered">
						<div class='modal-content'>
							<div class='modal-header'>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="modalGantiPinLabel">Ubah PIN</h4>
							</div>
							<div class="modal-body">
								PIN Baru berhasil Disimpan!
							</div>
						</div>
					</div>
				</div>
			<?php
				unset($_SESSION['lg']);
			}
			?>