	<form id="peraturanForm" onsubmit="formAction(); return false;">
		<div class="row">
			<div class="col">
				<div class="form-group">
					<label for="kategori">Jenis</label>
					<select class="form-control form-control-sm" name="kategori" id="kategori" onchange="formAction()">
						<option value="">Semua</option>
						<?php foreach ($kategori as $s) : ?>
							<option value="<?= $s['id'] ?>" <?php selected($s['id'], $kategori_dokumen) ?>><?= $s['nama'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label for="tahun">Tahun</label>
					<select class="form-control form-control-sm" name="tahun" id="tahun" onchange="formAction()">
						<option value="">Semua</option>
						<?php foreach ($tahun as $t) : ?>
							<option value="<?= $t['tahun'] ?>" <?php selected($t['tahun'], $tahun_dokumen) ?>><?= $t['tahun'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label for="tentang">Tentang</label>
					<div class="input-group">
						<input type="text" name="tentang" id="tentang" class="form-control form-control-sm">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary btn-sm" type="submit"><i class="fa fa-search"></i> Cari</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<table class="table table-striped table-bordered no-after" id="produkHukumTable">
		<thead>
			<tr>
				<th>Judul Produk Hukum</th>
				<th>Jenis</th>
				<th>Tahun</th>
			</tr>
		</thead>
		<tbody id="tbody-dokumen">
		</tbody>
	</table>

	<script src="<?= base_url() ?>assets/bootstrap/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#produkHukumTable').DataTable({
				"dom": 'rt<"bottom"p><"clear">',
				"destroy": true,
				"paging": false,
				"ordering": false,
				language: {
					decimal: '.',
					thousands: ',',
					lengthMenu: 'Tampilkan _MENU_ data perhalaman',
					zeroRecords: 'Data tidak ditemukan',
					info: '_START_ - _END_ dari _TOTAL_ data',
					infoEmpty: 'Data tidak ditemukan',
					infoFiltered: '(filtered from _MAX_ total records)',
					sSearch: 'Cari:',
					oPaginate: {
						sFirst: 'Awal',
						sLast: 'Akhir',
						sNext: '>',
						sPrevious: '<',
					},
				},
			});

			get_table();
		});

		function get_table() {
			var url = "<?= site_url('first/ajax_table_peraturan') ?>";

			$.ajax({
				type: "GET",
				url: url,
				dataType: "JSON",
				success: function(data) {
					var html;
					if (data.length == 0) {
						html = "<tr><td colspan='3' align='center'>Data tidak tersedia</td></tr>";
					}
					for (var i = 0; i < data.length; i++) {
						html += "<tr>" + "<td><a href='<?= site_url('dokumen_web/unduh_berkas/') ?>" + data[i].id + "'>" + data[i].nama + "</a></td>" +
							"<td>" + data[i].kategori + "</td>" +
							"<td>" + data[i].tahun + "</td>";
					}
					$('#tbody-dokumen').html(html);
					$('.loading-data').hide();
				},
				error: function(err, jqxhr, errThrown) {
					console.log(err);
					$('.loading-data').hide();
				}
			})
		}

		function formAction() {
			$('#tbody-dokumen').html('');
			var url = "<?= site_url('first/filter_peraturan') ?>";
			var kategori = $('#kategori').val();
			var tahun = $('#tahun').val();
			var tentang = $('#tentang').val();

			$.ajax({
				type: "POST",
				url: url,
				data: {
					kategori: kategori,
					tahun: tahun,
					tentang: tentang
				},
				dataType: "JSON",
				success: function(data) {
					var html;
					if (data.length == 0) {
						html = "<tr><td colspan='3' align='center'>Data tidak tersedia</td></tr>";
					}
					for (var i = 0; i < data.length; i++) {
						html += "<tr>" + "<td><a href='<?= site_url('dokumen_web/unduh_berkas/') ?>" + data[i].id + "'>" + data[i].nama + "</a></td>" +
							"<td>" + data[i].kategori + "</td>" +
							"<td>" + data[i].tahun + "</td>";
					}
					$('#tbody-dokumen').html(html);
				},
				error: function(err, jqxhr, errThrown) {
					console.log(err);
				}
			})
		}
	</script>