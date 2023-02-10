<?php

defined('BASEPATH') or exit('No direct script access allowed');

?>

	<div id="content">
		<h5 id="firstHeading" class="firstHeading">
			<?= set_ucwords($wilayah); ?>
		</h5>
		<div id="bodyContent" class="hide-on-tooltip">
			<div class="text-center">
				<!-- <p>
					<?php 
						$totpend = $this->config_model->penduduk_total($desa['id']);
					?>
					<?php foreach ($totpend as $total) : ?>
						<span id="totalPenduduk" value=""><?= $total['jumlah'] ?></span>
					<?php endforeach; ?> Penduduk
				</p> -->
			</div>
			<p>
				<a href="<?= site_url("first/loadModalProfil/$desa[id]"); ?>" class="btn btn-sm btn-outline-primary btn-block" 
					data-title="Profil <?= ucwords($this->setting->sebutan_desa) ?> <?= set_ucwords($wilayah) ?>" 
					data-remote="false" 
					data-toggle="modal" 
					data-target="#modalBesar">
					<i class="fa fa-building"></i>
					Profil <?= ucwords($this->setting->sebutan_desa) ?>
				</a>
			</p>
			<div class="statistik-penduduk-popup">
				<div class="dropright">
					<a class="btn btn-sm btn-outline-primary btn-block dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" data-offset="-100" aria-expanded="false">
						<i class="fa fa-bar-chart"></i> Statistik Kependudukan
					</a>
					<ul class="dropdown-menu">
						<?php foreach ($list_lap_front as $key => $value) : ?>
							<li <?= jecho($lap, $key, 'class="active"'); ?>>
								<a href="<?= site_url("statistik_web/chart_gis_desa/$key/" . underscore($desa[nama_desa]). "?desaid=".$desa[id]); ?>" 
									data-remote="false" 
									data-toggle="modal" 
									data-target="#modalBesar" 
									data-title="Statistik Penduduk <?= set_ucwords($wilayah) ?>"
									>
									<?= $value ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<p>
				<a href="<?= site_url("first/loadModalLeuit/$desa[id]"); ?>" class="btn btn-sm btn-outline-primary btn-block" 
					data-title="Data Leuit <?= set_ucwords($wilayah) ?> - <?= set_ucwords($desa['nama_kabupaten']) ?>" 
					data-remote="false" 
					data-toggle="modal" 
					data-target="#modalLeuit">
					<i class="fa fa-leaf"></i>
					Data Leuit <?= ucwords($this->setting->sebutan_desa) ?>
				</a>
			</p>
		</div>
	</div>