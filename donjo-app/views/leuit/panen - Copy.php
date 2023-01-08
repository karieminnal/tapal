<div class="content-wrapper">
	<section class="content-header">
		<h1>Daftar Input <?= ucwords($this->setting->sebutan_desa) ?> <?= $desa["nama_desa"]; ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Daftar Input</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<div class="row">
							<div class="col-sm-12">
								<a href="<?= site_url("leuit_panen/form") ?>" class="btn btn-social btn-flat btn-success btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Import Sawah">
									<i class="fa fa-plus"></i> Tambah Data
								</a>
							</div>
						</div>
					</div>
					<div class="box-body">
						<h4 class="box-title text-center">
							Data Input Gabah <?= ucwords($this->setting->sebutan_desa) ?> <?= $desa["nama_desa"]; ?> <span></span>
						</h4>
						<div class="row">
							<div class="col-sm-12">
								<div class="dataTables_wrapper form-inline dt-bootstrap no-footer mt-3">
									<form id="mainform" name="mainform" action="" method="post">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<div class="checkbox-custom">
														<input type="checkbox" name="checkTahunan" class="styled-checkbox" id="checkTahunan" <?php echo (isset($_REQUEST['ts']) ? 'checked' : ''); ?>>
														<label for="checkTahunan">Grafik Semua Tahun</label>
													</div>
												</div>
												<?php if (!isset($_REQUEST['ts'])) { ?>
													<div class="form-group">
														<select class="form-control input-sm select2" name="filterTahun" data-param="year" id="filterTahun">
															<option value="0">Semua Tahun</option>
															<?php foreach ($panen_get_tahun as $tahun) {
																	$getTgl = $tahun['tanggal_produksi'];
																	$getThn = date('Y', strtotime($getTgl));
																?>
																<option value="<?php echo $getThn ?>">Tahun <?php echo $getThn ?></option>
															<?php } ?>
														</select>
													</div>
													<div class='form-group'>
														<select class="form-control input-sm select2" name="filterDusun" data-param="dusun" id="filterDusun">
															<option value="">Semua <?= ucwords($this->setting->sebutan_dusun) ?></option>
															<?php foreach ($dusun as $data) : ?>
																<option value="<?= $data['id'] ?>" <?php selected($lokasi['dusun'], $data['dusun']) ?>><?= $data['dusun'] ?></option>
															<?php endforeach; ?>
														</select>
													</div>
													<!-- <div class="form-group">
														<select class="form-control input-sm select2" name="sawah" data-param="sawah" id="filterSawah">
															<option value="0">Semua Sawah</option>
															<?php foreach ($list_sawah as $sawah) : ?>
																<option value="<?= $sawah['id'] ?>"><?= $sawah['pemilik'] ?> (<?= number_format($sawah['luas'], 2) ?> Ha)</option>
															<?php endforeach; ?>
														</select>
													</div> -->
												<?php } ?>
											</div>
											<div class="col-sm-6">
												<div class="text-right">
													<span class="btn btn-default ">
														Total Input : 
														<?php foreach ($total_produksi as $tp) : ?>
															<strong><?= ton($tp['TOTAL_ALL']) ?></strong>
														<?php endforeach; ?>
													</span>
													<!-- <span class="btn btn-info">
														Biaya : <strong>Rp 6,750,000</strong>
													</span> -->
												</div>
											</div>
										</div>
									</form>

									<?php if($leuit_panen) { ?>
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
													<table class="table table-bordered table-striped dataTable table-hover loading-table" id="tablePanenList">
														<thead class="bg-gray disabled color-palette">
															<tr>
																<th class="no-sort">No</th>
																<th class="no-sort"></th>
																<th>Tanggal Panen</th>
																<th>Dusun</th>
																<th>Sawah</th>
																<th>Jumlah Panen</th>
																<th>Harga / Kg</th>
																<th>Total</th>
																<th class="no-sort">Ditambahkan</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($leuit_panen as $produksi) : ?>
																<tr>
																	<td><?= $produksi['no'] ?></td>
																	<td>
																		<a href="<?= site_url("leuit_panen/form/$produksi[id]") ?>" class="btn bg-orange btn-flat btn-sm" title="Ubah Data">
																			<i class="fa fa-edit"></i>
																		</a>
																		<a href="#" data-href="<?= site_url("leuit_panen/delete/$produksi[id]") ?>" class="btn bg-maroon btn-flat btn-sm" title="Hapus" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>
																	</td>
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
										<!-- <?php $this->load->view('global/paging'); ?> -->
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

			var termDusun = GetURLParameter('dusun');
			if (typeof termDusun !== "undefined") {
				$('#filterDusun').val(termDusun);
			}

			var $sawahSelect = $(".select2");
			$sawahSelect.on('change', function (e) {
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
			var termSawah = GetURLParameter('sawah');
			if (typeof termSawah !== "undefined") {
				$('#filterSawah').val(termSawah);
				// $("#filterSawah").val(termSawah).trigger('change');
			}

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
		<?php if($leuit_panen) { ?>
			var chart;
			pieType();
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
	
	function grafikType() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'chart',
				<?php if (isset($_REQUEST['ts'])) { ?>
					type: 'spline',
				<?php } else { ?>
					defaultSeriesType: 'column',
					options3d: {
						enabled: true,
						alpha: 15,
						beta: 15,
						depth: 50,
						viewDistance: 25
					}
				<?php } ?>
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
				<?php } else if (isset($_REQUEST['dusun'])) { ?>
					title: {
						text: ''
					},
					categories: [
						<?php
							$arr1 = array();
							foreach ($panen_group as $pg) {
								$arr1[] = '"Sawah '.$pg['pemilik'].'"';
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
			<?php if (isset($_REQUEST['ts'])) { ?>
				series: {
					label: {
						connectorAllowed: false
					},
					pointStart: 2015
				},
				spline: {
					dataLabels: {
						enabled: true
					},
					// enableMouseTracking: false
				}
			<?php } else { ?>
				series: {
					colorByPoint: true,
					dataLabels: {
						enabled: true,
						format: '{point.y:.1f} ton'
					}
				},
				column: {
					pointPadding: 0,
					borderWidth: 0,
					colors: ['#42b649', '#b6d434', '#fbde08', '#f15f23', '#ed1e28']
				}
			<?php } ?>
		},
		series: [{
			shadow:1,
			border:1,
			name: 'Jumlah',
			colorByPoint: true,
			<?php if (isset($_REQUEST['ts'])) { ?>
				color: '#42b649',
			<?php } ?>
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
				<?php } else if (isset($_REQUEST['dusun'])) { ?>
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
				pointFormat: '{series.name}: <b>{point.y:.1f} ton</b>'
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
						format: '<b>{point.name}</b>: {point.y:.1f} ton'
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
					<?php } else if (isset($_REQUEST['dusun'])) { ?>
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
</script>

							

