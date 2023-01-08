<?php

defined('BASEPATH') or exit('No direct script access allowed');

?>

<div id="isi_popup" style="visibility: hidden;">
	<div id="content">
		<h5 id="firstHeading" class="firstHeading">
			Wilayah <?= set_ucwords($wilayah); ?>
		</h5>
		<div id="bodyContent" class="hide-on-tooltip">
			<p>
				<a href="<?= site_url("first/load_aparatur_desa"); ?>" class="btn btn-sm btn-outline-primary btn-block" data-title="Aparatur <?= ucwords($this->setting->sebutan_desa) ?>" data-remote="false" data-toggle="modal" data-target="#modalAparatur">
					<i class="fa fa-user"></i>
					Aparatur <?= ucwords($this->setting->sebutan_desa) ?>
				</a>
			</p>
			<div class="statistik-penduduk-popup">
				<div class="dropright">
					<a class="btn btn-sm btn-outline-primary btn-block dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" data-offset="-100" aria-expanded="false">
						<i class="fa fa-bar-chart"></i> Lihat Statistik
					</a>
					<ul class="dropdown-menu">
						<?php foreach ($list_lap_front as $key => $value) : ?>
							<li <?= jecho($lap, $key, 'class="active"'); ?>>
								<a href="<?= site_url("statistik_web/chart_gis_desa/$key/" . underscore($desa[nama_desa])); ?>" data-remote="false" data-toggle="modal" data-target="#modalBesar" data-title="Statistik Penduduk <?= set_ucwords($wilayah) ?>">
									<?= $value ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<!-- 
			<p>
				<a href="<?= site_url("first/load_apbdes"); ?>" class="btn btn-sm" data-title="Laporan APBDES 2019 - Grafik" data-remote="false" data-toggle="modal" data-target="#modalSedang">
					<i class="fa fa-bar-chart"></i> Grafik Keuangan
				</a>
			</p>
			 -->
		</div>
	</div>
</div>