<div class="content-wrapper">
	<section class="content-header">
		<h1>Analisa Leuit <?= ucwords($this->setting->sebutan_desa) ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Analisa Leuit</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="box box-info">
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
									<!-- <form id="mainform" name="mainform" action="" method="post">
										<div class="row">
											<div class="col-md-9">
												
												<select class="form-control input-sm" name="">
													<option value="">Semua Tahun</option>
													<option value="2022" selected>Tahun 2022</option>
												</select>
												<span class="btn btn-primary btn-sm">
													Total Panen : <strong>1,350 Kg</strong>
												</span>
												<span class="btn btn-info btn-sm">
													Biaya : <strong>Rp 6,750,000</strong>
												</span>
											</div>
											<div class="col-sm-3">
											</div>
										</div>
									</form> -->

									<div class="row" style="margin-top: 30px;">
										<div class="col-md-12">
											<div id="chart"> </div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var chart;
		// function grafikType() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chart',
					type: 'spline'
					// defaultSeriesType: 'column'
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
		// }
	});
</script>