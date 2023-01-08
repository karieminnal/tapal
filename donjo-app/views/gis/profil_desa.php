<div class="image-modal-top mb-5" style="height: 300px;overflow: hidden;display: flex;">
	<img src="<?= gambar_desa($desa['kantor_desa'], TRUE) ?>" alt="" style="width: 100%; object-fit: cover;">
</div>
<div class="media mb-5">
	<img class="align-self-start mr-3" src="<?= gambar_desa($desa['logo']); ?>" alt="<?= $data['nama_desa']; ?>">
	<div class="media-body">
		<!-- <h5 class="mt-0">Top-aligned media</h5> -->
		<table class="ml-3">
			<tr>
				<td>Kepala <?= ucwords($this->setting->sebutan_desa) ?></td>
				<td><?= $desa['nama_kepala_desa']; ?></td>
			</tr>
			<tr>
				<td>Kantor <?= ucwords($this->setting->sebutan_desa) ?></td>
				<td><?= $desa['alamat_kantor']; ?></td>
			</tr>
			<tr>
				<td>Telpon</td>
				<td><?= $desa['telepon']; ?></td>
			</tr>
			<tr>
				<td>Website Resmi</td>
				<td>
					<?php if (!empty($desa['website'])) : ?>
						<a href="<?= $desa['website']; ?>" target="_blank">Buka Website</a>
					<?php else : ?>
						-
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td>Kode Pos</td>
				<td><?= $desa['kode_pos']; ?></td>
			</tr>
			<tr>
				<td><?= $kecamatan; ?></td>
				<td><?= $desa['nama_kecamatan']; ?></td>
			</tr>
			<tr>
				<td><?= $kabupaten; ?></td>
				<td><?= $desa['nama_kabupaten']; ?></td>
			</tr>
			<tr>
				<td>Provinsi</td>
				<td><?= $desa['nama_propinsi']; ?></td>
			</tr>
			<tr>
				<td>Luas Wilayah</td>
				<td><?= $desa['luas_desa']; ?> Ha</td>
			</tr>
		</table>
	</div>
</div>