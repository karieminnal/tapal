<div class="content-wrapper">
	<section class="content-header">
		<h1>Wilayah Desa</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Wilayah Desa</li>
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
												<table class="table table-bordered table-striped dataTable table-hover" id="tableListWil">
													<thead class="bg-gray disabled color-palette">
														<tr>
															<th class="nowrap">Nama Dusun</th>
															<th class="nowrap">Nama RW</th>
															<th class="nowrap">Nama RT</th>
															<th class="nowrap">ID Cluster</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach($listwil as $data) { ?>
															<tr>
																<td class="nowrap"><?= $data['dusun'] ?></td>
																<td class="nowrap"><?= $data['rw'] ?></td>
																<td class="nowrap"><?= $data['rt'] ?></td>
																<td class="nowrap"><?= $data['id'] ?></td>
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