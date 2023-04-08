<div class="content-wrapper">
	<section class="content-header">
		<h1>List Desa</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">List Desa</li>
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
												<table class="table dataTable" id="tableListDesa">
													<thead class="bg-white color-palette">
														<tr>
															<th class="nowrap no-sort">Kabupaten</th>
															<th class="nowrap">Kecamatan</th>
															<th class="nowrap">Nama Desa</th>
															<th class="nowrap">ID Desa</th>
															<th class="nowrap">Nama Kades</th>
															<th class="nowrap">Luas (Ha)</th>
															<th class="nowrap no-sort">Alamat Kantor</th>
															<!-- <th class="nowrap">Kode Pos</th>
															<th class="nowrap no-sort">Telp</th>
															<th class="nowrap no-sort">Email</th> -->
															<th class="nowrap no-sort">Aksi</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach($listdesa as $data) { 
															$kab = $data['nama_kabupaten'];
															$newKab = str_replace("KABUPATEN","KAB. ",$kab);
															?>
															<tr>
																<td class="nowrap"><?= $newKab ?></td>
																<td class="nowrap">KEC. <?= $data['nama_kecamatan'] ?></td>
																<td class="nowrap">
																	<a href="<?= site_url("list_desa/sub/$data[id]") ?>" title="Detail Wilayah">
																		<?= $data['nama_desa'] ?>
																	</a>
																</td>
																<td class="nowrap"><?= $data['id'] ?></td>
																<td class="nowrap"><?= $data['nama_kepala_desa'] ?></td>
																<td class="nowrap"><?= $data['luas_desa'] ?></td>
																<td class="nowrap"><?= $data['alamat_kantor'] ?></td>
																<!-- <td class="nowrap"><?= $data['kode_pos'] ?></td>
																<td class="nowrap"><?= $data['telepon'] ?></td>
																<td class="nowrap"><?= $data['email_desa'] ?></td> -->
																<td class="nowrap">
																	<a href="<?= site_url("list_desa/sub/$data[id]") ?>" class="btn bg-info btn-xs" title="Detail Wilayah">
																		<i class="fa fa-eye"></i>
																	</a>
																</td>
															</tr>
														<?php } ?>
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