<?php

/**
 * File ini:
 *
 * Modul Header OpenSID Tema Klasik
 *
 * /themes/klasik/layouts/hadakewa.php
 *
 */

/**
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:

 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.

 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package OpenSID
 * @author  Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license http://www.gnu.org/licenses/gpl.html  GPL V3
 * @link  https://github.com/OpenSID/OpenSID
 */
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>
		<?=
			$this->setting->website_title
				. ' ' . ucwords($this->setting->sebutan_desa)
				. (($desa['nama_desa']) ? ' ' . $desa['nama_desa'] : '')
				. get_dynamic_title_page_from_path();
		?>
	</title>
	<meta content="utf-8" http-equiv="encoding">
	<meta name="keywords" content="<?= ucwords($this->setting->sebutan_desa) ?> <?= $data['nama_desa']; ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta property="og:site_name" content="<?= $desa['nama_desa']; ?> - Pintasia" />
	<meta property="og:type" content="article" />
	<meta name="description" content="Website <?= ucwords($this->setting->sebutan_desa) . ' ' . $desa['nama_desa']; ?> - Pintasia" />

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
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/main.min.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/front/css/artikel.css" />

	<script type="text/javascript">
		var BASE_URL = "<?= base_url() ?>";
	</script>
	<script id="scriptJquery" type="text/javascript" src="<?= base_url() ?>assets/front/js/jquery.js"></script>
	<script id="scriptJquery" type="text/javascript" src="<?= base_url() ?>assets/front/js/artikel.js"></script>
</head>

<body class="body-artikel <?php if (isset($_REQUEST['app'])) { ?> from-app <?php } ?>">
	<div class="toggle-menu mobile">
		<div class="logo-desa">
			<a href="<?= site_url(); ?><?php if (isset($_REQUEST['app'])) { ?>?app=1<?php } ?>">
				<img src="<?= gambar_desa($desa['logo']); ?>" alt="<?= $desa['nama_desa'] ?>" />
			</a>
			<span class="nama-desa"><?= ucwords($this->setting->sebutan_desa) ?> <?= $desa['nama_desa'] ?></span>
		</div>
		<a href="javascript:;" class="btn btn-sm">
			<i class="fa fa-bars"></i>
		</a>
	</div>
	<div class="left-content">
		<!-- <div class="toggle-menu">
			<a href="javascript:;" class="btn btn-sm">
				<i class="fa fa-bars"></i>
			</a>
		</div> -->
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
					<!-- <span class="d-block d-md-none">GIS</span>
					<span class="d-none d-md-block d-lg-none"><?= ucwords($this->setting->sebutan_desa) ?> <?= $desa['nama_desa'] ?></span>
					<span class="d-none d-lg-block"><?= ucwords($this->setting->sebutan_desa) ?> <?= $desa['nama_desa'] ?></span> -->
					<span class=""><?= ucwords($this->setting->sebutan_desa) ?> <?= $desa['nama_desa'] ?></span>
				</h1>
			</div>
		</header>

		<div class="main-nav">
			<ul class='list_kategori level1'>
				<li class='level1'>
					<a href='/' class='judul_kategori'>Beranda</a>
				</li>
			</ul>
		</div>
	</div>

	<main class="site-content" role="main">
		<section class="section">