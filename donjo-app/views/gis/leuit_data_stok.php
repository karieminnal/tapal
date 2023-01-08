<?php $this->load->view($folder_themes . '/layouts/header_iframe.php'); ?>

<body <?php if (isset($_REQUEST['app'])) { ?> class="from-app" <?php } ?>>

<link rel="stylesheet" href="<?= base_url() ?>assets/app/css/app.css" />
<link rel="stylesheet" href="<?= base_url() ?>assets/css/additional.css" />

<main class="my-3 mx-3" role="main">
	<section class="">

	<?php if($leuit_panen) { ?>
	<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-bordered table-striped dataTable table-hover loading-table" id="tableAnalisaList">
						<thead class="bg-gray disabled color-palette">
							<tr>
								<th class="no-sort">No</th>
								<th>Desa</th>
								<th>Kab.</th>
								<th>Input (ton)</th>
								<th>Output (ton)</th>
								<th>Stok (ton)</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-bordered table-striped dataTable table-hover loading-table" id="tableAnalisaDistribusi">
						<thead class="bg-gray disabled color-palette">
							<tr>
								<th class="no-sort">No</th>
								<th>Desa</th>
								<th>Kab.</th>
								<th>Komersil (ton)</th>
								<th>Produksi (ton)</th>
								<th>Logistik (ton)</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>

	<?php } else { ?>
		<p class="my-5 text-center">Belum ada data</p>
	<?php } ?>

	</section>
</main>

<?php $this->load->view($folder_themes . '/layouts/script_iframe.php'); ?>

<script>
	$(document).ready(function () {
		<?php if($leuit_panen) { ?>

			<?php if(isset($_REQUEST['year'])) { 
				$filterTahun = '?year='.$_REQUEST['year'];
			} else {
				$filterTahun = '';
			} ?>
			$('#tableAnalisaList').DataTable({
				iDisplayLength: 20,
				ajax: '/api_custom/analisa_leuit<?php echo $filterTahun ?>',
				columns: [
					{ data: 'no'},
					{ data: 'nama_desa' },
					{ data: 'nama_kabupaten' },
					{ data: 'leuit_input' },
					{ data: 'leuit_output' },
					{ data: 'leuit_stok' },
				],
			});

			$('#tableAnalisaDistribusi').DataTable({
				iDisplayLength: 20,
				ajax: '/api_custom/analisa_leuit<?php echo $filterTahun ?>',
				columns: [
					{ data: 'no'},
					{ data: 'nama_desa' },
					{ data: 'nama_kabupaten' },
					{ data: 'leuit_output_komersil' },
					{ data: 'leuit_output_produksi' },
					{ data: 'leuit_output_logistik' },
				],
			});
		<?php } ?>
	});

</script>

</body>
</html>