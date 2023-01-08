<script type="text/javascript">
	function ubah_dusun(dusun) {
		$('#isi_rt').hide();
		var rw = $('#rw');
		select_options(rw, urlencode(dusun));
	}

	function ubah_rw(dusun, rw) {
		$('#isi_rt').show();
		var rt = $('#id_cluster');
		var params = urlencode(dusun) + '/' + urlencode(rw);
		select_options(rt, params);
	}
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Pengaturan Lokasi</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?= site_url('leuit_lokasi') ?>"><i class="fa fa-dashboard"></i> Daftar Lokasi Leuit</a></li>
			<li class="active">Pengaturan Lokasi</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="validasi" action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<a href="<?= site_url("leuit_lokasi") ?>" class="btn btn-social btn-flat btn-info btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Tambah Artikel">
								<i class="fa fa-arrow-circle-left "></i>Kembali
							</a>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label class="control-label col-sm-3">Nama</label>
								<div class="col-sm-7">
									<input name="nama" class="form-control input-sm nomor_sk required" maxlength="100" type="text" value="<?= $lokasi['nama'] ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Volume</label>
								<div class="col-sm-7">
									<input name="volume" class="form-control input-sm nomor_sk required" maxlength="100" type="text" value="<?= $lokasi['volume'] ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Tingkat Kekeringan</label>
								<div class="col-sm-7">
									<input name="tingkat_kekeringan" class="form-control input-sm nomor_sk required" maxlength="100" type="text" value="<?= $lokasi['tingkat_kekeringan'] ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Alamat</label>
								<div class="col-sm-7">
									<div class="row">
										<div class="col-sm-12">
											<div class='form-group col-sm-4'>
												<label><?= ucwords($this->setting->sebutan_dusun) ?></label>
												<select name="dusun" class="form-control input-sm required" onchange="ubah_dusun($(this).val())">
													<option value="">Pilih <?= ucwords($this->setting->sebutan_dusun) ?></option>
													<?php foreach ($dusun as $data) : ?>
														<option value="<?= $data['dusun'] ?>" <?php selected($lokasi['dusun'], $data['dusun']) ?>><?= $data['dusun'] ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class='form-group col-sm-3'>
												<label>RW </label>
												<select id="rw" class="form-control input-sm required" name="rw" data-source="<?= site_url() ?>wilayah/list_rw/" data-valueKey="rw" data-displayKey="rw" onchange="ubah_rw($('select[name=dusun]').val(), $(this).val())">
													<option class="placeholder" value="">Pilih RW</option>
													<?php foreach ($rw as $data) : ?>
														<option value="<?= $data['rw'] ?>" <?php selected($lokasi['rw'], $data['rw']) ?>><?= $data['rw'] ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div id='isi_rt' class='form-group col-sm-3'>
												<label>RT </label>
												<select id="id_cluster" class="form-control input-sm required" name="id_cluster" data-source="<?= site_url() ?>wilayah/list_rt/" data-valueKey="id" data-displayKey="rt">
													<option class="placeholder" value="">Pilih RT </option>
													<?php foreach ($rt as $data) : ?>
														<option value="<?= $data['id'] ?>" <?php selected($lokasi['id_cluster'], $data['id']) ?>><?= $data['rt'] ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Nama Jalan</label>
								<div class="col-sm-7">
									<input name="nama_jalan" class="form-control input-sm nomor_sk" maxlength="100" type="text" value="<?= $lokasi['nama_jalan'] ?>"></input>
								</div>
							</div>
							<?php if ($lokasi["foto"]): ?>
								<div class="form-group">
									<label class="control-label col-sm-3"></label>
									<div class="col-sm-7">
									  <img class="attachment-img img-responsive img-circle" src="<?= base_url().LOKASI_FOTO_LOKASI?>kecil_<?= $lokasi['foto']?>" alt="Foto">
									</div>
								</div>
							<?php endif; ?>
							<div class="form-group">
								<label class="control-label col-sm-3">Ganti Foto</label>
								<div class="col-sm-7">
									<div class="input-group input-group-sm">
										<input type="text" class="form-control" id="file_path">
										<input id="file" type="file" class="hidden" name="foto">
										<span class="input-group-btn">
											<button type="button" class="btn btn-info btn-flat"  id="file_browser"><i class="fa fa-search"></i> Browse</button>
										</span>
									</div>
									<p class="help-block small text-red">Hanya gunakan format jpg/jpeg/png</p>
									<p class="help-block small text-red">Kosongkan jika tidak ingin mengubah foto.</p>
								</div>
							</div>
							<?php if ($lokasi["panorama"]): ?>
								<div class="form-group">
									<label class="control-label col-sm-3"></label>
									<div class="col-sm-7">
									  <img class="attachment-img img-responsive img-circle" src="<?= base_url().LOKASI_FOTO_LOKASI?><?= $lokasi['panorama']?>" alt="Foto">
									</div>
								</div>
							<?php endif; ?>
							<div class="form-group">
								<label class="control-label col-sm-3">Foto Panorama</label>
								<div class="col-sm-7">
									<div class="input-group input-group-sm">
										<input type="text" class="form-control" id="file_path_pano">
										<input id="file_pano" type="file" class="hidden" name="foto_pano">
										<span class="input-group-btn">
											<button type="button" class="btn btn-info btn-flat"  id="file_browser_pano"><i class="fa fa-search"></i> Browse</button>
										</span>
									</div>
									<p class="help-block small text-red">Hanya gunakan format jpg/jpeg/png</p>
									<p class="help-block small text-red">Kosongkan jika tidak ingin mengubah foto.</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Keterangan</label>
								<div class="col-sm-7">
									<textarea id="desk" name="desk" class="form-control input-sm" style="height: 200px;"><?= $lokasi['desk'] ?></textarea>
								</div>
							</div>
						</div>
						<div class='box-footer'>
							<div class='col-xs-12'>
								<button type='reset' class='btn btn-danger btn-sm' onclick="reset_form($(this).val());"><i class='fa fa-times'></i> Batal</button>
								<button type='submit' class='btn btn-info btn-sm pull-right confirm'><i class='fa fa-check'></i> Simpan</button>
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
</script>