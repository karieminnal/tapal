<?php

defined('BASEPATH') or exit('No direct script access allowed');

?>

<div class="modal-body">
	<form id="mainform" name="mainform" action="" method="post">
		<input type="hidden" id="untuk_web" value="<?= $untuk_web ?>">
		<div class="row">
			<div class="col-md-12">
				<h4 class="box-title text-center"><b>Data Kependudukan Menurut <?= ($stat); ?></b></h4>
				<div class="text-center">
					<a class="btn btn-flat btn-sm" title="Grafik Data" onclick="grafikType();"><i class="fa fa-bar-chart"></i> Grafik Data</a>
					<a class="btn btn-flat btn-sm" title="Pie Data" onclick="pieType();"><i class="fa fa-pie-chart"></i> Pie Data</a>
				</div>
				<hr>
				<div id="chart" hidden="true"> </div>
				<div class="table-responsive table-statistik">
					<table class="table table-bordered dataTable table-hover nowrap">
						<thead>
							<tr>
								<th class="padat">No</th>
								<th nowrap>Jenis Kelompok</th>
								<?php if ($lap < 20 or ($lap > 50 and $program['sasaran'] == 1)) : ?>
									<th nowrap colspan="2">Laki-Laki</th>
									<th nowrap colspan="2">Perempuan</th>
								<?php endif; ?>
								<th nowrap colspan="2">Jumlah</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($main as $data) : ?>
								<?php if ($lap > 50) $tautan_jumlah = site_url("program_bantuan/detail/1/$lap/1"); ?>
								<tr>
									<td class="text-center"><?= $data['no'] ?></td>
									<td class="text-left"><?= strtoupper($data['nama']); ?></td>
									<?php if ($lap < 20 or ($lap > 50 and $program['sasaran'] == 1)) : ?>
										<?php if ($lap < 50) $tautan_jumlah = site_url("penduduk/statistik/$lap/$data[id]"); ?>
										<td class="text-right"><?= $data['laki'] ?></td>
										<td class="text-right"><?= $data['persen1']; ?></td>
										<td class="text-right"><?= $data['perempuan'] ?></td>
										<td class="text-right"><?= $data['persen2']; ?></td>
									<?php endif; ?>
									<td class="text-right">
										<?php if (in_array($lap, array(21, 22, 23, 24, 25, 26, 27))) : ?>
											<?= $data['jumlah'] ?>
										<?php else : ?>
											<?php if ($lap < 50) $tautan_jumlah = site_url("penduduk/statistik/$lap/$data[id]"); ?>
											<?= $data['jumlah'] ?>
										<?php endif; ?>
									</td>
									<td class="text-right"><?= $data['persen']; ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	$('document').ready(function() {
		// Nonaktfikan tautan di tabel statistik kependudukan untuk tampilan Web
		if ($('#untuk_web').val() == 1) {
			$('tbody a').removeAttr('href');
		}
	});

	var chart;

	function grafikType() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'chart',
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
					text: '<?= $stat ?>'
				},
				categories: [
					<?php $i = 0;
					foreach ($main as $data) : $i++; ?>
						<?php if ($data['jumlah'] != "-") : ?><?= "'$i',"; ?><?php endif; ?>
					<?php endforeach; ?>
				]
			},
			yAxis: {
				title: {
					text: 'Jumlah Populasi'
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
				shadow: 1,
				border: 1,
				data: [
					<?php foreach ($main as $data) : ?>
						<?php if (!in_array($data['nama'], array("TOTAL", "JUMLAH", "PENERIMA"))) : ?>
							<?php if ($data['jumlah'] != "-") : ?>['<?= strtoupper($data['nama']) ?>', <?= $data['jumlah'] ?>],
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				]
			}]
		});

		$('#chart').removeAttr('hidden');
	}

	function pieType() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'chart',
				type: 'pie',
				options3d: {
					enabled: true,
					alpha: 45
				},
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title: 0,
			plotOptions: {
				// index: {
				// 	allowPointSelect: true,
				// 	cursor: 'pointer',
				// 	innerSize: 100,
				// 	depth: 45,
				// 	dataLabels: {
				// 		enabled: true
				// 	},
				// 	showInLegend: true
				// },
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					showInLegend: true,
					innerSize: 100,
					depth: 45,
					colors: ['#42b649', '#b6d434', '#fbde08', '#f15f23', '#ed1e28']
				}
			},
			legend: {
				layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'right',
				verticalAlign: 'top',
				x: -30,
				y: 0,
				floating: true,
				shadow: true,
				enabled: true
			},
			series: [{
				type: 'pie',
				name: 'Populasi',
				data: [
					<?php foreach ($main as $data) : ?>
						<?php if (!in_array($data['nama'], array("TOTAL", "JUMLAH", "PENERIMA"))) : ?>
							<?php if ($data['jumlah'] != "-") : ?>["<?= strtoupper($data['nama']) ?>", <?= $data['jumlah'] ?>],
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				]
			}]
		});

		$('#chart').removeAttr('hidden');
	}
</script>
<script src="<?= base_url() ?>assets/js/highcharts/exporting.js"></script>
<script src="<?= base_url() ?>assets/js/highcharts/highcharts-more.js"></script>