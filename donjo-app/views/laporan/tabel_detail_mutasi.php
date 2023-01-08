<style type="text/css">
	.italic {
		font-style: italic;
	}
</style>
<div class="table-responsive">
	<table id="tfhover" class="table table-bordered table-hover tftable lap-bulanan">
		<thead class="bg-gray">
			<tr>
				<th rowspan="3" class="text-center">NO</th>
				<th rowspan="3" class="text-center">TGL</th>
				<th rowspan="3" class="text-center">NAMA</th>
				<th rowspan="3" class="text-center">NIK</th>
				<th rowspan="3" class="text-center">RT/RW</th>
				<th rowspan="2" colspan="3" class="text-center">PENDUDUK BULAN LALU</th>
				<th rowspan="1" colspan="8" class="text-center">MUTASI BULAN INI</th>
				<th rowspan="2" colspan="3" class="text-center">PENDUDUK BULAN INI</th>
			</tr>
			<tr>
				<th colspan="2" class="text-center">LAHIR</th>
				<th colspan="2" class="text-center">MATI</th>
				<th colspan="2" class="text-center">PINDAH</th>
				<th colspan="2" class="text-center">DATANG</th>
			</tr>
			<tr>
				<th class="text-center">L</th>
				<th class="text-center">P</th>
				<th class="text-center">JML</th>
				<th class="text-center">L</th>
				<th class="text-center">P</th>
				<th class="text-center">L</th>
				<th class="text-center">P</th>
				<th class="text-center">L</th>
				<th class="text-center">P</th>
				<th class="text-center">L</th>
				<th class="text-center">P</th>
				<th class="text-center">L</th>
				<th class="text-center">P</th>
				<th class="text-center">JML</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="5" style="font-weight: 700; text-align: center;">JUMLAH PENDUDUK BULAN INI</td>
				<td style="font-weight: 700; text-align: center;"><?= $penduduk_awal['jumlah']['lk'] ?: 0 ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $penduduk_awal['jumlah']['pr'] ?: 0 ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $penduduk_awal['L/P'] ?: 0 ?></td>
				<td colspan="11"></td>
			</tr>
			<?php 
				$no = 0;
				$datang_lk=array('51','61','81');
				$datang_pr=array('52','62','82');
				foreach($detail_mutasi as $k => $v) { 
					$no++;
			?>
				<tr>
					<td class="no_urut"><?= $no ?></td>
					<td style="text-align: center;"><?= $v['tgl']?></td>
					<td style="text-align: center;"><?= $v['nama']?></td>
					<td style="text-align: center;"><?= $v['nik']?></td>
					<td style="text-align: center;"><?= $v['rt_rw']?></td>
					<td colspan="3"></td>
					<td style="text-align: center;"><?= $v['detail']=='11' ? '1': ''?></td>
					<td style="text-align: center;"><?= $v['detail']=='12' ? '1': ''?></td>
					<td style="text-align: center;"><?= $v['detail']=='21' ? '1': ''?></td>
					<td style="text-align: center;"><?= $v['detail']=='22' ? '1': ''?></td>
					<td style="text-align: center;"><?= in_array($v['detail'],$datang_lk) ? '1' :'' ?></td>
					<td style="text-align: center;"><?= in_array($v['detail'],$datang_pr) ? '1' :'' ?></td>
					<td style="text-align: center;"><?= $v['detail']=='31' ? '1': ''?></td>
					<td style="text-align: center;"><?= $v['detail']=='32' ? '1': ''?></td>
					<td colspan="3"></td>
				</tr>
			<?php } ?>
			<tr>
				<td colspan="8" style="font-weight: 700; text-align: center;">JUMLAH</td>
				<td style="font-weight: 700; text-align: center;"><?= $lahir['jumlah']['lk'] ?: '0' ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $lahir['jumlah']['pr'] ?: '0' ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $mati['jumlah']['lk'] ?: '0' ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $mati['jumlah']['pr'] ?: '0' ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $datang['jumlah']['lk'] ?: '0' ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $datang['jumlah']['pr'] ?: '0' ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $pergi['jumlah']['lk'] ?: '0' ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $pergi['jumlah']['pr'] ?: '0' ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $penduduk_akhir['jumlah']['lk'] ?: '0' ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $penduduk_akhir['jumlah']['pr'] ?: '0' ?></td>
				<td style="font-weight: 700; text-align: center;"><?= $penduduk_akhir['L/P'] ?: '0' ?></td>
			</tr>
		</tbody>
	</table>
</div>