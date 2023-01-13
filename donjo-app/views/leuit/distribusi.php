<div class="content-wrapper">
	<section class="content-header">
		<h1>Daftar Distribusi <?= ucwords($this->setting->sebutan_desa) ?> <?= $desa["nama_desa"]; ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Daftar Distribusi</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<div class="row">
							<div class="col-sm-12">
								<a href="<?= site_url("leuit_distribusi/form") ?>" class="btn btn-success btn-sm" title="">
									<i class="fa fa-plus"></i> Tambah Data
								</a>
							</div>
						</div>
					</div>
					<div class="box-body">
						<h4 class="box-title text-center">
							Data Distribusi Gabah <?= ucwords($this->setting->sebutan_desa) ?> <?= $desa["nama_desa"]; ?> <span></span>
						</h4>
						<div class="row">
							<div class="col-sm-12">
								<div class="dataTables_wrapper form-inline dt-bootstrap no-footer mt-3">
									<form id="mainform" name="mainform" action="" method="post">
										<div class="row">
											<div class="col-md-6">
												<!-- <div class="form-group">
													<div class="checkbox-custom">
														<input type="checkbox" name="checkTahunan" class="styled-checkbox" id="checkTahunan" <?php echo (isset($_REQUEST['ts']) ? 'checked' : ''); ?>>
														<label for="checkTahunan">Grafik Semua Tahun</label>
													</div>
												</div> -->
												<?php if (!isset($_REQUEST['ts'])) { ?>
													<!-- <div class="form-group">
														<select class="form-control input-sm select2" name="filterTahun" data-param="year" id="filterTahun">
															<option value="0">Semua Tahun</option>
															<?php foreach ($distribusi_get_tahun as $tahun) {
																	$getTgl = $tahun['tanggal_distribusi'];
																	$getThn = date('Y', strtotime($getTgl));
																?>
																<option value="<?php echo $getThn ?>">Tahun <?php echo $getThn ?></option>
															<?php } ?>
														</select>
													</div> -->
												<?php } ?>
											</div>
											<?php if($leuit_distribusi) { ?>
												<div class="col-sm-6">
													<div class="text-right">
														<span class="btn btn-default ">
															Total Distribusi : <strong><?= ton($total_distribusi['TOTAL_ALL']) ?></strong>
														</span>
													</div>
												</div>
											<?php } ?>
										</div>
									</form>
									
									<?php if($leuit_distribusi) { ?>
										<div class="row" style="margin-top: 30px;">
											<div class="col-md-12">
												<div class="text-center">
													<a class="btn btn-sm" title="Pie Data" onclick="pieType();">
														<i class="fa fa-pie-chart"></i> Pie Data
													</a>
													<a class="btn btn-sm" title="Grafik Data" onclick="grafikType();">
														<?php if (isset($_REQUEST['ts'])) { ?>
															<i class="fa fa-line-chart"></i> Line Data
														<?php } else { ?>
															<i class="fa fa-bar-chart"></i> Grafik Data
														<?php } ?>
													</a>
												</div>
												<div id="chart"> </div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="table-responsive">
													<table class="table table-bordered table-striped dataTable table-hover">
														<thead class="bg-gray disabled color-palette">
															<tr>
																<th>No</th>
																<th></th>
																<th>Tanggal Distribusi</th>
																<th>Kebutuhan</th>
																<th>Jumlah</th>
																<th>Harga</th>
																<th>Ditambahkan</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($leuit_distribusi as $distribusi) : ?>
																<tr>
																	<td><?= $distribusi['no'] ?></td>
																	<td>
																		<a href="<?= site_url("leuit_distribusi/form/$distribusi[id]") ?>" class="btn bg-orange btn-flat btn-sm" title="Ubah Data">
																			<i class="fa fa-edit"></i>
																		</a>
																		<a href="javascript:;" data-href="<?= site_url("leuit_distribusi/delete/$distribusi[id]") ?>" class="btn btn-danger btn-flat btn-sm" title="Hapus" data-toggle="modal" data-target="#confirm-delete">
																			<i class="fa fa-trash"></i> Hapus
																		</a>
																	</td>
																	<td><?= tgl_indo_out($distribusi['tanggal_distribusi']) ?></td>
																	<td><?= $distribusi['jenis'] ?></td>
																	<td><?= ton($distribusi['jumlah_distribusi']) ?></td>
																	<td><?= rupiah24($distribusi['harga']) ?></td>
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
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php $this->load->view('global/confirm_delete'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		var termTahun = GetURLParameter('year');
		if (typeof termTahun  !== "undefined") {
			$('#filterTahun').val(termTahun);
		}

		var $thisSelect = $(".select2");
		$thisSelect.on('change', function (e) {
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
			
		// $('#textbox1').val(this.checked);
		$('#checkTahunan').change(function() {
			var pag = window.location.pathname;
			if(this.checked) {
				window.location.href = pag+"?ts=1";
				console.log('cek');
			} else {
				window.location.href = pag;
				console.log('uncek');
			}
			// $('#textbox1').val(this.checked);      
		});
		var chart;
		pieType();
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
				<?php if (isset($_REQUEST['ts'])) { ?>
					title: {
						text: 'Tahun'
					},
					categories: [
						<?php
							$arr1 = array();
							foreach ($distribusi_group as $pg) {
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
							foreach ($distribusi_group as $pg) {
								$arr1[] = '" '.$pg['jenis'].'"';
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
						foreach ($distribusi_group as $pg) {
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
						foreach ($distribusi_group as $pg) {
							$arr2[] = '[" '.$pg['jenis'].'",'.ton2($pg['TOTAL']).']';
						}
						$arr2data = implode(",", $arr2);
						echo $arr2data; 
					?>
				<?php } ?>
			]
			}]
		});

		// $('#chart').removeAttr('hidden');
	}
	
	function pieType() {
    	// Build the chart
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart',
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
                name: 'Jumlah',
				shadow:1,
				border:1,
                data: [
					<?php if (isset($_REQUEST['ts'])) { ?>
						<?php
							$arr2 = array();
							foreach ($distribusi_group as $pg) {
								$getTgl = $pg['tanggal_produksi'];
								$getThn = date('Y', strtotime($getTgl));
								$getBln = getBulan(date('n', strtotime($getTgl)));
								$arr2[] = '["'.$getThn.'",'.ton2($pg['TOTAL']).']';
							}
							$arr2data = implode(",", $arr2);
							echo $arr2data; 
						?>
					<?php } else { ?>
						<?php
							$arr2 = array();
							foreach ($distribusi_group as $pg) {
								$arr2[] = '["'.$pg['jenis'].'",'.ton2($pg['TOTAL']).']';
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