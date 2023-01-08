<style type="text/css">
	#mandiri i.fa {
		margin-right: 10px;
	}

	#mandiri button.nowrap {
		white-space: nowrap;
	}

	#mandiri .badge {
		background-color: red;
		color: white;
		margin-left: 0px;
	}
</style>
<div class="akun-login">
	<div class="avatar">
		<?php if ($penduduk['foto']) : ?>
			<img class="penduduk img-responsive img-circle" src="<?= AmbilFoto($penduduk['foto']) ?>" alt="Foto">
		<?php else : ?>
			<img class="penduduk img-responsive img-circle" src="<?= base_url() ?>assets/files/user_pict/kuser.png" alt="Foto">
		<?php endif; ?></td>
	</div>
	<div class="bio-login">
		<h4><?= $_SESSION['nama']; ?></h4>
		<p>NIK: <?= $_SESSION['nik']; ?></p>
		<p>No KK: <?= $_SESSION['no_kk'] ?></p>
	</div>
	<div class="button-akun">
		<a href="<?= site_url("mandiri_web/cetak_kk/$penduduk[id]/1"); ?>" class="btn btn-sm btn-block btn-outline-secondary" target="_blank"><i class="fa fa-print"></i> CETAK KK</a>
	</div>
</div>
<ul class='list_kategori level1'>
	<!-- <li class='level1'>
		<a href='/' class='judul_kategori'> Beranda</a>
	</li> -->
	<li class='level1'>
		<a href="<?= site_url(); ?>mandiri_web/mandiri/1/1" class="">Profil</a>
	</li>
	<li class='level1'>
		<a href="<?= site_url(); ?>mandiri_web/mandiri/1/3">
			<span>Kotak Pesan</span>
			<span class="badge" id="b_pesan" title="Pesan baru" style="display: none;"></span>
		</a>
	</li>
	<li class='level1'><a href="<?= site_url(); ?>mandiri_web/mandiri_surat" class="">Permohonan Surat</a></li>
	<li class='level1'><a href="<?= site_url(); ?>mandiri_web/mandiri/1/2" class="">Riwayat Permohonan Surat</a></li>
	<li class='level1'><a href="<?= site_url(); ?>mandiri_web/mandiri/1/4" class="">Program Bantuan</a></li>
	<li class='level1'><a href="<?= site_url(); ?>mandiri_web/logout" class="">Keluar</a></li>
</ul>
<script type="text/javascript">
	$('document').ready(function() {
		setTimeout(function() {
			refresh_badge($("#b_pesan"), "<?= site_url('notif_web/inbox'); ?>");
		}, 500);
	});
</script>