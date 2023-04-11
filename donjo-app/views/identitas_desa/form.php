<?php

/**
 * File ini:
 *
 * View di Modul Identitas Desa
 *
 * donjo-app/views/identitas_desa/form.php
 *
 */
?>

<div class="content-wrapper">
	<section class="content-header">
		<h1>Identitas <?= $desa; ?> <?= $main["nama_desa"]; ?> <?= $main["nama_kecamatan"]; ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid'); ?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?= site_url('identitas_desa'); ?>"></i> Identitas <?= $desa; ?></a></li>
			<li class="active">Ubah Identitas <?= $desa; ?></li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<form id="mainform" action="<?= $form_action; ?>" method="POST" enctype="multipart/form-data" class="form-horizontal" id="validasi">
				<div class="col-md-3">
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img class="profile-user-img img-responsive img-circle" src="<?= gambar_desa($main['logo']); ?>" alt="Logo">
							<br />
							<p class="text-center text-bold">Logo <?= $desa; ?></p>
							<p class="text-muted text-center text-red">(Kosongkan, jika logo tidak berubah)</p>
							<br />
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" id="file_path">
								<input type="file" class="hidden" id="file" name="logo">
								<input type="hidden" name="old_logo" value="<?= $main['logo']; ?>">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-flat" id="file_browser"><i class="fa fa-search"></i> Browse</button>
								</span>
							</div>
						</div>
					</div>
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img class="img-responsive" src="<?= gambar_desa($main['kantor_desa'], TRUE); ?>" alt="Kantor <?= $desa; ?>">
							<br />
							<p class="text-center text-bold">Kantor <?= $desa; ?></p>
							<p class="text-muted text-center text-red">(Kosongkan, jika kantor <?= $desa; ?> tidak berubah)</p>
							<br />
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" id="file_path2">
								<input type="file" class="hidden" id="file2" name="kantor_desa">
								<input type="hidden" name="old_kantor_desa" value="<?= $main['kantor_desa']; ?>">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-flat" id="file_browser2"><i class="fa fa-search"></i> Browse</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="box box-primary">
						<div class="box-header with-border">
							<a href="<?= site_url('identitas_desa'); ?>" class="btn btn-social btn-flat btn-info btn-sm" title="Kembali Ke Data <?= $desa; ?>"><i class="fa fa-arrow-circle-o-left"></i> Kembali Ke Data Identitas <?= $desa; ?></a>
						</div>
						<div class="box-body">
							<div class="clone-input">
								<input id="nama_propinsi" name="nama_propinsi" class="form-control input-sm required" type="hidden" placeholder="Nama Provinsi" value="<?= $main["nama_propinsi"]; ?>" />
								<input id="nama_kabupaten" name="nama_kabupaten" class="form-control input-sm nama_terbatas required" type="hidden" placeholder="Nama <?= $kabupaten; ?>" value="<?= $main["nama_kabupaten"]; ?>" />
								<input id="nama_kecamatan" name="nama_kecamatan" class="form-control input-sm nama_terbatas required" type="hidden" placeholder="Nama <?= $kecamatan; ?>" value="<?= $main["nama_kecamatan"]; ?>" />
								<input id="nama_desa" name="nama_desa" class="form-control input-sm nama_terbatas required" type="hidden" placeholder="Nama <?= $desa; ?>" value="<?= $main["nama_desa"]; ?>" />
							</div>
							<input id="nip_kepala_desa" name="nip_kepala_desa" class="form-control input-sm nomor_sk" maxlength="50" type="hidden" placeholder="NIP Kepala <?= $desa; ?>" value="<?= $main["nip_kepala_desa"]; ?>" />
							<input id="nip_kepala_camat" name="nip_kepala_camat" class="form-control input-sm nomor_sk" maxlength="50" type="hidden" placeholder="NIP <?= ucwords($this->setting->sebutan_camat) ?>" value="<?= $main["nip_kepala_camat"]; ?>" />
							<div class="form-group row row-provinsi">
								<label class="control-label col-sm-3" >Provinsi</label>
								<div class="col-sm-8">
									<select class="form-control required" name="pilihProvinsi" id="pilihProvinsi">
										<option></option>
										<?php foreach ($listprovinsi as $data) { ?>
											<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($main['kode_propinsi']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
										<?php } ?>
									</select>
									<img src="<?= base_url() ?>assets/images/loader.gif" id="load2" style="display:none;" />
									<div class="row clone-input">
										<div class="col-md-8">
											<input id="kode_propinsi" name="kode_propinsi" class="form-control input-sm bilangan required" type="hidden" placeholder="Kode Provinsi" value="<?= $main["kode_propinsi"]; ?>"/>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row row-kota">
								<label class="control-label col-sm-3" >Kota/Kabupaten</label>
								<div class="col-sm-8">          
									<select class="form-control required" name="pilihKota" id="pilihKota">
										<option></option>
										<?php if($main["kode_kabupaten"]) { ?>
											<?php foreach ($listkota as $data) { ?>
												<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($main['kode_kabupaten']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
											<?php } ?>
										<?php } ?>
									</select>
									<img src="<?= base_url() ?>assets/images/loader.gif" id="load2" style="display:none;" />
									<div class="row clone-input">
										<div class="col-md-8">
											<input id="kode_kabupaten" name="kode_kabupaten" class="form-control input-sm bilangan required" type="hidden" placeholder="Kode Kota/Kabupaten" value="<?= $main["kode_kabupaten"]; ?>"/>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row row-kecamatan">
								<label class="control-label col-sm-3" >Kecamatan</label>
								<div class="col-sm-8">          
									<select class="form-control required" name="pilihKecamatan" id="pilihKecamatan">
										<option></option>
										<?php if($main["kode_kecamatan"]) { ?>
											<?php foreach ($listkec as $data) { ?>
												<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($main['kode_kecamatan']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
											<?php } ?>
										<?php } ?>
									</select>
									<div class="text-center"></div>
									<img src="<?= base_url() ?>assets/images/loader.gif" id="load3" style="display:none;" />
									<div class="row clone-input">
										<div class="col-md-8">
											<input id="kode_kecamatan" name="kode_kecamatan" class="form-control input-sm bilangan required" type="hidden" placeholder="Kode Kecamatan" value="<?= $main["kode_kecamatan"]; ?>"/>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row row-desa">
								<label class="control-label col-sm-3" >Kelurahan/Desa</label>
								<div class="col-sm-8">          
									<select class="form-control required" name="pilihKelurahan" id="pilihKelurahan">
										<option></option>
										<?php if($main["kode_desa"]) { ?>
											<?php foreach ($listdesa as $data) { ?>
												<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($main['kode_desa']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
											<?php } ?>
										<?php } ?>
									</select>
									<div class="row clone-input">
										<div class="col-md-8">
											<input id="kode_desa" name="kode_desa" class="form-control input-sm bilangan required" type="hidden" placeholder="Kode Desa" value="<?= $main["kode_desa"]; ?>"/>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="kode_pos">Kode Pos <?= $desa; ?></label>
								<div class="col-sm-2">
									<input id="kode_pos" name="kode_pos" class="form-control input-sm number" maxlength="6" type="text" placeholder="Kode Pos <?= $desa; ?>" value="<?= $main["kode_pos"]; ?>"></input>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label" for="nama_kepala_desa">Kepala <?= $desa; ?></label>
								<div class="col-sm-8">
									<input id="nama_kepala_desa" name="nama_kepala_desa" class="form-control input-sm nama required" maxlength="50" type="text" placeholder="Kepala <?= $desa; ?>" value="<?= $main["nama_kepala_desa"] ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="alamat_kantor">Alamat Kantor <?= $desa; ?></label>
								<div class="col-sm-8">
									<textarea id="alamat_kantor" name="alamat_kantor" class="form-control input-sm alamat required" maxlength="100" placeholder="Alamat Kantor <?= $desa; ?>" rows="3" style="resize:none;"><?= $main["alamat_kantor"]; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="email_desa">E-Mail <?= $desa; ?></label>
								<div class="col-sm-8">
									<input id="email_desa" name="email_desa" class="form-control input-sm email" maxlength="50" type="text" placeholder="E-Mail <?= $desa; ?>" value="<?= $main["email_desa"] ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="telepon">Telpon <?= $desa; ?></label>
								<div class="col-sm-8">
									<input id="telepon" name="telepon" class="form-control input-sm bilangan" type="text" maxlength="15" placeholder="Telpon <?= $desa; ?>" value="<?= $main["telepon"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="website">Website <?= $desa; ?></label>
								<div class="col-sm-8">
									<input id="website" name="website" class="form-control input-sm url" maxlength="50" type="text" placeholder="Website <?= $desa; ?>" value="<?= $main["website"]; ?>"></input>
								</div>
							</div>


							<div class="form-group">
								<label class="col-sm-3 control-label" for="nama_kecamatan">Nama <?= ucwords($this->setting->sebutan_camat) ?></label>
								<div class="col-sm-8">
									<input id="nama_kepala_camat" name="nama_kepala_camat" class="form-control input-sm nama required" maxlength="50" type="text" placeholder="Nama <?= ucwords($this->setting->sebutan_camat); ?>" value="<?= $main["nama_kepala_camat"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="luas_desa">Luas Wilayah Desa</label>
								<div class="col-sm-3">
									<div class="input-group input-group-sm">
										<input id="luas_desa" name="luas_desa" class="form-control input-sm bilangan_koma" maxlength="50" type="text" placeholder="Luas Wilayah Desa" value="<?= $main["luas_desa"]; ?>"></input>
										<div class="input-group-addon suffix">Ha</div>
									</div>
								</div>
							</div>
						</div>
						<div class='box-footer'>
							<div class='col-xs-12'>
								<button type='reset' class='btn btn-social btn-flat btn-danger btn-sm'><i class='fa fa-times'></i> Batal</button>
								<button type='submit' class='btn btn-social btn-flat btn-info btn-sm pull-right'><i class='fa fa-check'></i> Simpan</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>