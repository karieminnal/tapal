<div class="row">
	<div class="col-md-12">
		<div class="d-flex justify-content-center mb-5">
			<div class="tabs active" id="tab01">
				<h6 class="font-weight-bold">Profil Leuit</h6>
			</div>
			<div class="tabs" id="tab02">
				<h6 class="text-muted">Produksi</h6>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div id="tab011" class="tab-content show">
			<?php foreach ($leuitLokasi as $leuit) : ?>
				<div class="row">
					<div class="col-md-4">
						<div class="image-modal-top" style="">
							<?php
								if ($leuit['foto']) {
									$fotoLeuit = base_url().LOKASI_FOTO_LOKASI.''.$leuit['foto'];
								} else {
									$fotoLeuit = base_url() . 'assets/files/user_pict/kuser.png';
								}

								$alamat = $leuit['nama_jalan'].'<br>RT '.$leuit['rt'].' RW '.$leuit['rw'].' Dusun '.$leuit['dusun'];
							?>
							<img src="<?= $fotoLeuit ?>" alt="" style="">
						</div>
					</div>
					<div class="col-md-8">
						<table class="">
							<tr>
								<td>Lokasi</td>
								<td><?= $alamat; ?></td>
							</tr>
							<tr>
								<td>Volume</td>
								<td><?= convertmass($leuit['volume']); ?></td>
							</tr>
							<tr>
								<td>Tingkat Kekeringan</td>
								<td><?= $leuit['tingkat_kekeringan']; ?>%</td>
							</tr>
							<tr>
								<td>Total Produksi</td>
								<td><?= rp($leuit['produksi']); ?></td>
							</tr>
						</table>
						<hr>
						<a href="javascript:;" onclick="loadStat(<?= $leuit['id']; ?>);">Stat</a>
						<div id="leuitStat"></div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div id="tab021" class="tab-content">
			tab 2
		</div>
	</div>
</div>

<script>
	
	function loadStat(desaid) {
		$.get( "/first/loadModalLeuitStat/"+desaid, function( data ) {
			// console.log(data);
			$('#leuitStat').append(data);
		});
	}
$(document).ready(function () {
  $('.tabs').click(function () {
    $('.tabs').removeClass('active');
    $('.tabs h6').removeClass('font-weight-bold');
    $('.tabs h6').addClass('text-muted');
    $(this).children('h6').removeClass('text-muted');
    $(this).children('h6').addClass('font-weight-bold');
    $(this).addClass('active');

    current_fs = $('.active');

    next_fs = $(this).attr('id');
    next_fs = '#' + next_fs + '1';

    $('.tab-content').removeClass('show');
    $(next_fs).addClass('show');

    current_fs.animate(
      {},
      {
        step: function () {
          current_fs.css({
            display: 'none',
            position: 'relative',
          });
          next_fs.css({
            display: 'block',
          });
        },
      },
    );
  });
});
</script>