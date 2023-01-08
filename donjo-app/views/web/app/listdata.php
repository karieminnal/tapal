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
	<link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/main.min.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/app/css/app.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/additional.css" />
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
	<section class="">

		<div class="row">
			<div class="col-md-12">
				<div class="d-flex justify-content-between my-3 mx-5">
					<div class="tabs active" id="tab01">
						<h6 class="font-weight-bold">Input</h6>
					</div>
					<div class="tabs" id="tab02">
						<h6 class="text-muted">Output</h6>
					</div>
				</div>
			</div>
		</div>

		<div id="tab011" class="tab-content show">
			<h6 class="box-title text-center mt-3">
				<b>Data Input Gabah 
				<?php echo 'DESA '. $leuit_panen[0]['nama_desa'] . ' '; ?>
				</b>
			</h6>

			<?php if($leuit_panen) { ?>

			<div class="row">
				<div class="col-sm-12">
					<div class="text-center">
						<span class="btn btn-default ">
							Total Input : 
							<?php foreach ($total_produksi as $tp) : ?>
								<strong><?= ton($tp['TOTAL_ALL']) ?></strong>
							<?php endforeach; ?>
						</span>
					</div>
				</div>
			</div>

			<div class="row" style="margin-top: 30px;">
				<div class="col-md-12">
					<div class="text-center">
						<a class="btn btn-sm" title="Pie Data" onclick="pieTypeInput();"><i class="fa fa-pie-chart"></i> Pie Data&nbsp;&nbsp;</a>
						<a class="btn btn-sm" title="Grafik Data" onclick="grafikTypeInput();"><i class="fa fa-bar-chart"></i> Grafik Data&nbsp;&nbsp;</a>
					</div>
					<div id="chartInput"> </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table table-bordered table-striped dataTable table-hover loading-table">
							<thead class="bg-gray disabled color-palette">
								<tr>
									<th class="no-sort">No</th>
									<th>Tanggal</th>
									<th>Dusun</th>
									<th>Sawah</th>
									<th>Jumlah Input</th>
									<th>Harga / Kg</th>
									<th>Total</th>
									<th class="no-sort">Ditambahkan</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($leuit_panen as $produksi) : ?>
									<tr>
										<td><?= $produksi['no'] ?></td>
										<td><?= tgl_indo_out($produksi['tanggal_produksi']) ?></td>
										<td><?= $produksi['dusun'] ?></td>
										<td><?= $produksi['pemilik'] ?></td>
										<td><?= ton($produksi['jumlah_panen']) ?></td>
										<td><?= rupiah24($produksi['harga']) ?></td>
										<td>
											<?php 
												$jumlahHarga = $produksi['harga']*$produksi['jumlah_panen'];
												echo rupiah24($jumlahHarga);
											?>
										</td>
										<td><?= tgl_indo_out($produksi['date_added']) ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<?php } else { ?>
				<p class="my-5 text-center">Belum ada data</p>
			<?php } ?>

			<div class="row mt-3 mb-4">
				<div class="col-sm-12">
					<div class="text-center">
						<a href="<?= base_url() ?>mobile_app/inputData" class="btn btn-default btn-success">Tambah Data</a>
					</div>
				</div>
			</div>
		</div>

		<div id="tab021" class="tab-content">
			<h6 class="box-title text-center mt-3">
				<b>Data Output Gabah 
				<?php echo 'DESA '. $leuit_panen[0]['nama_desa'] . ' '; ?>
				</b>
			</h6>

			<?php if($leuit_distribusi) { ?>
			<div class="row">
				<div class="col-sm-12">
					<div class="text-center">
						<span class="btn btn-default ">
							Total Output : 
							<?php foreach ($total_distribusi as $tp) : ?>
								<strong><?= ton($tp['TOTAL_ALL']) ?></strong>
							<?php endforeach; ?>
						</span>
					</div>
				</div>
			</div>
			
			<div class="row" style="margin-top: 30px;">
				<div class="col-md-12">
					<div class="text-center">
						<!-- <a class="btn btn-sm" title="Pie Data" onclick="pieTypeOutput();"><i class="fa fa-pie-chart"></i> Pie Data&nbsp;&nbsp;</a> -->
						<a class="btn btn-sm" title="Grafik Data" onclick="grafikTypeOutput();"><i class="fa fa-bar-chart"></i> Grafik Data&nbsp;&nbsp;</a>
					</div>
					<div id="chartOutput"> </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table table-bordered table-striped dataTable table-hover loading-table">
							<thead class="bg-gray disabled color-palette">
								<tr>
									<th class="no-sort">No</th>
									<th>Tanggal</th>
									<th>Kebutuhan</th>
									<th>Jumlah Distribusi</th>
									<th>Harga / Kg</th>
									<th>Total</th>
									<th class="no-sort">Ditambahkan</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($leuit_distribusi as $distribusi) : ?>
									<tr>
										<td><?= $distribusi['no'] ?></td>
										<td><?= tgl_indo_out($distribusi['tanggal_distribusi']) ?></td>
										<td><?= $distribusi['jenis'] ?></td>
										<td><?= ton($distribusi['jumlah_distribusi']) ?></td>
										<td><?= rupiah24($distribusi['harga']) ?></td>
										<td>
											<?php 
												$jumlahHarga = $distribusi['harga']*$distribusi['jumlah_distribusi'];
												echo rupiah24($jumlahHarga);
											?>
										</td>
										<td><?= tgl_indo_out($distribusi['date_added']) ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<?php } else { ?>
				<p class="my-5 text-center">Belum ada data</p>
			<?php } ?>

			<div class="row mt-3 mb-4">
				<div class="col-sm-12">
					<div class="text-center">
						<a href="<?= base_url() ?>mobile_app/inputDataDistribusi" class="btn btn-default btn-success">Tambah Distribusi</a>
					</div>
				</div>
			</div>
		</div>

	</section>
