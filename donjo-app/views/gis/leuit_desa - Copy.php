<?php if($leuitLokasi) { ?>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-4">
				<?php foreach ($leuitLokasi as $leuit) : ?>
					<div class="image-modal-top" style="">
						<?php
							if ($leuit['foto']) {
								$fotoLeuit = base_url().LOKASI_FOTO_LOKASI.''.$leuit['foto'];
							} else {
								$fotoLeuit = base_url() . 'assets/files/user_pict/kuser.png';
							}

							$alamat = $leuit['nama_jalan'].' RT '.$leuit['rt'].' RW '.$leuit['rw'].' Dusun '.$leuit['dusun'];
						?>
						<img src="<?= $fotoLeuit ?>" alt="" style="">
					</div>
				<?php endforeach; ?>
			</div>
			<div class="col-md-8">
				<?php foreach ($leuitLokasi as $leuit) : ?>
					<table class="">
						<tr>
							<td>Lokasi</td>
							<td><?= $alamat; ?></td>
						</tr>
						<tr>
							<td>Volume</td>
							<td><?= convertmass($leuit['volume']); ?></td>
						</tr>
						<tr>
							<td>Tingkat Kekeringan</td>
							<td><?= $leuit['tingkat_kekeringan']; ?>%</td>
						</tr>
					</table>
					<hr>
					<a href="javascript:;" class="trigger-stat d-none" onclick="loadStat(<?= $leuit['id']; ?>);">Stats</a>
					<input type="hidden" id="inputIdDesa" value="<?= $leuit['id']; ?>">
					<input type="hidden" class="form-control" id="inputUrl" value="/first/loadModalLeuitStat/<?= $leuit['id']; ?>?">
					<input type="hidden" class="form-control" id="inputYear" value="">
					<input type="hidden" class="form-control" id="inputDusun" value="">
					<input type="hidden" class="form-control" id="inputSawah" value="">
				<?php endforeach; ?>
				
				<!-- <div class="form-inline">
					<div class="form-group">
						<div class="checkbox-custom">
							<input type="checkbox" name="checkTahunan" class="styled-checkbox" id="checkTahunan" <?php echo (isset($_REQUEST['ts']) ? 'checked' : ''); ?>>
							<label for="checkTahunan">Grafik Semua Tahun</label>
						</div>
					</div>
					<div class="form-group">
						<div class="grouphide">
							<select class="form-control input-sm" name="filterTahun" data-param="year" id="filterTahun">
								<option value="0">Semua Tahun</option>
								<option value="2021">Tahun 2021</option>
								<option value="2022">Tahun 2022</option>
							</select>
						</div>
					</div>
					<div class='form-group'>
						<select class="form-control input-sm select2" name="filterDusun" data-param="dusun" id="filterDusun">
							<option value="">Pilih <?= ucwords($this->setting->sebutan_dusun) ?></option>
							<?php foreach ($dusun as $data) : ?>
								<option value="<?= $data['id'] ?>" <?php selected($lokasi['dusun'], $data['dusun']) ?>><?= $data['dusun'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<div class="grouphide">
							<select class="form-control input-sm" name="sawah" data-param="sawah" id="filterSawah">
								<option value="0">Semua Sawah</option>
								<?php foreach ($list_sawah as $sawah) : ?>
									<option value="<?= $sawah['id'] ?>"><?= $sawah['pemilik'] ?> (<?= number_format($sawah['luas'], 2) ?> m<span class="superscript">2</span>)</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<hr> -->
				<div class="row">
					<div class="col-md-12">
						<div class="d-flex justify-content-center mb-3">
							<div class="tabs active" id="tab01">
								<h6 class="font-weight-bold">Input</h6>
							</div>
							<div class="tabs" id="tab02">
								<h6 class="text-muted">Output</h6>
							</div>
							<div class="tabs" id="tab03">
								<h6 class="text-muted">Analisa</h6>
							</div>
						</div>
					</div>
				</div>
				<div class="loading p-5" style="display: none;">
					<img src="<?php echo base_url() . 'assets/images/loader.gif'?>" alt="">
				</div>

				<div id="tab011" class="tab-content show">
					<div id="leuitStat"></div>
				</div>

				<div id="tab021" class="tab-content">
					<h5 class="box-title text-center mt-3">
						Data Output Gabah
					</h4>

					<div class="row">
						<div class="col-sm-12">
							<div class="text-center">
								<span class="btn btn-default ">
									Total Output : <strong>0.25 Ton</strong>
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
					<h5 class="box-title text-center mt-3">
						Analisa
					</h4>

					<div class="row" style="margin-top: 30px;">
						<div class="col-md-12">
							<div id="chartAnalisa"> </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function loadStat(desaid) {
		$('.loading').show();
		var url = $('#inputUrl').val();
		var year = $('#inputYear').val();
		var dusun = $('#inputDusun').val();
		var sawah = $('#inputSawah').val();
		$.get( url+year+dusun+sawah, function( data ) {
			$('#leuitStat').html(data);
			$('#inputUrl').val(url);
			setTimeout(
			function() {
				$('#leuitStat').fadeIn();
				$('.loading').hide();
			}, 1000);
		});
	}
	$(document).ready(function () {
		$('#filterTahun, #filterSawah, #filterDusun').select2();
		var idDesa = $('#inputIdDesa').val();
		var inputUrl = $('#inputUrl').val();
		$('.trigger-stat').trigger('click');

		$('#checkTahunan').change(function() {
			$('#leuitStat').fadeOut();
			var inputUrl = $('#inputUrl').val();
			if(this.checked) {
				$('#inputUrl').val(inputUrl+"&ts=1");
				loadStat(idDesa);
				$('#inputYear, #inputSawah, #inputDusun').val('');
				$('#filterTahun, #filterSawah, #filterDusun').val('0');
				$('#filterTahun, #filterSawah, #filterDusun').trigger('change');
				$('.grouphide').hide();
			} else {
				var str = inputUrl.replace("&ts=1", "");
				$('#inputUrl').val(str);
				loadStat(idDesa);
				$('.grouphide').show();
			}
		});

		$("#filterTahun").on('change', function (e) {
			$('#leuitStat').fadeOut();
			var val = $(this).val();
			if(val != 0) {
				$('#inputYear').val("&year="+val);
				loadStat(idDesa);
			} else {
				$('#inputYear').val('');
				loadStat(idDesa);
			}
		});

		$("#filterDusun").on('change', function (e) {
			$('#leuitStat').fadeOut();
			var val = $(this).val();
			if(val != 0) {
				$('#inputDusun').val("&dusun="+val);
				loadStat(idDesa);
			} else {
				$('#inputDusun').val('');
				loadStat(idDesa);
			}
		});

		$("#filterSawah").on('change', function (e) {
			$('#leuitStat').fadeOut();
			var val = $(this).val();
			if(val != 0) {
				$('#inputSawah').val("&sawah="+val);
				loadStat(idDesa);
			} else {
				$('#inputSawah').val('');
				loadStat(idDesa);
			}
		});

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
		pieTypeOutput();
		grafikTypeAnalisa();
	});

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
                name: 'Jumlah Input',
				shadow:1,
				border:1,
                data: [
					['Produksi',0.05],
					['Distribusi/Logistik',0.05],
					['Komersil',0.1],
				]
            }]
        });
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
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle'
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
</script>
<?php } else { ?>
	<p class="my-5 text-center">Belum ada data</p>
<?php } ?>