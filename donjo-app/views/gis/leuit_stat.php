<?php if($leuit_panen) { ?>

	<h5 class="box-title text-center mt-3">
		Data Input Gabah 
		<?php if (isset($_REQUEST['dusun'])) {
			echo 'DUSUN '. $leuit_panen[0]['dusun'] . ' ';
		} ?>
		<?php if (isset($_REQUEST['sawah'])) {
			echo 'Sawah '. $leuit_panen[0]['pemilik'] . ' ';
		} ?>
		<?php if (isset($_REQUEST['year'])) {
			$getTgl = $panen_group[0]['tanggal_produksi'];
			$getThn = date('Y', strtotime($getTgl));
			echo 'Tahun '. $getThn . ' ';
		} ?>
	</h4>

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
				<a class="btn btn-sm" title="Pie Data" onclick="pieType();"><i class="fa fa-pie-chart"></i> Pie Data&nbsp;&nbsp;</a>
				<a class="btn btn-sm" title="Grafik Data" onclick="grafikType();"><i class="fa fa-bar-chart"></i> Grafik Data&nbsp;&nbsp;</a>
			</div>
			<div id="chart"> </div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive table-statistik">
				<!-- <table class="table table-bordered table-striped dataTable table-hover loading-table" id="tablePanenList">
					<thead class="bg-gray disabled color-palette">
						<tr>
							<th class="no-sort">No</th>
							<th>Tanggal Input</th>
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
				</table> -->
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function () {
			pieType();
		});
			
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
								$arr2[] = '["Dusun '.$pg['dusun'].'",'.ton2($pg['TOTAL']).']';
							}
							$arr2data = implode(",", $arr2);
							echo $arr2data; 
						?>
					<?php } ?>
				]
				}]
			});
		}

		function pieType() {
			// Build the chart
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chart',
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
									$arr2[] = '["SAWAH '.($pg['pemilik'] != null ? $pg['pemilik'] : 'Pemilik tidak diketahui').'",'.ton2($pg['TOTAL']).']';
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
	</script>

<?php } else { ?>
	<p class="my-5 text-center">Belum ada data</p>
<?php } ?>