</main>

<script id="scriptJquery" type="text/javascript" src="<?= base_url() ?>assets/front/js/jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/vendors.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/select2/js/select2.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/select2/js/i18n/id.js"></script>
<script src="<?= base_url() ?>assets/bootstrap/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/bootstrap/js/dataTables.bootstrap.min.js"></script>
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
</script>

<script>
	$(document).ready(function () {
		<?php if($leuit_panen) { ?>
			pieTypeInput();

			$('.tabs').click(function () {
				$('.tabs').removeClass('active');
				$('.tabs h6').removeClass('font-weight-bold');
				$('.tabs h6').addClass('text-muted');
				$(this).children('h6').removeClass('text-muted');
				$(this).children('h6').addClass('font-weight-bold');
				$(this).addClass('active');

				current_fs = $('.active');

				next_fs = $(this).attr('id');
				next_fs = '#' + next_fs + '1';

				$('.tab-content').removeClass('show');
				$(next_fs).addClass('show');

				current_fs.animate(
				{},
				{
					step: function () {
					current_fs.css({
						display: 'none',
						position: 'relative',
					});
					next_fs.css({
						display: 'block',
					});
					},
				},
				);
			});

			var chart;
			grafikTypeOutput();
		<?php } ?>
		var termDesa = GetURLParameter('desa');
		if (typeof termDesa !== "undefined") {
			$('#filterDesa').val(termDesa);
		}
		var $desaSelect = $(".select2").select2();
		$desaSelect.on('change', function (e) {
			var val = $(this).val();
			var thisParam = $(this).attr('data-param');
			var pag = window.location.pathname;
			if(val == 0) {
				window.location.href = pag;
			} else {
				var url = window.location.search;
					url = url.replace("?", "").split("&");

				var n = 0;
				for (var count = 0; count < url.length; count++) {
					if (!url[count].indexOf(thisParam)) {
						n = count;
						break;
					}
				}

				if (n !=0) {
					url.splice(n,1);
				}

				var len = url.length;
				var newUrl = url.join("&");

				if (len > 0) {
					newUrl = pag + "?" + newUrl + "&"+thisParam+"=" + val;
				} else {
					newUrl = pag + newUrl + "?"+thisParam+"=" + val;
				}
				window.location.href = newUrl;
			}
		});
	});

	function GetURLParameter(sParam){
		var sPageURL = window.location.search.substring(1);
		var sURLVariables = sPageURL.split('&');
		for (var i = 0; i < sURLVariables.length; i++){
			var sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == sParam){
				return sParameterName[1];
			}
		}
	}

	<?php if($leuit_panen) { ?>
		function pieTypeInput() {
			// Build the chart
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chartInput',
					type: 'pie',
					options3d: {
						enabled: true,
						alpha: 45
					}
				},
				title:0,
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						showInLegend: true,
						innerSize: 100,
						depth: 45,
						colors: ['#42b649', '#b6d434', '#fbde08', '#f15f23', '#ed1e28']
					}
				},
				series: [{
					type: 'pie',
					name: 'Jumlah Input',
					shadow:1,
					border:1,
					data: [
						<?php if (isset($_REQUEST['sawah']) or isset($_REQUEST['ts'])) { ?>
							<?php
								$arr2 = array();
								foreach ($panen_group as $pg) {
									$getTgl = $pg['tanggal_produksi'];
									$getThn = date('Y', strtotime($getTgl));
									$getBln = getBulan(date('n', strtotime($getTgl)));
									$arr2[] = '["'.$getThn.'",'.ton2($pg['TOTAL']).']';
								}
								$arr2data = implode(",", $arr2);
								echo $arr2data; 
							?>
						<?php } else if(isset($_REQUEST['dusun']) ) { ?>
							<?php
								$arr2 = array();
								foreach ($panen_group as $pg) {
									$arr2[] = '["SAWAH '.$pg['pemilik'].'",'.ton2($pg['TOTAL']).']';
								}
								$arr2data = implode(",", $arr2);
								echo $arr2data; 
							?>
						<?php } else { ?>
							<?php
								$arr2 = array();
								foreach ($panen_group as $pg) {
									$arr2[] = '["DUSUN '.$pg['dusun'].'",'.ton2($pg['TOTAL']).']';
								}
								$arr2data = implode(",", $arr2);
								echo $arr2data; 
							?>
						<?php } ?>
					]
				}]
			});
		}
		function grafikTypeInput() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chartInput',
					defaultSeriesType: 'column',
					options3d: {
						enabled: true,
						alpha: 15,
						beta: 15,
						depth: 50,
						viewDistance: 25
					}
				},
				title: 0,
				xAxis: {
					<?php if (isset($_REQUEST['sawah']) or isset($_REQUEST['ts'])) { ?>
						title: {
							text: 'Tahun'
						},
						categories: [
							<?php
								$arr1 = array();
								foreach ($panen_group as $pg) {
									$getTgl = $pg['tanggal_produksi'];
									$getThn = date('Y', strtotime($getTgl));
									$getBln = getBulan(date('n', strtotime($getTgl)));
									$arr1[] = '"'.$getThn.'"';
								}
								$arr1data = implode(",", $arr1);
								echo $arr1data; 
							?>
						]
					<?php } else { ?>
						title: {
							text: ''
						},
						categories: [
							<?php
								$arr1 = array();
								foreach ($panen_group as $pg) {
									$arr1[] = '"DUSUN '.$pg['dusun'].'"';
								}
								$arr1data = implode(",", $arr1);
								echo $arr1data; 
							?>
						]
					<?php } ?>
			},
			yAxis: {
				title: {
					text: 'Jumlah Input (Ton)'
				}
			},
			legend: {
				layout: 'vertical',
				enabled: false
			},
			plotOptions: {
				series: {
					colorByPoint: true
				},
				column: {
					pointPadding: 0,
					borderWidth: 0,
					colors: ['#42b649', '#b6d434', '#fbde08', '#f15f23', '#ed1e28']
				}
			},
			series: [{
				shadow:1,
				border:1,
				data: [
					<?php if (isset($_REQUEST['sawah']) or isset($_REQUEST['ts'])) { ?>
						<?php
							$arr2 = array();
							foreach ($panen_group as $pg) {
								$getTgl = $pg['tanggal_produksi'];
								$getThn = date('Y', strtotime($getTgl));
								$getBln = getBulan(date('n', strtotime($getTgl)));
								$arr2[] = '["Tahun '.$getThn.'",'.ton2($pg['TOTAL']).']';
							}
							$arr2data = implode(",", $arr2);
							echo $arr2data; 
						?>
					<?php } else { ?>
						<?php
							$arr2 = array();
							foreach ($panen_group as $pg) {
								$arr2[] = '["DUSUN '.$pg['dusun'].'",'.ton2($pg['TOTAL']).']';
							}
							$arr2data = implode(",", $arr2);
							echo $arr2data; 
						?>
					<?php } ?>
				]
				}]
			});
		}
		var tablePanen = $('#tablePanenList');
		if (tablePanen.length) {
			var tablePanen = $('#tablePanenList').DataTable({
			columnDefs: [
				{
				targets: 'no-sort',
				orderable: false,
				},
			],
			pageLength: 100,
			language: {
				decimal: '.',
				thousands: ',',
				lengthMenu: 'Tampilkan _MENU_ data perhalaman',
				zeroRecords: 'Data tidak ditemukan',
				info: '_START_ - _END_ dari _TOTAL_ data',
				infoEmpty: 'Data tidak ditemukan',
				infoFiltered: '(filtered from _MAX_ total records)',
				sSearch: 'Cari:',
				oPaginate: {
				sFirst: 'Awal',
				sLast: 'Akhir',
				sNext: '>',
				sPrevious: '<',
				},
			},
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			},
			formatNumber: function (toFormat) {
				return toFormat.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
			},
			initComplete: function (settings, json) {
				$('[data-toggle="tooltip"]').tooltip();
				$('.loading-data').fadeOut('slow');
			},
			});
			tablePanen
			.on('order.dt search.dt', function () {
				tablePanen
				.column(0, {
					search: 'applied',
					order: 'applied',
				})
				.nodes()
				.each(function (cell, i) {
					cell.innerHTML = i + 1;
				});
				$('[data-toggle="tooltip"]').tooltip();
			})
			.draw();
		}
	<?php } ?>
	
	<?php if($leuit_distribusi) { ?>
		function pieTypeOutput() {
			// Build the chart
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chartOutput',
					options3d: {
						enabled: true,
						alpha: 45
					},
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title:0,
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						showInLegend: true,
						innerSize: 100,
						depth: 45,
						colors: ['#42b649', '#b6d434', '#fbde08', '#f15f23', '#ed1e28']
					}
				},
				series: [{
					type: 'pie',
					name: 'Jumlah Output',
					shadow:1,
					border:1,
					data: [
							<?php
								$arr2 = array();
								foreach ($distribusi_group as $pg) {
									$arr2[] = '["'.$pg['jenis'].'",'.ton2($pg['TOTAL']).']';
								}
								$arr2data = implode(",", $arr2);
								echo $arr2data; 
							?>
					]
				}]
			});
		}

		function grafikTypeOutput() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chartOutput',
					defaultSeriesType: 'column',
					options3d: {
						enabled: true,
						alpha: 15,
						beta: 15,
						depth: 50,
						viewDistance: 25
					}
				},
				title: 0,
				xAxis: {
					title: {
						text: ''
					},
					categories: ['Produksi','Distribusi/<br>Logistik','Komersil']
			},
			yAxis: {
				title: {
					text: 'Jumlah (Ton)'
				}
			},
			legend: {
				layout: 'vertical',
				enabled: false
			},
			plotOptions: {
				series: {
					colorByPoint: true
				},
				column: {
					pointPadding: 0,
					borderWidth: 0,
					colors: ['#42b649', '#b6d434', '#fbde08', '#f15f23', '#ed1e28']
				}
			},
			series: [{
				shadow:1,
				border:1,
				data: [
					['Produksi',0.05],
					['Distribusi/Logistik',0.05],
					['Komersil',0.1],
				]
				}]
			});

			// $('#chart').removeAttr('hidden');
		}
	<?php } ?>
</script>

</body>
</html>