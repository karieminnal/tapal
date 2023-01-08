<div class="main-nav">
	<input type="hidden" name="sesiDesa" id="sesiDesa" value="<?php echo ($_SESSION['filterIdDesa'] ? $_SESSION['filterIdDesa'] : 0) ?>">
	<ul class='list_kategori level1'>

		<?php foreach ($jenisLokasi as $lokasi) : ?>
			<li class='level1'>
				<a href='javascript:;' class='judul_kategori' data-trigger="showMarkerAllSub" data-desaid="<?php echo ($_SESSION['filterIdDesa'] ? $_SESSION['filterIdDesa'] : 0) ?>" id-jenis="<?= $lokasi['id'] ?>" data-filter="<?= $lokasi['nama'] ?>" filter-kategori="false"><?= $lokasi['nama'] ?></a>
			</li>
		<?php endforeach; ?>
		<li class='level1'>
			<a href='javascript:;' class='judul_kategori' data-trigger="showTutupanLahan" data-desaid="<?php echo ($_SESSION['filterIdDesa'] ? $_SESSION['filterIdDesa'] : 0) ?>">Tutupan Lahan</a>
		</li>
		<li class='level1 <?php echo ($show_penduduk ? 'disabled' : '') ?>'>
			<a href='javascript:;' class='judul_kategori has-child'>Sebaran Penduduk</a>
			<div class='sub-kategori'>
				<ul class='level2'>
					<?php foreach ($list_lap_front as $key => $value) : ?>
						<li class="level2">
							<a href="javascript:;" class="judul_kategori" data-trigger="showKependudukan" data-desaid="<?php echo ($_SESSION['filterIdDesa'] ? $_SESSION['filterIdDesa'] : 0) ?>" data-key="<?= $key ?>" data-filter="<?= $value ?>">
								<?= $value ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</li>
		<!-- <li class='level1 <?php echo ($show_penduduk ? 'disabled' : '') ?>'>
			<a href="<?= site_url("/first/statistik/kelas_sosial/"); ?>" 
				class="judul_kategori" 
				data-remote="false" 
				data-title="Statistik Kelas Sosial <?= set_ucwords($wilayah) ?>" 
				data-toggle="modal" 
				data-target="#modalBesar"
				data-desaid="<?php echo ($_SESSION['filterIdDesa'] ? $_SESSION['filterIdDesa'] : 0) ?>">
				Kelas Sosial
			</a>
		</li> -->
	</ul>
</div>