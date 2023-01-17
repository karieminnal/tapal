<?php if(!isset($_REQUEST['fe'])) { ?>
<?php $this->load->view($folder_themes . '/layouts/header_iframe.php'); ?>

<body <?php if (isset($_REQUEST['app'])) { ?> class="from-app" <?php } ?>>

<link rel="stylesheet" href="<?= base_url() ?>assets/css/main.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>assets/app/css/app.css" />
<link rel="stylesheet" href="<?= base_url() ?>assets/css/additional.css" />
<style>
	body {
		background: none;
		overflow-x: hidden;
	}
</style>
<?php } ?>
<main class="my-3 mx-3" role="main">
	<section class="">
	<?php if($_SESSION['grup'] == 1) { ?>
		<?php if(!isset($_REQUEST['fe'])) { ?>
			<div class='form-group'>
				<select class="form-control input-sm select2" name="filterDesa" data-param="desa" id="filterDesa">
					<option value="">Filter Desa</option>
					<?php foreach ($listdesa as $data) : 
						$kab = $data['nama_kabupaten'];
						$newKab = str_replace("KABUPATEN","KAB. ",$kab);
						?>
						<option value="<?= $data['id'] ?>"><?= $data['nama_desa'] ?> - <?= $newKab ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php } ?>
	<?php } ?>

	<?php if($leuit_panen) { ?>
		<?php if (isset($_REQUEST['tab'])) { 
			$tab = $_REQUEST['tab'];
			?>
			<?php if ($tab == 'input') { ?>
				<h6 class="box-title text-center mt-3">
					<b>Data Input Gabah 
					<?php if (isset($_REQUEST['desa'])) {
						echo 'DESA '. $leuit_panen[0]['nama_desa'] . ' ';
					} ?>
					</b>
				</h6>

				<div class="row">
					<div class="col-sm-12">
						<div class="text-center">
							<span class="btn btn-default ">
								Total Input : <strong><?= ton($total_produksi['TOTAL_ALL']) ?></strong>
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
			<?php } else if($tab == 'output') { ?>
				<h6 class="box-title text-center mt-3">
					<b>Data Output Gabah 
					<?php if (isset($_REQUEST['desa'])) {
						echo 'DESA '. $leuit_panen[0]['nama_desa'] . ' ';
					} ?>
					</b>
				</h6>

				<div class="row">
					<div class="col-sm-12">
						<div class="text-center">
							<span class="btn btn-default ">
								Total Output : <strong><?= ton($total_distribusi['TOTAL_ALL']) ?></strong>
							</span>
						</div>
					</div>
				</div>
				
				<div class="row" style="margin-top: 30px;">
					<div class="col-md-12">
						<div class="text-center">
							<a class="btn btn-sm" title="Pie Data" onclick="pieTypeOutput();"><i class="fa fa-pie-chart"></i> Pie Data&nbsp;&nbsp;</a>
							<a class="btn btn-sm" title="Grafik Data" onclick="grafikTypeOutput();"><i class="fa fa-bar-chart"></i> Grafik Data&nbsp;&nbsp;</a>
						</div>
						<div id="chartOutput"> </div>
					</div>
				</div>
			<?php } else { ?>
				<h6 class="box-title text-center mt-3">
					<b>Analisa Gabah 
					<?php if (isset($_REQUEST['desa'])) {
						echo 'DESA '. $leuit_panen[0]['nama_desa'] . ' ';
					} ?>
					</b>
				</h6>

				<div class="row" style="margin-top: 30px;">
					<div class="col-md-12">
						<div id="chartAnalisa"> </div>
					</div>
				</div>
			<?php } ?>
		<?php } else { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="d-flex justify-content-between my-3 mx-5">
						<?php if(!isset($_REQUEST['fe'])) { ?>
							<div class="tabs active" id="tab01">
								<h4 class="font-weight-bold">Input</h4>
							</div>
							<div class="tabs" id="tab02">
								<h4 class="text-muted">Output</h4>
							</div>
							<div class="tabs" id="tab03">
								<h4 class="text-muted">Analisa</h4>
							</div>
						<?php } else { ?>
							<div class="tabs active" id="tab01">
								<h6 class="font-weight-bold">Input</h6>
							</div>
							<div class="tabs" id="tab02">
								<h6 class="text-muted">Output</h6>
							</div>
							<div class="tabs" id="tab03">
								<h6 class="text-muted">Analisa</h6>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<div id="tab011" class="tab-content show">
				<h6 class="box-title text-center mt-3">
					<b>Data Input Gabah 
					<?php if (isset($_REQUEST['desa'])) {
						echo 'DESA '. $leuit_panen[0]['nama_desa'] . ' ';
					} ?>
					</b>
				</h6>

				<div class="row">
					<div class="col-sm-12">
						<div class="text-center">
							<span class="btn btn-default ">
								Total Input : <strong><?= ton($total_produksi['TOTAL_ALL']) ?></strong>
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
			</div>

			<div id="tab021" class="tab-content">
				<h6 class="box-title text-center mt-3">
					<b>Data Output Gabah 
					<?php if (isset($_REQUEST['desa'])) {
						echo 'DESA '. $leuit_panen[0]['nama_desa'] . ' ';
					} ?>
					</b>
				</h6>

				<div class="row">
					<div class="col-sm-12">
						<div class="text-center">
							<span class="btn btn-default ">
								Total Output : <strong><?= ton($total_distribusi['TOTAL_ALL']) ?></strong>
							</span>
						</div>
					</div>
				</div>
				
				<div class="row" style="margin-top: 30px;">
					<div class="col-md-12">
						<div class="text-center">
							<a class="btn btn-sm" title="Pie Data" onclick="pieTypeOutput();"><i class="fa fa-pie-chart"></i> Pie Data&nbsp;&nbsp;</a>
							<a class="btn btn-sm" title="Grafik Data" onclick="grafikTypeOutput();"><i class="fa fa-bar-chart"></i> Grafik Data&nbsp;&nbsp;</a>
						</div>
						<div id="chartOutput"> </div>
					</div>
				</div>
			</div>

			<div id="tab031" class="tab-content">
				<h6 class="box-title text-center mt-3">
					<b>Analisa Gabah 
					<?php if (isset($_REQUEST['desa'])) {
						echo 'DESA '. $leuit_panen[0]['nama_desa'] . ' ';
					} ?>
					</b>
				</h6>

				<div class="row" style="margin-top: 30px;">
					<div class="col-md-12">
						<div id="chartAnalisa"> </div>
					</div>
				</div>
			</div>
		<?php } ?>

	<?php } else { ?>
		<p class="my-5 text-center">Belum ada data</p>
	<?php } ?>

	</section>
</main>
<?php if(!isset($_REQUEST['fe'])) { ?>
<?php $this->load->view($folder_themes . '/layouts/script_iframe.php'); ?>
<?php } ?>
<script>
	$(document).ready(function () {
		<?php if($leuit_panen) { ?>

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
			<?php if (isset($_REQUEST['tab'])) { 
			$tab = $_REQUEST['tab'];
			?>
				<?php if ($tab == 'input') { ?>
					pieTypeInput();
				<?php } else if($tab == 'output') { ?>
					pieTypeOutput();
				<?php } else if($tab == 'analisa') { ?>
					grafikTypeAnalisa();
				<?php } ?>
			<?php } else { ?>
				pieTypeInput();
				pieTypeOutput();
				grafikTypeAnalisa();
			<?php } ?>
		<?php } ?>

		<?php if(!isset($_REQUEST['fe'])) { ?>
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
		<?php } ?>
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
				tooltip: {
					pointFormat: '{series.name}: <b>{point.y:.2f} ton</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						showInLegend: true,
						innerSize: 100,
						depth: 45,
						colors: ['#42b649', '#b6d434', '#fbde08', '#f15f23', '#ed1e28'],
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.y:.2f} ton'
						}
					}
				},
				series: [{
					type: 'pie',
					name: 'Jumlah',
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
									$arr2[] = '["SAWAH '.($pg['pemilik'] != null ? $pg['pemilik'] : 'Pemilik tidak diketahui').'",'.ton2($pg['TOTAL']).']';
								}
								$arr2data = implode(",", $arr2);
								echo $arr2data; 
							?>
						<?php } else if(isset($_REQUEST['desa']) ) { ?>
							<?php
								$arr2 = array();
								foreach ($panen_group as $pg) {
									$arr2[] = '["DUSUN '.$pg['dusun'].'",'.ton2($pg['TOTAL']).']';
								}
								$arr2data = implode(",", $arr2);
								echo $arr2data; 
							?>
						<?php } else { ?>
							<?php
								$arr2 = array();
								foreach ($panen_group as $pg) {
									$arr2[] = '["DESA '.$pg['nama_desa'].'",'.ton2($pg['TOTAL']).']';
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
					<?php } else if(isset($_REQUEST['desa']) ) { ?>
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
					<?php } else { ?>
						title: {
							text: ''
						},
						categories: [
							<?php
								$arr1 = array();
								foreach ($panen_group as $pg) {
									$arr1[] = '"DESA '.$pg['nama_desa'].'"';
								}
								$arr1data = implode(",", $arr1);
								echo $arr1data; 
							?>
						]
					<?php } ?>
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
					colorByPoint: true,
					dataLabels: {
						enabled: true,
						format: '{point.y:.2f} ton'
					}
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
					<?php } else if(isset($_REQUEST['dusun']) ) { ?>
						<?php
							$arr2 = array();
							foreach ($panen_group as $pg) {
								$arr2[] = '["SAWAH '.($pg['pemilik'] != null ? $pg['pemilik'] : 'Pemilik tidak diketahui').'",'.ton2($pg['TOTAL']).']';
							}
							$arr2data = implode(",", $arr2);
							echo $arr2data; 
						?>
					<?php } else { ?>
						<?php
							$arr2 = array();
							foreach ($panen_group as $pg) {
								$arr2[] = '["DESA '.$pg['nama_desa'].'",'.ton2($pg['TOTAL']).']';
							}
							$arr2data = implode(",", $arr2);
							echo $arr2data; 
						?>
					<?php } ?>
				]
				}]
			});
		}

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
				tooltip: {
					pointFormat: '{series.name}: <b>{point.y:.2f} ton</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						showInLegend: true,
						innerSize: 100,
						depth: 45,
						colors: ['#42b649', '#b6d434', '#fbde08', '#f15f23', '#ed1e28'],
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.y:.2f} ton'
						}
					}
				},
				series: [{
					type: 'pie',
					name: 'Jumlah Distribusi',
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
					categories: [
							<?php
								$arr1 = array();
								foreach ($distribusi_group as $pg) {
									$arr1[] = '" '.$pg['jenis'].'"';
								}
								$arr1data = implode(",", $arr1);
								echo $arr1data; 
							?>
						]
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
					colorByPoint: true,
					dataLabels: {
						enabled: true,
						format: '{point.y:.2f} ton'
					}
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

			// $('#chart').removeAttr('hidden');
		}

		function grafikTypeAnalisa() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chartAnalisa',
					type: 'spline'
				},
				title: 0,
				xAxis: {
					title: {
						text: 'Tahun'
					},
					categories: ['2015','2016','2017','2018','2019','2020','2021','2022']
			},
			yAxis: {
				title: {
					text: 'Stok Gabah (Ton)'
				}
			},

			legend: {
				align: 'center',
				verticalAlign: 'bottom',
				x: 0,
				y: 0
			},

			plotOptions: {
				series: {
					label: {
						connectorAllowed: false
					},
					pointStart: 2015
				}
			},
			series: [
				{
					name: 'Stok Gabah',
					color: '#42b649',
					data: [
						['2015',1],
						['2016',1.1],
						['2017',1.15],
						['2018',1.2],
						['2019',1.35],
						['2020',1.4],
						['2021',1.48],
						['2022',1.35],
					]
				},
				{
					name: 'Kebutuhan Pangan',
					color: '#e62118',
					data: [.8, .9, 0.95, 1, 1.1, 1.2, 1.15, 1.25]
				}]
			});

			// $('#chart').removeAttr('hidden');
		}
	<?php } ?>
</script>

</body>
</html>