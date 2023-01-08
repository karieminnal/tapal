<style type="text/css">
	.italic {
		font-style: italic;
	}
</style>
<div class="table-responsive">
	<table id="tfhover" class="table table-bordered table-hover tftable lap-bulanan">
		<thead class="bg-gray">
			<tr>
				<th rowspan="2" width='2%' class="text-center">UMUR</th>
				<th colspan="2" class="text-center">PENDUDUK AWAL BULAN</th>
				<th colspan="2" class="text-center">LAHIR</th>
				<th colspan="2" class="text-center">MATI</th>
				<th colspan="2" class="text-center">DATANG</th>
				<th colspan="2" class="text-center">PINDAH</th>
				<th colspan="2" class="text-center">PENDUDUK AKHIR BULAN</th>
			</tr>
			<tr>
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
				<th class="text-center">L</th>
				<th class="text-center">P</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$is_sum=$sum_awal_lk=$sum_awal_pr=$sum_akhir_lk=$sum_akhir_pr=$sum_mati_lk=$sum_mati_pr=$sum_datang_lk=$sum_datang_pr=$sum_pergi_lk=$sum_pergi_pr=$sum_lahir_lk=$sum_lahir_pr=0;
				for($i=0;$i<100;$i++) { 
			?>
				<tr>
					<td class="no_urut"><?= $i ?></td>
					<td class="bilangan"><?= $pend_awal['per_umur'][$i]['lk'] ?: '0' ?></td>
					<td class="bilangan"><?= $pend_awal['per_umur'][$i]['pr'] ?: '0' ?></td>
					<td><?= $lahir['per_umur'][$i]['lk'] ?: '-' ?></td>
					<td><?= $lahir['per_umur'][$i]['pr'] ?: '-' ?></td>
					<td><?= $mati['per_umur'][$i]['lk'] ?: '-' ?></td>
					<td><?= $mati['per_umur'][$i]['pr'] ?: '-' ?></td>
					<td><?= $datang['per_umur'][$i]['lk'] ?: '-' ?></td>
					<td><?= $datang['per_umur'][$i]['pr'] ?: '-' ?></td>
					<td><?= $pergi['per_umur'][$i]['lk'] ?: '-' ?></td>
					<td><?= $pergi['per_umur'][$i]['pr'] ?: '-' ?></td>
					<td class="bilangan"><?= $pend_akhir['per_umur'][$i]['lk'] ?: '0' ?></td>
					<td class="bilangan"><?= $pend_akhir['per_umur'][$i]['pr'] ?: '0' ?></td>
				</tr>
			<?php 
					$is_sum++;
					$sum_awal_lk += $pend_awal['per_umur'][$i]['lk'] ?: 0;
					$sum_awal_pr += $pend_awal['per_umur'][$i]['pr'] ?: 0;
					$sum_lahir_lk += $lahir['per_umur'][$i]['lk'] ?: 0;
					$sum_lahir_pr += $lahir['per_umur'][$i]['pr'] ?: 0;
					$sum_mati_lk += $mati['per_umur'][$i]['lk'] ?: 0;
					$sum_mati_pr += $mati['per_umur'][$i]['pr'] ?: 0;
					$sum_datang_lk += $datang['per_umur'][$i]['lk'] ?: 0;
					$sum_datang_pr += $datang['per_umur'][$i]['pr'] ?: 0;
					$sum_pergi_lk += $pergi['per_umur'][$i]['lk'] ?: 0;
					$sum_pergi_pr += $pergi['per_umur'][$i]['pr'] ?: 0;
					$sum_akhir_lk += $pend_akhir['per_umur'][$i]['lk'] ?: 0;
					$sum_akhir_pr += $pend_akhir['per_umur'][$i]['pr'] ?: 0;
					if($is_sum==5) { ?>
						<tr style="background-color: pink;">
							<td class="no_urut"><?= strval($i-4)."-".strval($i) ?></td>
							<td class="bilangan"><?= $sum_awal_lk ?: '0' ?></td>
							<td class="bilangan"><?= $sum_awal_pr ?: '0' ?></td>
							<td><?= $sum_lahir_lk ?: '-' ?></td>
							<td><?= $sum_lahir_pr ?: '-' ?></td>
							<td><?= $sum_mati_lk ?: '-' ?></td>
							<td><?= $sum_mati_pr ?: '-' ?></td>
							<td><?= $sum_datang_lk ?: '-' ?></td>
							<td><?= $sum_datang_pr ?: '-' ?></td>
							<td><?= $sum_pergi_lk ?: '-' ?></td>
							<td><?= $sum_pergi_pr ?: '-' ?></td>
							<td class="bilangan"><?= $sum_akhir_lk ?: '0' ?></td>
							<td class="bilangan"><?= $sum_akhir_pr ?: '0' ?></td>
						</tr>
					<?php
					$is_sum=$sum_awal_lk=$sum_awal_pr=$sum_akhir_lk=$sum_akhir_pr=$sum_mati_lk=$sum_mati_pr=$sum_datang_lk=$sum_datang_pr=$sum_pergi_lk=$sum_pergi_pr=$sum_lahir_lk=$sum_lahir_pr=0;
					}
				} 
			?>
			<tr style="background-color: pink;">
				<td class="no_urut">100 Keatas</td>
				<td class="bilangan"><?= $pend_awal['per_umur'][100]['lk'] ?: '0' ?></td>
				<td class="bilangan"><?= $pend_awal['per_umur'][100]['pr'] ?: '0' ?></td>
				<td><?= $lahir['per_umur'][100]['lk'] ?: '-' ?></td>
				<td><?= $lahir['per_umur'][100]['pr'] ?: '-' ?></td>
				<td><?= $mati['per_umur'][100]['lk'] ?: '-' ?></td>
				<td><?= $mati['per_umur'][100]['pr'] ?: '-' ?></td>
				<td><?= $datang['per_umur'][100]['lk'] ?: '-' ?></td>
				<td><?= $datang['per_umur'][100]['pr'] ?: '-' ?></td>
				<td><?= $pergi['per_umur'][100]['lk'] ?: '-' ?></td>
				<td><?= $pergi['per_umur'][100]['pr'] ?: '-' ?></td>
				<td class="bilangan"><?= $pend_akhir['per_umur'][100]['lk'] ?: '0' ?></td>
				<td class="bilangan"><?= $pend_akhir['per_umur'][100]['pr'] ?: '0' ?></td>
			</tr>
			<tr>
				<td class="no_urut">JUMLAH</td>
				<td class="bilangan"><?= $pend_awal['jumlah']['lk'] ?: '0' ?></td>
				<td class="bilangan"><?= $pend_awal['jumlah']['pr'] ?: '0' ?></td>
				<td><?= $lahir['jumlah']['lk'] ?: '0' ?></td>
				<td><?= $lahir['jumlah']['pr'] ?: '0' ?></td>
				<td><?= $mati['jumlah']['lk'] ?: '0' ?></td>
				<td><?= $mati['jumlah']['pr'] ?: '0' ?></td>
				<td><?= $datang['jumlah']['lk'] ?: '0' ?></td>
				<td><?= $datang['jumlah']['pr'] ?: '0' ?></td>
				<td><?= $pergi['jumlah']['lk'] ?: '0' ?></td>
				<td><?= $pergi['jumlah']['pr'] ?: '0' ?></td>
				<td class="bilangan"><?= $pend_akhir['jumlah']['lk'] ?: '0' ?></td>
				<td class="bilangan"><?= $pend_akhir['jumlah']['pr'] ?: '0' ?></td>
			</tr>
			<tr>
				<td class="no_urut">L/P</td>
				<td colspan="2" class="bilangan"><?= $pend_awal['L/P'] ?: 0 ?></td>
				<td colspan="2" class="bilangan"><?= $lahir['L/P'] ?: 0 ?></td>
				<td colspan="2" class="bilangan"><?= $mati['L/P'] ?: 0 ?></td>
				<td colspan="2" class="bilangan"><?= $datang['L/P'] ?: 0 ?></td>
				<td colspan="2" class="bilangan"><?= $pergi['L/P'] ?: 0 ?></td>
				<td colspan="2" class="bilangan"><?= $pend_akhir['L/P'] ?: 0 ?></td>
			</tr>
		</tbody>
	</table>
</div>