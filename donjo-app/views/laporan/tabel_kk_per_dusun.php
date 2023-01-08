<style type="text/css">
	.italic {
		font-style: italic;
	}
</style>
<div class="table-responsive">
	<table id="tfhover" class="table table-bordered table-hover tftable lap-bulanan">
		<thead class="bg-gray">
			<th class="text-center">NO</th>
			<th class="text-center">DUSUN</th>
			<th class="text-center">LAKI-LAKI</th>
			<th class="text-center">PEREMPUAN</th>
			<th class="text-center">JUMLAH</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($kk_per_dusun['per_dusun']);$i++) { ?>
			<tr>
				<td class="no_urut"><?= $i+1?></td>
				<td ><?= $kk_per_dusun['per_dusun'][$i]['dusun']?></td>
				<td class="bilangan"><?= $kk_per_dusun['per_dusun'][$i]['lk'] ?: '0' ?></td>
				<td class="bilangan"><?= $kk_per_dusun['per_dusun'][$i]['pr'] ?: '0' ?></td>
				<td class="bilangan"><?= $kk_per_dusun['per_dusun'][$i]['jumlah'] ?: '0' ?></td>
			</tr>
			<?php } ?>
			<tr style="font-weight:700">
				<td colspan="2" class="no_urut">JUMLAH</td>
				<td class="bilangan" style="background-color: yellow;"><?= $kk_per_dusun['jumlah']['lk'] ?: '0' ?></td>
				<td class="bilangan" style="background-color: yellow;"><?= $kk_per_dusun['jumlah']['pr'] ?: '0' ?></td>
				<td class="bilangan" style="background-color: yellow;"><?= $kk_per_dusun['jumlah']['jumlah'] ?: '0' ?></td>
			</tr>
		</tbody>
	</table>
</div>