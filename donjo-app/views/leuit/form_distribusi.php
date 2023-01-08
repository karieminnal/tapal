<div class="content-wrapper">
	<section class="content-header">
		<h1>Tambah Distribusi</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?= site_url('leuit_panen') ?>"><i class="fa fa-dashboard"></i> Leuit Distribusi</a></li>
			<li class="active">Tambah</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="validasi" action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<a href="<?= site_url("leuit_panen") ?>" class="btn btn-info btn-sm" title="">
								<i class="fa fa-arrow-circle-left "></i>Kembali
							</a>
						</div>
						
						<div class="box-body">
							<div class="form-group">
								<label class="control-label col-sm-3">Tanggal</label>
								<div class="col-sm-7">
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="tanggal_distribusi" class="form-control pull-right datepicker required" value="<?= tgl_indo_out($distribusi['tanggal_distribusi']) ?>">
									</div>
								</div>
							</div>
							<div class='form-group'>
								<label class="control-label col-sm-3">Kebutuhan</label>
								<div class="col-sm-7">
									<select name="jenis" class="form-control form-control-sm required select-jenis select2" id="idjenis">
										<option value="">Pilih Kebutuhan</option>
										<option value="Produksi" <?php if($distribusi['jenis'] == 'Produksi') echo 'selected' ?>>Produksi</option>
										<option value="Komersil" <?php if($distribusi['jenis'] == 'Komersil') echo 'selected' ?>>Komersil</option>
										<option value="Distribusi/Logistik" <?php if($distribusi['jenis'] == 'Distribusi/Logistik') echo 'selected' ?>>Distribusi/Logistik</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Harga/Kg</label>
								<div class="col-sm-7">
									<input name="harga" class="form-control input-sm nomor_sk required" maxlength="100" type="number" value="<?= $distribusi['harga'] ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Jumlah Distribusi (Kg)</label>
								<div class="col-sm-7">
									<input name="jumlah_distribusi" class="form-control input-sm nomor_sk required" maxlength="100" type="text" value="<?= $distribusi['jumlah_distribusi'] ?>" pattern="^\d*(\.\d{0,2})?$"></input>
								</div>
							</div>
						</div>
						<div class='box-footer'>
							<div class='col-xs-12'>
								<button type='reset' class='btn btn-social btn-flat btn-danger btn-sm' onclick="reset_form($(this).val());"><i class='fa fa-times'></i> Batal</button>
								<button type='submit' class='btn btn-social btn-flat btn-info btn-sm pull-right confirm'><i class='fa fa-check'></i> Simpan</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
	<script>
		function reset_form() {
			<?php if ($lokasi['enabled'] == '1' or $lokasi['enabled'] == NULL) : ?>
				$("#sx3").addClass('active');
				$("#sx4").removeClass("active");
			<?php endif ?>
			<?php if ($lokasi['enabled'] == '2') : ?>
				$("#sx4").addClass('active');
				$("#sx3").removeClass("active");
			<?php endif ?>
		};
		$(document).on('keydown', 'input[pattern]', function(e){
			var input = $(this);
			var oldVal = input.val();
			var regex = new RegExp(input.attr('pattern'), 'g');

			setTimeout(function(){
				var newVal = input.val();
				if(!regex.test(newVal)){
				input.val(oldVal); 
				}
			}, 1);
		});
		
		var infoWindow;
		var select2;
		
	</script>