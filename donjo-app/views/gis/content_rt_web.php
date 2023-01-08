<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>

<div id="isi_popup_rt">
	<?php foreach ($rt_gis as $key_rt => $rt) : ?>
		<div id="isi_popup_rt_<?= $key_rt ?>" style="visibility: hidden;">
			<div id="content">
				<h5 id="firstHeading" class="firstHeading">
					RT <?= set_ucwords($rt['rt']) . " RW " . set_ucwords($rt['rw']) . " " . ucwords($this->setting->sebutan_dusun) . " <span class='nama-dusun'>" . set_ucwords($rt['dusun']) . "</span>"; ?>
				</h5>
				<div id="bodyContent" class="hide-on-tooltip">
					<!-- <p>
						<a href="<?= site_url("first/load_aparatur_wilayah/$rt[id_kepala]/3"); ?>" class="btn btn-sm btn-outline-primary btn-block" data-title="Ketua RT" data-remote="false" data-toggle="modal" data-target="#modalKecil">
							<i class="fa fa-user"></i> Ketua RT
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
										<a href="<?= site_url("statistik_web/chart_gis_rt/$key/" . underscore($rt[dusun]) . "/" . underscore($rt[rw]) . "/" . underscore($rt[rt]). "?desaid=".$rt[id_desa]) ?>" data-remote="false" data-toggle="modal" data-target="#modalBesar" data-title="Statistik Penduduk RT <?= $rt['rt'] ?> RW <?= $rt['rw'] ?> <?= set_ucwords($wilayah) . " " . set_ucwords($rt['dusun']); ?>">
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