<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>
		<?= $this->setting->login_title. ' ' . get_dynamic_title_page_from_path();
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
	<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/main.min.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/additional.css" /> -->

	<script src="<?= base_url() ?>assets/bootstrap/js/jquery.min.js"></script>
	<?php require __DIR__ . '/head_tags.php' ?>
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
									<img src="<?= base_url() ?>assets/images/logo-tapaldesa.png" alt="">
								</a>
							</div>
							
							<div class="form-bottom">
								<form class="login-form" action="<?= site_url('siteman/auth') ?>" method="post">
									<p>Silahkan masukkan detail akun Anda</p>
									<?php if ($_SESSION['siteman_wait'] == 1) : ?>
										<div class="error login-footer-top">
											<p id="countdown" style="color:red; text-transform:uppercase"></p>
										</div>
									<?php else : ?>
										<div class="form-group">
											<input name="username" type="text" placeholder="Nama pengguna" <?php if ($_SESSION['siteman_wait'] == 1) : ?> disabled="disabled" <?php endif ?> value="" required class="form-username form-control">
										</div>
										<div class="form-group">
											<div class="input-group">
												<input name="password" id="password" type="password" placeholder="Kata sandi" <?php if ($_SESSION['siteman_wait'] == 1) : ?>disabled="disabled" <?php endif ?> value="" required class="form-username form-control">
												<span class="input-group-btn">
													<a haref="javascript:;" class="btn show-pass">
														<i class="fa fa-eye"></i>
													</a>
												</span>
											</div>
										</div>
										<button type="submit" class="btn">Masuk</button>
										<?php if ($_SESSION['siteman'] == -1) : ?>
											<div class="error">
												<p style="color:red; text-transform:uppercase">Login Gagal.<br />Nama pengguna atau kata sandi yang Anda masukkan salah!<br />
													<?php if ($_SESSION['siteman_try']) : ?>
														Kesempatan mencoba <?= ($_SESSION['siteman_try'] - 1); ?> kali lagi.</p>
											<?php endif; ?>
											</div>
										<?php elseif ($_SESSION['siteman'] == -2) : ?>
											<div class="error">
												Redaksi belum boleh masuk, Aplikasi belum memiliki sambungan internet!
											</div>
										<?php endif; ?>
									<?php endif; ?>
								</form>
							</div>
						</div>
					</div>
				</div>
				<dic class="copyright">
					<a href="<?= site_url(); ?>" target="_blank">Tapal Desa</a> &copy; <?php echo date("Y"); ?>. Allright reserved.
				</dic>
			</div>
		</div>
	</div>
</body>

</html>
<script src="<?= base_url() ?>assets/bootstrap/js/jquery.min.js"></script>
<script>
	function start_countdown() {
		var times = eval(<?= json_encode($_SESSION['siteman_timeout']) ?>) - eval(<?= json_encode(time()) ?>);
		var menit = Math.floor(times / 60);
		var detik = times % 60;
		timer = setInterval(function() {
			detik--;
			if (detik <= 0 && menit >= 1) {
				detik = 60;
				menit--;
			}
			if (menit <= 0 && detik <= 0) {
				clearInterval(timer);
				location.reload();
			} else {
				document.getElementById("countdown").innerHTML = "<b>Gagal 3 kali silakan coba kembali dalam " + menit + " MENIT " + detik + " DETIK </b>";
			}
		}, 1000)
	}

	$('document').ready(function() {
		var pass = $("#password");
		$('#checkbox').click(function() {
			if (pass.attr('type') === "password") {
				pass.attr('type', 'text');
			} else {
				pass.attr('type', 'password')
			}
		});

		if ($('#countdown').length) {
			start_countdown();
		}

		$('.show-pass').click(function() {
			var thisTog = $(this);
			var thisInput = $(this)
				.closest('.input-group')
				.find('input');
			if (thisInput.attr('type') === 'password') {
				thisInput.attr('type', 'text');
				thisTog.addClass('active');
			} else {
				thisInput.attr('type', 'password');
				thisTog.removeClass('active');
			}
		});
	});
</script>