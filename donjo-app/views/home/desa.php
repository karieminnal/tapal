<?php

/**
 * File ini:
 *
 * View untuk halaman dashboard Admin
 *
 * donjo-app/views/home/desa.php
 *
 */
?>

<style type="text/css">
	.text-white {
		color: white;
	}

	.pengaturan {
		float: left;
		padding-left: 10px;
	}

	.modal-body {
		overflow-y: auto;
		height: 400px;
		margin-left: 5px;
		margin-right: 5px;
	}
</style>
<div class="content-wrapper">
	<section class='content-header'>
		<h1>Dashboard</h1>
		<ol class='breadcrumb'>
			<li class='active'><a href='<?= site_url() ?>'><i class='fa fa-home'></i> Home</a></li>
		</ol>
	</section>
	<section class='content' id="maincontent">
		<div class='row'>
			<div class='col-md-12'>
				<div class='box box-info'>
					<div class="box-header with-border">
						<?php $newKab = str_replace("KABUPATEN","KAB. ",$desa['nama_kabupaten']); ?>
						<h3 class="box-title"><?= 'DESA ' . $desa['nama_desa'] . ' - '. $newKab; ?></h3>
					</div>
					<div class='box-body'>
						<div class="row">
							<div class="col-lg-4 col-xs-6">
								<div class="small-box bg-blue">
									<div class="inner">
										<?php foreach ($dusun as $data) : ?>
											<h3><?= $data['jumlah'] ?></h3>
										<?php endforeach; ?>
										<p>Wilayah Dusun</p>
									</div>
									<div class="icon">
										<i class="ion ion-map"></i>
									</div>
									<a href="<?= site_url('sid_core') ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-6">
								<div class="small-box bg-aqua">
									<div class="inner">
										<?php foreach ($penduduk as $data) : ?>
											<h3><?= $data['jumlah'] ?></h3>
										<?php endforeach; ?>
										<p>Penduduk</p>
									</div>
									<div class="icon">
										<i class="ion ion-person"></i>
									</div>
									<a href="<?= site_url('penduduk/clear') ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-6">
								<div class="small-box bg-teal">
									<div class="inner">
										<?php foreach ($keluarga as $data) : ?>
											<h3><?= $data['jumlah'] ?></h3>
										<?php endforeach; ?>
										<p>Keluarga</p>
									</div>
									<div class="icon">
										<i class="ion ion-ios-people"></i>
									</div>
									<a href="<?= site_url('keluarga/clear') ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-6">
								<div class="small-box bg-green">
									<div class="inner">
										<h3><?= ton2($total_input['TOTAL_ALL']) ?> <sup style="font-size: 20px">Ton</sup></h3>
										<p>Total Input</p>
									</div>
									<div class="icon">
										<i class="ion ion-leaf"></i>
									</div>
									<a href="<?= site_url('leuit_panen') ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-6">
								<div class="small-box bg-yellow">
									<div class="inner">
										<h3><?= ton2($total_distribusi['TOTAL_ALL']) ?> <sup style="font-size: 20px">Ton</sup></h3>
										<p>Total Distribusi</p>
									</div>
									<div class="icon">
										<i class="ion ion-paper-airplane"></i>
									</div>
									<a href="<?= site_url('leuit_distribusi') ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-6">
								<div class="small-box bg-maroon">
									<div class="inner">
										<h3><?= ton2(($total_input['TOTAL_ALL'] - $total_distribusi['TOTAL_ALL'])) ?> <sup style="font-size: 20px">Ton</sup></h3>
										<p>Stok Gabah</p>
									</div>
									<div class="icon">
										<i class="ion ion-locked"></i>
									</div>
									<a href="<?= site_url('leuit_distribusi') ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
														
		<?php if($_SESSION['grup'] == 1) { ?>
		<div class='row'>
			<div class='col-md-12'>
				<div class='box box-info'>
					<div class="box-header with-border">
						<h3 class="box-title">Data Leuit Jabar</h3>
						<div class="box-tools text-right">
							<select name="" id="filterYearAnalisa" class="form-control form-control-sm">
								<option value="0">Semua Tahun</option>
								<?php foreach ($panen_get_tahun as $tahun) {
										$getTgl = $tahun['tanggal_produksi'];
										$getThn = date('Y', strtotime($getTgl));
									?>
									<option value="<?php echo $getThn ?>">Tahun <?php echo $getThn ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class='box-body'>
						<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
							<div class="row">
								<div class="col-sm-12">
									<div class="table-responsive-mobile">
										<table class="table table-striped dataTable table-hover loading-table" id="tableAnalisaList">
											<thead class="">
												<tr>
													<th class="no-sort" width="20">No</th>
													<th>Desa</th>
													<th>Kecamatan</th>
													<th>Kabupaten</th>
													<th width="90">Input (ton)</th>
													<th width="90">Output (ton)</th>
													<th width="90">Stok (ton)</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class='row'>
			<div class='col-md-12'>
				<div class='box box-info'>
					<div class="box-header with-border">
						<h3 class="box-title">Distribusi Leuit Jabar</h3>
						<div class="box-tools text-right">
							<select name="" id="filterYearDistribusi" class="form-control form-control-sm">
								<option value="0">Semua Tahun</option>
								<?php foreach ($panen_get_tahun as $tahun) {
										$getTgl = $tahun['tanggal_produksi'];
										$getThn = date('Y', strtotime($getTgl));
									?>
									<option value="<?php echo $getThn ?>">Tahun <?php echo $getThn ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class='box-body'>
						<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
							<div class="row">
								<div class="col-sm-12">
									<div class="table-responsive-mobile">
										<table class="table table-striped dataTable table-hover loading-table" id="tableAnalisaDistribusi">
											<thead class="">
												<tr>
													<th class="no-sort" width="20">No</th>
													<th>Desa</th>
													<th>Kab.</th>
													<th width="90">Komersil (ton)</th>
													<th width="90">Produksi (ton)</th>
													<th width="90">Logistik (ton)</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<?php } ?>
		<!-- <div class='row'>
			<div class='col-lg-6 col-md-12'>
				<div class='box box-info'>
					<div class="box-header with-border">
						<h3 class="box-title">Input Leuit</h3>
					</div>
					<div class='box-body text-center'>
						<img class="loading-iframe" src="<?= base_url() ?>assets/images/loader.gif"></img>
						<div class="error-iframe">Timeout. Coba reload kembali</div>
						<?php if($_SESSION['grup'] == 1) { ?>
							<iframe src="/first/loadLeuitAllData?tab=input" class="iframe-view" frameborder="0" onload="successLoadIframe()"></iframe>
						<?php } else { ?>
							<iframe src="/first/loadLeuitAllData?tab=input&desa=<?php echo $_SESSION['filterDesa']?>" class="iframe-view" frameborder="0" onload="successLoadIframe()"></iframe>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class='col-lg-6 col-md-12'>
				<div class='box box-info'>
					<div class="box-header with-border">
						<h3 class="box-title">Distribusi Leuit</h3>
					</div>
					<div class='box-body text-center'>
						<img class="loading-iframe" src="<?= base_url() ?>assets/images/loader.gif"></img>
						<div class="error-iframe">Timeout. Coba reload kembali</div>
						<?php if($_SESSION['grup'] == 1) { ?>
							<iframe src="/first/loadLeuitAllData?tab=output" class="iframe-view" frameborder="0" onload="successLoadIframe()"></iframe>
						<?php } else { ?>
							<iframe src="/first/loadLeuitAllData?tab=output&desa=<?php echo $_SESSION['filterDesa']?>" class="iframe-view" frameborder="0" onload="successLoadIframe()"></iframe>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class='col-lg-12 col-md-12'>
				<div class='box box-info'>
					<div class="box-header with-border">
						<h3 class="box-title">Analisa Leuit</h3>
					</div>
					<div class='box-body text-center'>
						<img class="loading-iframe" src="<?= base_url() ?>assets/images/loader.gif"></img>
						<div class="error-iframe">Timeout. Coba reload kembali</div>
						<?php if($_SESSION['grup'] == 1) { ?>
							<iframe src="/first/loadLeuitAllData?tab=analisa" class="iframe-view" frameborder="0" onload="successLoadIframe()"></iframe>
						<?php } else { ?>
							<iframe src="/first/loadLeuitAllData?tab=analisa&desa=<?php echo $_SESSION['filterDesa']?>" class="iframe-view" frameborder="0" onload="successLoadIframe()"></iframe>
						<?php } ?>
					</div>
				</div>
			</div>
		</div> -->
	</section>
</div>
<script>
	$(document).ready(function () {
		<?php if($_SESSION['grup'] == 1) { ?>
			var tableAnalisaList = $('#tableAnalisaList').DataTable({
				iDisplayLength: 20,
				processing: true,
				ajax: '/api_custom/analisa_leuit',
				columns: [
					{ data: 'no'},
					{ data: 'nama_desa' },
					{ data: 'nama_kecamatan' },
					{ data: 'nama_kabupaten' },
					{ data: 'leuit_input' },
					{ data: 'leuit_output' },
					{ data: 'leuit_stok' },
				],
			});

			// var tableDistribusiList = $('#tableAnalisaDistribusi').DataTable({
			// 	iDisplayLength: 20,
			// 	processing: true,
			// 	ajax: '/api_custom/analisa_leuit',
			// 	columns: [
			// 		{ data: 'no'},
			// 		{ data: 'nama_desa' },
			// 		{ data: 'nama_kabupaten' },
			// 		{ data: 'leuit_output_komersil' },
			// 		{ data: 'leuit_output_produksi' },
			// 		{ data: 'leuit_output_logistik' },
			// 	],
			// });

			$("#filterYearAnalisa").on("change", function(){
				tableAnalisaList.ajax.url("/api_custom/analisa_leuit?year="+$(this).val()).load();
			});

			// $("#filterYearDistribusi").on("change", function(){
			// 	tableDistribusiList.ajax.url("/api_custom/analisa_leuit?year="+$(this).val()).load();
			// });
		<?php } ?>
	});

</script>