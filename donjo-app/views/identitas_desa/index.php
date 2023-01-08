<?php
/**
 * File ini:
 *
 * View di Modul Identitas Desa
 *
 * donjo-app/views/identitas_desa/index.php
 *
 */
?>

<style>
	.table {
		font-size: 12px;
	}

	.box-profile {
		width: 100%;
		height: 300px;
		background: url('<?=gambar_desa($main['kantor_desa'], TRUE)?>');
		background-repeat: no-repeat;
		background-position: center center;
	}

	.profile-user-img {
		padding-top: 60px;
		border: 0px;
	}

	.detail {
		color: white;
	}
</style>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Identitas <?= $desa; ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid'); ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Identitas <?= $desa; ?> <?= $main["nama_desa"]; ?> <?= $main["nama_kecamatan"]; ?></li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="mainform" name="mainform" action="" method="post">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<a href="<?= site_url('identitas_desa/form'); ?>" class="btn btn-warning btn-sm" title="Ubah Biodata" ><i class="fa fa-edit"></i> Ubah Data <?= $desa; ?></a>
							<a href="<?= site_url('identitas_desa/maps/kantor'); ?>" class="btn bg-purple btn-sm"><i class='fa fa-map-marker'></i> Lokasi Kantor <?= $desa; ?></a>
							<a href="<?= site_url('identitas_desa/maps/wilayah'); ?>" class="btn btn-flat btn-info btn-sm btn-sm"><i class='fa fa-map'></i> Peta Wilayah <?= $desa; ?></a>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-12">
									<div class="box-body box-profile">
										<img class="profile-user-img img-responsive" src="<?= gambar_desa($main['logo']); ?>" alt="logo">
										<h3 class="profile-username text-center detail"><?= $desa; ?> <?= $main['nama_desa']; ?></h3>
										<p class="text-center detail"><b><?= $kecamatan; ?> <?= $main['nama_kecamatan']; ?>, <?= $kabupaten; ?> <?= $main['nama_kabupaten']; ?>, Provinsi <?= $main['nama_propinsi']; ?></b></p>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
										<table class="table table-bordered table-striped table-hover">
											<tbody>
												<tr>
													<th colspan="3" class="subtitle_head"><strong><?= strtoupper($desa); ?></strong></th>
												</tr>
												<tr>
													<td width="300">Nama <?= $desa; ?></td><td width="1">:</td>
													<td><?= $main['nama_desa']; ?></td>
												</tr>
												<tr>
													<td>Kode <?= $desa; ?></td><td>:</td>
													<td><?= $main['kode_desa']; ?></td>
												</tr>
												<tr>
													<td>Kode Pos <?= $desa; ?></td><td>:</td>
													<td><?= $main['kode_pos']; ?></td>
												</tr>
												<tr>
													<td>Kepala <?= $desa; ?></td><td>:</td>
													<td><?= $main['nama_kepala_desa']; ?></td>
												</tr>
												<tr>
													<td>NIP Kepala <?= $desa; ?></td><td>:</td>
													<td><?= $main['nip_kepala_desa']; ?></td>
												</tr>
												<tr>
													<td>Alamat Kantor <?= $desa; ?></td><td>:</td>
													<td><?= $main['alamat_kantor']; ?></td>
												</tr>
												<tr>
													<td>E-Mail <?= $desa; ?></td><td>:</td>
													<td><?= $main['email_desa']; ?></td>
												</tr>
												<tr>
													<td>Telpon <?= $desa; ?></td><td>:</td>
													<td><?= $main['telepon']; ?></td>
												</tr>
												<tr>
													<td>Website <?= $desa; ?></td><td>:</td>
													<td><?= $main['website']; ?></td>
												</tr>
												<tr>
													<th colspan="3" class="subtitle_head"><strong><?= strtoupper($kecamatan); ?></strong></th>
												</tr>
												<tr>
													<td>Nama <?= $kecamatan; ?></td><td>:</td>
													<td><?= $main['nama_kecamatan']; ?></td>
												</tr>
												<tr>
													<td>Kode <?= $kecamatan; ?></td><td>:</td>
													<td><?= $main['kode_kecamatan']; ?></td>
												</tr>
												<tr>
													<td>Nama <?= ucwords($this->setting->sebutan_camat); ?></td><td>:</td>
													<td><?= $main['nama_kepala_camat']; ?></td>
												</tr>
												<tr>
													<td>NIP <?= ucwords($this->setting->sebutan_camat); ?></td><td>:</td>
													<td><?= $main['nip_kepala_camat']; ?></td>
												</tr>
												<tr>
													<th colspan="3" class="subtitle_head"><strong><?= strtoupper($kabupaten); ?></strong></th>
												</tr>
												<tr>
													<td>Nama <?= $kabupaten; ?></td><td>:</td>
													<td><?= $main['nama_kabupaten']; ?></td>
												</tr>
												<tr>
													<td>Kode <?= $kabupaten; ?></td><td>:</td>
													<td><?= $main['kode_kabupaten']; ?></td>
												</tr>
												<tr>
													<th colspan="3" class="subtitle_head"><strong>PROVINSI</strong></th>
												</tr>
												<tr>
													<td>Nama Provinsi</td><td>:</td>
													<td><?= $main['nama_propinsi']; ?></td>
												</tr>
												<tr>
													<td>Kode Provinsi</td><td>:</td>
													<td><?= $main['kode_propinsi']; ?></td>
												</tr>
												<tr>
													<th colspan="3" class="subtitle_head"><strong>GEO DATA</strong></th>
												</tr>
												<tr>
													<td>Luas Wilayah Desa</td><td>:</td>
													<td><?= $main['luas_desa']; ?> Ha</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
