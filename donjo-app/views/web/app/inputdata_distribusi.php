<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
	
	<!-- Bootstrap Date time Picker -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap-datetimepicker.min.css">
	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/main.min.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/additional.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/app/css/app.css" />
	<style>
		body {
			background: white;
		}
	</style>
	<script type="text/javascript">
		var BASE_URL = "<?= base_url() ?>";
	</script>
</head>

<body <?php if (isset($_REQUEST['app'])) { ?> class="from-app" <?php } ?>>
<main class="my-3 mx-3" role="main">
	<section>
		<form id="validasi" action="#" method="POST" enctype="multipart/form-data" class="form-horizontal">
			<div class="box box-info">
					
					<script type="text/javascript">
						var csrfParam = '<?= $this->security->get_csrf_token_name() ?>';
						var getCsrfToken = () => document.cookie.match(new RegExp(csrfParam + '=(\\w+)'))[1]
					</script>
					<script defer src="<?= base_url() ?>assets/js/anti-csrf.js"></script>
					<div class="box-body">
						<div class="form-group form-row">
							<label class="control-label col-sm-3">Tanggal</label>
							<div class="col-sm-7">
								<input type="text" name="tanggal_distribusi" class="form-control form-control-sm datepicker required" value="<?= tgl_indo_out($distribusi['tanggal_distribusi']) ?>">
							</div>
						</div>
						<div class="form-group form-row">
							<label class="control-label col-sm-3">Kebutuhan</label>
							<div class="col-sm-7">
								<select name="jenis" class="form-control form-control-sm required select-jenis" id="idjenis">
									<option value="">Pilih Kebutuhan</option>
									<option value="Produksi">Produksi</option>
									<option value="Komersil">Komersil</option>
									<option value="Distribusi/Logistik">Distribusi/Logistik</option>
								</select>
							</div>
						</div>
						<div class="form-group form-row">
							<label class="control-label col-sm-3">Jumlah Distribusi (Kg)</label>
							<div class="col-sm-7">
								<input name="jumlah_distribusi" class="form-control form-control-sm required" maxlength="100" type="text" value="<?= $distribusi['jumlah_distribusi'] ?>" pattern="^\d*(\.\d{0,2})?$"></input>
							</div>
						</div>
						<div class="form-group form-row">
							<label class="control-label col-sm-3">Harga/Kg</label>
							<div class="col-sm-7">
								<input name="harga" class="form-control form-control-sm required" maxlength="100" type="number" value="<?= $distribusi['harga'] ?>"></input>
							</div>
						</div>
					</div>
					<div class='box-footer'>
						<div class='col-xs-12'>
							<a href="<?= base_url() ?>mobile_app/loadLeuitDataDesa" class='btn btn-default btn-sm'>Batal</a>
							<button type='submit' class='btn btn-success btn-sm pull-right confirm'>Simpan</button>
						</div>
					</div>
			</div>
		</form>
	</section>
</main>
<script id="scriptJquery" type="text/javascript" src="<?= base_url() ?>assets/front/js/jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/vendors.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/select2/js/select2.min.js"></script>
<script src="<?= base_url() ?>assets/bootstrap/js/moment.min.js"></script>
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?= base_url() ?>assets/bootstrap/js/id.js"></script>
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap-datepicker.id.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/select2/js/i18n/id.js"></script>
<script type="text/javascript">
	var loadJS = function(url, scriptOnLoad, location) {
		var scriptTag = document.createElement('script');
		scriptTag.src = url;
		scriptTag.onload = scriptOnLoad;
		scriptTag.onreadystatechange = scriptOnLoad;
		$(scriptTag).insertAfter('#scriptJquery');
	};
	var scriptOnLoad = function() {
	}
	$(document).ready(function () {
		// $(".select-sawah, .select-dusun").select2();
		
		$('.datepicker').datepicker({
			weekStart: 1,
			language: 'id',
			format: 'dd-mm-yyyy',
			autoclose: true,
		});
	});
	
	$(function () {
        $('form').bind('submit', function () {
          $.ajax({
            type: 'post',
            url: '<?= base_url() ?>mobile_app/insertDistribusi',
            data: $('form').serialize(),
            success: function () {
              alert('Data berhasil tersimpan');
			  window.location.href = "<?= base_url() ?>mobile_app/loadLeuitDataDesa";
            }
          });
          return false;
        });
      });
</script>

</body>
<html>