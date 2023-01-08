<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<img src="/assets/images/logo-jabar.png" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<strong><?= ucwords($this->setting->sebutan_desa . " " . sentence_case($desa['nama_desa'])); ?></strong>
				</br></br>
				<?php
				$nam_kec = strlen($desa['nama_kecamatan']);
				$nam_kab = strlen($desa['nama_kabupaten']);
				
				$kab = $desa['nama_kabupaten'];
				$newKab = str_replace("KABUPATEN","KAB. ",$kab);
				?>
				
				<?php if ($nam_kec <= 12 and $nam_kab <= 12) : ?>
					<?= ucwords($this->setting->sebutan_kecamatan_singkat . " " . sentence_case($desa['nama_kecamatan'])); ?>
					</br>
					<?= ucwords(sentence_case($newKab)); ?>
				<?php else : ?>
					<?= ucwords(substr($this->setting->sebutan_kecamatan_singkat, 0, 3) . ". " . sentence_case($desa['nama_kecamatan'])); ?>
					</br>
					<?= ucwords(sentence_case($newKab)); ?>
				<?php endif; ?>
			</div>
		</div>
		<ul class="sidebar-menu" data-widget="tree">
			<li><a href="<?= base_url() ?>" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i> <span>Halaman Publik</span></a></li>
			<li class="header">MENU UTAMA</li>

			<?php foreach ($modul as $mod) :
				if ($this->CI->cek_hak_akses('b', $mod['url'])) : ?>
					<?php if (count($mod['submodul']) == 0) : ?>
						<li class="<?php ($this->modul_ini == $mod['id']) and print('active') ?>">
							<a href="<?= site_url() ?><?= $mod['url'] ?>">
								<i class="fa <?= $mod['ikon'] ?> <?php ($this->modul_ini == $mod['id']) and print('text-aqua') ?>"></i> <span><?= $mod['modul'] ?></span>
								<span class="pull-right-container"></span>
							</a>
						</li>
					<?php else : ?>
						<li class="treeview <?php ($this->modul_ini == $mod['id']) and print('active') ?>">
							<a href="<?= site_url() ?><?= $mod['url'] ?>">
								<i class="fa <?= $mod['ikon'] ?> <?php ($this->modul_ini == $mod['id']) and print('text-aqua') ?>"></i> <span><?= $mod['modul'] ?></span>
								<span class="pull-right-container"><i class='fa fa-angle-left pull-right'></i></span>
							</a>
							<ul class="treeview-menu <?php ($this->modul_ini == $mod['id']) and print('active') ?>">
								<?php foreach ($mod['submodul'] as $submod) : ?>
									<li class="<?php ($this->sub_modul_ini == $submod['id']) and print('active') ?>">
										<a href="<?= site_url() ?><?= $submod['url'] ?>">
											<i class="fa <?= ($submod['ikon'] != NULL) ? $submod['ikon'] : 'fa-long-arrow-right' ?> <?php ($this->sub_modul_ini == $submod['id']) and print('text-red') ?>"></i>
											<?= $submod['modul'] ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</section>
</aside>