<div class="content-wrapper">
	<section class="content-header">
		<h1>Setting Provinsi</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Setting Provinsi</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-8 col-lg-12">
				<div class="box box-info">
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
									<div class="row">
										<div class="col-sm-12">
											<div class="table-responsive">
												<table class="table table-bordered table-striped dataTable table-hover">
													<thead class="bg-gray disabled color-palette">
														<tr>
															<th>Nama Provinsi</th>
															<th>Lat</th>
															<th>Long</th>
															<th>Aksi</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><?= $provinsi['nama_provinsi'] ?></td>
															<td><?= $provinsi['lat'] ?></td>
															<td><?= $provinsi['lng'] ?></td>
															<td>
																<a href="<?= site_url("setting_provinsi/form/") ?>" class="btn bg-orange btn-sm" title="Ubah Data"><i class="fa fa-edit"></i> Edit</a>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>