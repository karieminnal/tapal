<?php

defined('BASEPATH') or exit('No direct script access allowed');

?>


<div id="isi_popup_dusun">
	<?php foreach ($dusun_gis as $key_dusun => $dusun) : ?>
		<div id="isi_popup_dusun_<?= $key_dusun ?>" style="visibility: hidden;">
			<div id="content">
				<h5 id="firstHeading" class="firstHeading">
					<?= set_ucwords($wilayah) . " <span class='nama-dusun'>" . set_ucwords($dusun['dusun']) . "</span>"; ?>
				</h5>
				<div id="bodyContent" class="hide-on-tooltip">
					<p>
						<a href="<?= site_url("first/load_aparatur_wilayah/$dusun[id_kepala]/1") ?>" class="btn btn-sm btn-outline-primary btn-block" data-title="Kepala <?= set_ucwords($wilayah) . $dusun['dusun'] ?>" data-remote="false" data-toggle="modal" data-target="#modalKecil">
							<i class="fa fa-user"></i>&nbsp;Kepala <?= set_ucwords($wilayah) ?>&nbsp;
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
										<a href="<?= site_url("statistik_web/chart_gis_dusun/$key/" . underscore($dusun[dusun])); ?>" data-remote="false" data-toggle="modal" data-target="#modalBesar" data-title="Statistik Penduduk <?= set_ucwords($wilayah) . " " . set_ucwords($dusun['dusun']); ?>">
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