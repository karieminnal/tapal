<div class="content-wrapper">
	<section class="content-header">
		<h1>Pengaturan Provinsi</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?= site_url('setting_provinsi') ?>"><i class="fa fa-dashboard"></i> Provinsi</a></li>
			<li class="active">Update</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="validasi" action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<a href="<?= site_url("setting_provinsi") ?>" class="btn btn-info btn-sm" title="">
								<i class="fa fa-arrow-circle-left "></i>Kembali
							</a>
						</div>
						<div class="box-body">
							<div class="clone-input">
								<input id="nama_propinsi" name="nama_propinsi" class="form-control input-sm required" type="hidden" placeholder="Nama Provinsi" value="<?= $provinsi["nama_provinsi"]; ?>" />
							</div>
							<div class="form-group row row-provinsi">
								<label class="control-label col-sm-3" >Provinsi</label>
								<div class="col-sm-8">
									<select class="form-control required" name="pilihProvinsi" id="pilihProvinsi">
										<option></option>
										<?php foreach ($listprovinsi as $data) { ?>
											<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($provinsi['id_provinsi']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
										<?php } ?>
									</select>
									<img src="<?= base_url() ?>assets/images/loader.gif" id="load2" style="display:none;" />
								</div>
							</div>
							<div class="form-group row row-kota">
								<label class="control-label col-sm-3" >Kota/Kabupaten</label>
								<div class="col-sm-8">          
									<select class="form-control required" name="pilihKota" id="pilihKota">
										<option></option>
										<?php if($provinsi["id_kota"]) { ?>
											<?php foreach ($listkota as $data) { ?>
												<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($provinsi['id_kota']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
											<?php } ?>
										<?php } ?>
									</select>
									<img src="<?= base_url() ?>assets/images/loader.gif" id="load2" style="display:none;" />
								</div>
							</div>
							<div class="form-group row row-kecamatan">
								<label class="control-label col-sm-3" >Kecamatan</label>
								<div class="col-sm-8">          
									<select class="form-control required" name="pilihKecamatan" id="pilihKecamatan">
										<option></option>
										<?php if($provinsi["id_kecamatan"]) { ?>
											<?php foreach ($listkec as $data) { ?>
												<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($provinsi['id_kecamatan']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
											<?php } ?>
										<?php } ?>
									</select>
									<div class="text-center"></div>
									<img src="<?= base_url() ?>assets/images/loader.gif" id="load3" style="display:none;" />
								</div>
							</div>
							<div class="form-group row row-desa">
								<label class="control-label col-sm-3" >Kelurahan/Desa</label>
								<div class="col-sm-8">          
									<select class="form-control required" name="pilihKelurahan" id="pilihKelurahan">
										<option></option>
										<?php if($provinsi["id_kelurahan"]) { ?>
											<?php foreach ($listkel as $data) { ?>
												<option value="<?php echo $data['id'] ?>" data-kode="<?= $data['id']; ?>" data-name="<?= $data['name']; ?>" <?= selected(strtolower($provinsi['id_kelurahan']), strtolower($data['id'])); ?>><?php echo $data['name'] ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="kode_pos">Kode Pos</label>
								<div class="col-sm-2">
									<input id="kode_pos" name="kode_pos" class="form-control input-sm number" maxlength="6" type="text" placeholder="Kode Pos" value="<?= $provinsi["kode_pos"]; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="nama_jalan">Nama Jalan</label>
								<div class="col-sm-2">
									<input id="nama_jalan" name="nama_jalan" class="form-control input-sm" type="text" placeholder="Nama Jalan" value="<?= $provinsi["nama_jalan"]; ?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label" for="gubernur">Gubernur</label>
								<div class="col-sm-8">
									<input id="gubernur" name="gubernur" class="form-control input-sm required" maxlength="50" type="text" placeholder="Gubernur" value="<?= $provinsi["gubernur"] ?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label" for="lat">Lat</label>
								<div class="col-sm-9">
									<input type="text" class="form-control input-sm number" name="lat" id="lat" value="<?= $provinsi['lat']?>"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="lat">Lng</label>
								<div class="col-sm-9">
									<input type="text" class="form-control input-sm number" name="lng" id="lng" value="<?= $provinsi['lng']?>" />
								</div>
							</div>
						</div>
						<div class='box-footer'>
							<div class='col-xs-12'>
								<button type='submit' class='btn btn-info btn-sm pull-right confirm'><i class='fa fa-check'></i> Simpan</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>