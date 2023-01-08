<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
	tr.lebih{
		display:none;
	}
</style>
<div class="modal-body">
	<form id="mainform" name="mainform" action="" method="post">
		<input type="hidden" id="untuk_web" value="<?= $untuk_web ?>">
		<div class="row">
			<div class="col-md-12">
				<h4 class="box-title text-center"><b>Data Kependudukan Menurut <?= $heading; ?></b></h4>
				<center>
					<a class="btn btn-social btn-flat bg-navy btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Grafik Data" onclick="grafikType();"><i class="fa fa-bar-chart"></i>&nbsp;&nbsp;Grafik Data&nbsp;&nbsp;</a>
					<a class="btn btn-social btn-flat bg-navy btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Pie Data" onclick="pieType();"><i class="fa fa-pie-chart"></i>&nbsp;&nbsp;Pie Data&nbsp;&nbsp;</a>
				</center>
				<hr>
				<div id="chart" hidden="true"> </div>
				<div class="table-responsive table-statistik">
					<table class="table table-bordered dataTable table-hover nowrap">
						<thead>
							<tr>
								<th rowspan="2" style="vertical-align: middle;">No</th>
								<th rowspan="2" style='vertical-align: middle;text-align:left;'>Kelompok</th>
								<th colspan="2" style='text-align:center;'>Jumlah</th>
								<?php if($jenis_laporan == 'penduduk'){ ?>
									<th colspan="2" style='text-align:center;'>Laki-laki</th>
									<th colspan="2" style='text-align:center;'>Perempuan</th>
								<?php } ?>
							</tr>
							<tr>
								<th style='text-align:right'>n</th>
								<th style='text-align:right'>%</th>
								<?php if($jenis_laporan == 'penduduk'){ ?>
									<th style='text-align:right'>n</th><th style='text-align:right'>%</th>
									<th style='text-align:right'>n</th><th style='text-align:right'>%</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
						<?php
							$i=0; $l=0; $p=0;
							$hide="";$h=0;
							$jm = count($stat);
							foreach($stat as $data) { 
								$h++;
								if($h > 10 AND $jm > 11)$hide="lebih";
							?>
								<tr class="<?= $hide ?>">
									<td class="angka"><?= $data['no'] ?></td>
									<td><?= $data['nama'] ?></td>
									<td class="angka" style='text-align:right'><?= $data['jumlah'] ?></td>
									<td class="angka" style='text-align:right'><?= $data['persen'] ?></td>
							<?php if($jenis_laporan == 'penduduk'){ ?>
								<td class="angka" style='text-align:right'><?= $data['laki'] ?></td>
								<td class="angka" style='text-align:right'><?= $data['persen1'] ?></td>
								<td class="angka" style='text-align:right'><?= $data['perempuan'] ?></td>
								<td class="angka" style='text-align:right'><?= $data['persen2'] ?></td>
							<?php } ?>
							</tr>
							<?php
								$i=$i+$data['jumlah'];
								$l=$l+$data['laki']; 
								$p=$p+$data['perempuan'];
							?>
						<?php } ?>
						</tbody>
					</table>
					<?php
						if($hide=="lebih"){ ?>
						<div style='margin-left:20px;'>
							<button class='uibutton special' id='showData'>Selengkapnya...</button>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
$(function(){
	$('#showData').click(function(){
		$('tr.lebih').show();
		$('#showData').hide();
	});
});
</script>
<script type="text/javascript">
    var chart;

	function grafikType() {
        chart = new Highcharts.Chart({
            chart: { renderTo: 'chart'},
            title:0,
					xAxis: {
                        categories: [
						<?php  $i=0;foreach($stat as $data){$i++;?>
						  <?php if($data['jumlah'] != "-" AND $data['nama']!= "TOTAL" AND $data['nama']!= "JUMLAH"){echo "'$i',";}?>
						<?php }?>
						]
					},
				plotOptions: {
					series: {
						colorByPoint: true
					},
					column: {
						pointPadding: -0.1,
						borderWidth: 0
					}
				},
					legend: {
                        enabled:false
					},
            series: [{
                type: 'column',
                name: 'Jumlah',
				shadow:1,
				border:1,
                data: [
						<?php  foreach($stat as $data){?>
							<?php if($data['jumlah'] != "-" AND $data['nama']!= "TOTAL" AND $data['nama']!= "JUMLAH"){?>
								['<?php echo $data['nama']?>',<?php echo $data['jumlah']?>],
							<?php }?>
						<?php }?>
                ]
            }]
        });

		$('#chart').removeAttr('hidden');
	}

	function pieType() {
    	// Build the chart
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart'
            },
            title:0,
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Jumlah',
				shadow:1,
				border:1,
                data: [
						<?php  foreach($stat as $data){?>
							<?php if($data['jumlah'] != "-" AND $data['nama']!= "TOTAL" AND $data['nama']!= "JUMLAH"){?>
								['<?php echo $data['nama']?>',<?php echo $data['jumlah']?>],
							<?php }?>
						<?php }?>
                ]
            }]
        });

		$('#chart').removeAttr('hidden');
	}

    $(document).ready(function () {

    	// Build the chart
        pieType();
    });
</script>
<script src="<?= base_url() ?>assets/js/highcharts/exporting.js"></script>
<script src="<?= base_url() ?>assets/js/highcharts/highcharts-more.js"></script>