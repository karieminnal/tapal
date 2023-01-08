<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>
		<?= $this->setting->login_title
			. ' ' . ucwords($this->setting->sebutan_desa)
			. (($header['nama_desa']) ? ' ' . $header['nama_desa'] : '')
			. get_dynamic_title_page_from_path();
		?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
	<meta name="robots" content="noindex">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap">
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/login-style.css" media="screen" type="text/css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/login-form-elements.css" media="screen" type="text/css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap.bar.css" media="screen" type="text/css" />
	<?php if (is_file("desa/css/siteman.css")) : ?>
		<link type='text/css' href="<?= base_url() ?>desa/css/siteman.css" rel='Stylesheet' />
	<?php endif; ?>

	<script src="<?= base_url() ?>assets/bootstrap/js/jquery.min.js"></script>

	<?php $this->load->view('head_tags_front') ?>
</head>

<body class="login">

	<div class="top-content">
		<div class="inner-bg">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="form-box">
							<div class="logo-pintasia">
								<a href="<?= site_url(); ?>" target="_blank">
									<img src="<?= base_url() ?>assets/images/logo-tapaldesa-hori-white.png" alt="<?= $header['nama_desa'] ?>">
								</a>
							</div>
							<div class="form-top">
								<div class="logo-desa">
									<a href="<?= site_url(); ?>/">
										<img src="<?= gambar_desa($header['logo']); ?>" alt="<?= $header['nama_desa'] ?>" class="img-responsive" />
									</a>
								</div>
								<div class="login-footer-top">
									<h1>
										Layanan Mandiri<br>
										<?= ucwords($this->setting->sebutan_desa) ?>
										<?= $header['nama_desa'] ?>
									</h1>
								</div>
							</div>
							<div class="form-bottom">

								<!-- widget Layanan Mandiri -->
								<?php
								if (!isset($_SESSION['mandiri']) or $_SESSION['mandiri'] <> 1) {

									if ($_SESSION['mandiri_wait'] == 1) {
								?>
										<div class="box box-primary box-solid">
											<div class="box-header">
												<!-- <h3 class="box-title"><i class="fa fa-user"></i> Layanan Mandiri</h3><br /> -->
												Silakan datang/hubungi operator <?php echo $this->setting->sebutan_desa ?> untuk mendapatkan PIN anda.
											</div>
											<div class="box-body">
												<h4>Gagal 3 kali, silakan coba kembali dalam <?php echo waktu_ind((time() - $_SESSION['mandiri_timeout']) * (-1)); ?> detik lagi</h4>
												<div id="note">
													Login Gagal. NIK atau PIN yang anda masukkan salah!
												</div>
											</div>
										</div>
									<?php } else { ?>
										<div class="box box-primary box-solid">
											<div class="box-header">
												<!-- <h3 class="box-title"><i class="fa fa-user"></i> Layanan Mandiri</h3><br /> -->
												<p>Silakan datang/hubungi operator <?php echo $this->setting->sebutan_desa ?> untuk mendapatkan PIN anda.</p>
											</div>
											<div class="box-body">
												<!-- <h4>Masukan NIK dan PIN</h4> -->
												<form action="<?php echo site_url('mandiri_web/auth') ?>" method="post">
													<div class="form-group">
														<!-- <label>NIK</label> -->
														<input name="nik" type="text" placeholder="masukkan NIK Anda" value="" required class="form-control form-control-sm">
													</div>
													<div class="form-group">
														<!-- <label>PIN</label> -->
														<input name="pin" type="password" placeholder="masukkan PIN Anda" value="" required class="form-control form-control-sm">
													</div>
													<button type="submit" id="but" class="btn btn-success btn-sm">Masuk</button>
													<?php if ($_SESSION['mandiri_try'] and isset($_SESSION['mandiri']) and $_SESSION['mandiri'] == -1) { ?>
														<div id="note">
															Kesempatan mencoba <?php echo ($_SESSION['mandiri_try'] - 1); ?> kali lagi.
														</div>
													<?php } ?>
													<?php if (isset($_SESSION['mandiri']) and $_SESSION['mandiri'] == -1) { ?>
														<div id="note">
															Login Gagal. NIK atau PIN yang Anda masukkan salah!
														</div>
													<?php } ?>
												</form>
											</div>
										</div>
									<?php }
								} else {
									?>
									<div class="box box-primary box-solid">
										<!-- <div class="box-header">
			<h3 class="box-title"><i class="fa fa-user"></i> Layanan Mandiri</h3>
		</div> -->
										<div class="box-body">
											<ul id="ul-mandiri">
												<table id="mandiri" width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="25%">Nama</td>
														<td width="2%" class="titik">:</td>
														<td width="73%"><?php echo $_SESSION['nama']; ?></td>
													</tr>
													<tr>
														<td bgcolor="#eee">NIK</td>
														<td class="titik" bgcolor="#eee">:</td>
														<td bgcolor="#eee"><?php echo $_SESSION['nik']; ?></td>
													</tr>
													<tr>
														<td>No KK</td>
														<td class="titik">:</td>
														<td><?php echo $_SESSION['no_kk'] ?></td>
													</tr>
													<tr>
														<td colspan="3">
															<h4><a href="<?php echo site_url(); ?>first/mandiri/1/1" class=""><button type="button" class="btn btn-primary btn-block">PROFIL</button></a> </h4>
														</td>
													</tr>
													<tr>
														<td colspan="3">
															<h4><a href="<?php echo site_url(); ?>first/mandiri/1/2" class=""><button type="button" class="btn btn-primary btn-block">LAYANAN</button></a> </h4>
														</td>
													</tr>
													<tr>
														<td colspan="3">
															<h4><a href="<?php echo site_url(); ?>first/mandiri/1/3" class=""><button type="button" class="btn btn-primary btn-block">LAPOR</button></a> </h4>
														</td>
													</tr>
													<tr>
														<td colspan="3">
															<h4><a href="<?php echo site_url(); ?>first/mandiri/1/4" class=""><button type="button" class="btn btn-primary btn-block">BANTUAN</button></a></h4>
														</td>
													</tr>
													<tr>
														<td colspan="3">
															<h4><a href="<?php echo site_url(); ?>mandiri_web/logout" class=""><button type="button" class="btn btn-danger btn-block">KELUAR</button></a></h4>
														</td>
													</tr>
												</table>
										</div>
									</div>
									<?php
									if (isset($_SESSION['lg']) and $_SESSION['lg'] == 1) {
									?>
										<div class="box box-primary box-solid">
											<div class="box-header">
												<!-- <h3 class="box-title"><i class="fa fa-user"></i> Layanan Mandiri</h3><br /> -->
												Untuk keamanan silahkan ubah kode PIN Anda.
											</div>
											<div class="box-body">
												<h4>Masukkan PIN Baru</h4>
												<form action="<?php echo site_url('first/ganti') ?>" method="post">
													<input name="pin1" type="password" placeholder="PIN" value="" style="margin-left:0px">
													<input name="pin2" type="password" placeholder="Ulangi PIN" value="" style="margin-left:0px">
													<button type="submit" id="but" style="margin-left:0px">Ganti</button>
												</form>
												<?php if ($flash_message) { ?>
													<div id="notification" class='box-header label-danger'><?php echo $flash_message ?></div>
													<script type="text/javascript">
														$('document').ready(function() {
															$('#notification').delay(4000).fadeOut();
														});
													</script>
												<?php } ?>

												<div id="note">
													Silahkan coba login kembali setelah PIN baru disimpan.
												</div>
											</div>
										</div>
									<?php } else if (isset($_SESSION['lg']) and $_SESSION['lg'] == 2) { ?>


										<div class="box box-primary box-solid">
											<div class="box-header">
												<!-- <h3 class="box-title"><i class="fa fa-user"></i> Layanan Mandiri</h3><br /> -->
												Untuk keamanan silahkan ubah kode PIN Anda.
											</div>
											<div class="box-body">
												<div id="note">
													PIN Baru berhasil Disimpan!
												</div>
											</div>
										</div>

								<?php
										unset($_SESSION['lg']);
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="copyright">
					<a href="<?= base_url() ?>" target="_blank">Tapal Desa</a> &copy; <?php echo date("Y"); ?>. Allright reserved.
				</div>
			</div>
		</div>
	</div>
</body>

</html>
<script src="<?= base_url() ?>assets/bootstrap/js/jquery.min.js"></script>
<script>
	$('document').ready(function() {});
</script>