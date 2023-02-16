<div class="content-wrapper">
	<section class="content-header">
		<h1>Pengaturan Jenis Tutupan Lahan</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Pengaturan Jenis Tutupan Lahan</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="mainform" name="mainform" action="" method="post">
			<div class="row">
				<div class="col-md-3">
					<?php $this->load->view('data_persil/menu_kiri.php') ?>
				</div>
				<div class="col-md-9">
					<div class="box box-info">
						<div class="box-header with-border">
							<a href="<?= site_url("tutupan_lahan_jenis/form") ?>" class="btn btn-social btn-flat btn-success btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Tambah Data Baru">
								<i class="fa fa-plus"></i>Tambah Jenis Tutupan Lahan
							</a>
							<?php if ($this->CI->cek_hak_akses('h')) : ?>
								<a href="#confirm-delete" title="Hapus Data" onclick="deleteAllBox('mainform', '<?= site_url("tutupan_lahan_jenis/delete_all/$p/$o") ?>')" class="btn btn-social btn-flat btn-danger btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block hapus-terpilih"><i class='fa fa-trash-o'></i> Hapus Data Terpilih</a>
							<?php endif; ?>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
										<form id="mainform" name="mainform" action="" method="post">
											<div class="row">
												<div class="col-sm-12">
													<div class="table-responsive">
														<table class="table table-bordered table-striped dataTable table-hover">
															<thead class="bg-gray disabled color-palette">
																<tr>
																	<th width="1%"><input type="checkbox" id="checkall" /></th>
																	<th width="1%">No</th>
																	<th width="1%">Aksi</th>
																	<th width="5%">ID Jenis</th>
																	<?php if ($o == 2) : ?>
																		<th><a href="<?= site_url("tutupan_lahan_jenis/index/$p/1") ?>">Jenis <i class='fa fa-sort-asc fa-sm'></i></a></th>
																	<?php elseif ($o == 1) : ?>
																		<th><a href="<?= site_url("tutupan_lahan_jenis/index/$p/2") ?>">Jenis <i class='fa fa-sort-desc fa-sm'></i></a></th>
																	<?php else : ?>
																		<th><a href="<?= site_url("tutupan_lahan_jenis/index/$p/1") ?>">Jenis <i class='fa fa-sort fa-sm'></i></a></th>
																	<?php endif; ?>
																	<th width="10%">Warna</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($main as $data) : ?>
																	<tr>
																		<td><input type="checkbox" name="id_cb[]" value="<?= $data['id'] ?>" /></td>
																		<td><?= $data['no'] ?></td>
																		<td nowrap>
																			<a href="<?= site_url("tutupan_lahan_jenis/form/$p/$o/$data[id]") ?>" class="btn btn-warning btn-flat btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
																			<a href="#" data-href="<?= site_url("tutupan_lahan_jenis/delete/$p/$o/$data[id]") ?>" class="btn bg-maroon btn-flat btn-sm" title="Hapus" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>
																		</td>
																		<td><?= $data['id'] ?></td>
																		<td width="40%"><?= $data['nama'] ?></td>
																		<td >
																			<div style="background-color:<?= $data['warna'] ?>">&nbsp;<div>
																		</td>
																	</tr>
																<?php endforeach; ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</form>
										<div class="row">
											<div class="col-sm-6">
												<div class="dataTables_length">
													<form id="paging" action="<?= site_url("tutupan_lahan_jenis") ?>" method="post" class="form-horizontal">
														<label>
															Tampilkan
															<select name="per_page" class="form-control input-sm" onchange="$('#paging').submit()">
																<option value="20" <?php selected($per_page, 20); ?>>20</option>
																<option value="50" <?php selected($per_page, 50); ?>>50</option>
																<option value="100" <?php selected($per_page, 100); ?>>100</option>
															</select>
															Dari
															<strong><?= $paging->num_rows ?></strong>
															Total Data
														</label>
													</form>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="dataTables_paginate paging_simple_numbers">
													<ul class="pagination">
														<?php if ($paging->start_link) : ?>
															<li><a href="<?= site_url("tutupan_lahan_jenis/index/$paging->start_link/$o") ?>" aria-label="First"><span aria-hidden="true">Awal</span></a></li>
														<?php endif; ?>
														<?php if ($paging->prev) : ?>
															<li><a href="<?= site_url("tutupan_lahan_jenis/index/$paging->prev/$o") ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
														<?php endif; ?>
														<?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++) : ?>
															<li <?= jecho($p, $i, "class='active'") ?>><a href="<?= site_url("tutupan_lahan_jenis/index/$i/$o") ?>"><?= $i ?></a></li>
														<?php endfor; ?>
														<?php if ($paging->next) : ?>
															<li><a href="<?= site_url("tutupan_lahan_jenis/index/$paging->next/$o") ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
														<?php endif; ?>
														<?php if ($paging->end_link) : ?>
															<li><a href="<?= site_url("tutupan_lahan_jenis/index/$paging->end_link/$o") ?>" aria-label="Last"><span aria-hidden="true">Akhir</span></a></li>
														<?php endif; ?>
													</ul>
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
		</form>
	</section>
</div>
<?php $this->load->view('global/confirm_delete'); ?>