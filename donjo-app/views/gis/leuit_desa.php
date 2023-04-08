<?php if($leuitLokasi) { ?>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-4">
				<?php foreach ($leuitLokasi as $leuit) : ?>
					<div class="image-modal-top" style="">
						<?php
							if ($leuit['foto']) {
								$fotoLeuit = base_url().LOKASI_FOTO_LOKASI.''.$leuit['foto'];
							} else {
								$fotoLeuit = base_url() . 'assets/images/logo-jabar.png';
							}

							$alamat = $leuit['nama_jalan'].' RT '.$leuit['rt'].' RW '.$leuit['rw'].' Dusun '.$leuit['dusun'];
						?>
						<img src="<?= $fotoLeuit ?>" alt="" style="">
					</div>
				<?php endforeach; ?>
			</div>
			<div class="col-md-8">
				<?php foreach ($leuitLokasi as $leuit) : ?>
					<table class="">
						<!-- <tr>
							<td>Lokasi</td>
							<td><?= $alamat; ?></td>
						</tr> -->
						<tr>
							<td>Volume</td>
							<td><?= convertmass($leuit['volume']); ?></td>
						</tr>
						<tr>
							<td>Tingkat Kekeringan</td>
							<td><?= $leuit['tingkat_kekeringan']; ?>%</td>
						</tr>
					</table>
					<hr>
					<a href="javascript:;" class="trigger-stat d-none" onclick="loadStat(<?= $leuit['id']; ?>);">Stats</a>
					<input type="hidden" id="inputIdDesa" value="<?= $leuit['id']; ?>">
					<input type="hidden" class="form-control" id="inputUrl" value="/first/loadLeuitAllData?fe=true&desa=<?= $leuit['id']; ?>">
					<input type="hidden" class="form-control" id="inputYear" value="">
					<input type="hidden" class="form-control" id="inputDusun" value="">
					<input type="hidden" class="form-control" id="inputSawah" value="">
				<?php endforeach; ?>

				<div id="leuitStat"></div>
			</div>
		</div>
	</div>
</div>
<script>
	function loadStat(desaid) {
		$('.loading').show();
		var url = $('#inputUrl').val();
		var year = $('#inputYear').val();
		var dusun = $('#inputDusun').val();
		var sawah = $('#inputSawah').val();
		$.get( url+year+dusun+sawah, function( data ) {
			$('#leuitStat').html(data);
			$('#inputUrl').val(url);
			setTimeout(
			function() {
				$('#leuitStat').fadeIn();
				$('.loading').hide();
			}, 1000);
		});
	}
	$(document).ready(function () {
		$('.trigger-stat').trigger('click');
	});
</script>
<?php } else { ?>
	<p class="my-5 text-center">Belum ada data</p>
<?php } ?>