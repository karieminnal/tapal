<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>

<div id="isi_popup_rw">
	<?php foreach ($rw_gis as $key_rw => $rw) : ?>
		<div id="isi_popup_rw_<?= $key_rw ?>" style="visibility: hidden;">
			<div id="content">
				<h5 id="firstHeading" class="firstHeading">
					RW <?= set_ucwords($rw['rw']) . " " . ucwords($this->setting->sebutan_dusun) . " <span class='nama-dusun'>" . set_ucwords($rw['dusun']) . "</span>"; ?>
				</h5>
				<div id="bodyContent" class="hide-on-tooltip">
					<!-- <p>
						<a href="<?= site_url("first/load_aparatur_wilayah/$rw[id_kepala]/2"); ?>" class="btn btn-sm btn-outline-primary btn-block" data-title="Ketua RW" data-remote="false" data-toggle="modal" data-target="#modalKecil">
							<i class="fa fa-user"></i> Ketua RW
						</a>
					</p> -->
					<div class="statistik-penduduk-popup">
						<div class="dropright">
							<a class="btn btn-sm btn-outline-primary btn-block dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" data-offset="-100" aria-expanded="false">
								<i class="fa fa-bar-chart"></i> Lihat Statistik
							</a>
							<ul class="dropdown-menu">
								<?php foreach ($list_lap_front as $key => $value) : ?>
									<li <?= jecho($lap, $key, 'class="active"'); ?>>
										<a href="<?= site_url("statistik_web/chart_gis_rw/$key/" . underscore($rw[dusun]) . "/" . underscore($rw[rw]). "?desaid=".$rw[id_desa]); ?>" data-remote="false" data-toggle="modal" data-target="#modalBesar" data-title="Statistik Penduduk RW <?= set_ucwords($rw['rw']) . " " . set_ucwords($wilayah) . set_ucwords($rw['dusun']); ?>">
											<?= $value ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>