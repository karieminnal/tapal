<?php

class Leuit_lokasi_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function autocomplete()
	{
		return $this->autocomplete_str('nama', 'leuit_lokasi');
	}

	private function search_sql()
	{
		if (isset($_SESSION['cari'])) {
			$cari = $_SESSION['cari'];
			$kw = $this->db->escape_like_str($cari);
			$kw = '%' . $kw . '%';
			$search_sql = " AND l.nama LIKE '$kw'";
			return $search_sql;
		}
	}

	private function filter_sql()
	{
		if (isset($_SESSION['filter'])) {
			$kf = $_SESSION['filter'];
			$filter_sql = " AND l.enabled = $kf";
			return $filter_sql;
		}
	}

	private function point_sql()
	{
		if (isset($_SESSION['point'])) {
			$kf = $_SESSION['point'];
			$point_sql = " AND p.id = $kf";
			return $point_sql;
		}
	}

	private function subpoint_sql()
	{
		if (isset($_SESSION['subpoint'])) {
			$kf = $_SESSION['subpoint'];
			$subpoint_sql = " AND m.id = $kf";
			return $subpoint_sql;
		}
	}

	public function paging($p = 1, $o = 0)
	{
		$sql = "SELECT COUNT(l.id) AS id " . $this->list_data_sql();
		$query = $this->db->query($sql);
		$row = $query->row_array();
		$jml_data = $row['id'];

		$this->load->library('paging');
		$cfg['page'] = $p;
		$cfg['per_page'] = $_SESSION['per_page'];
		$cfg['num_rows'] = $jml_data;
		$this->paging->init($cfg);

		return $this->paging;
	}

	private function list_data_sql()
	{
		$sql = "
			, c.rt AS rt, c.rw AS rw, c.dusun AS dusun, c.path AS path
			FROM leuit_lokasi l
			LEFT JOIN tweb_wil_clusterdesa c ON l.id_cluster = c.id
			WHERE 1 ";

		$sql .= $this->search_sql();
		$sql .= $this->filter_sql();
		return $sql;
	}

	public function list_data($o = 0, $offset = 0, $limit = 1000)
	{
		switch ($o) {
			case 1:
				$order_sql = ' ORDER BY nama';
				break;
			case 2:
				$order_sql = ' ORDER BY nama DESC';
				break;
			case 3:
				$order_sql = ' ORDER BY enabled';
				break;
			case 4:
				$order_sql = ' ORDER BY enabled DESC';
				break;
			case 5:
				$order_sql = ' ORDER BY dusun DESC';
				break;
			case 6:
				$order_sql = ' ORDER BY dusun DESC';
				break;
			default:
				$order_sql = ' ORDER BY id';
		}
		$paging_sql = ' LIMIT ' . $offset . ',' . $limit;

		$sql = "SELECT l.*, l.lat AS lat_lokasi, l.lng AS lng_lokasi " . $this->list_data_sql();

		$query = $this->db->query($sql);
		$data = $query->result_array();

		$j = $offset;
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $j + 1;
			if ($data[$i]['enabled'] == 1)
				$data[$i]['aktif'] = "Ya";
			else
				$data[$i]['aktif'] = "Tidak";
			$j++;
		}
		return $data;
	}

	public function list_data_mobile()
	{

		$sql = "SELECT l.*, c.rt AS rt, c.rw AS rw, c.dusun AS dusun, c.path AS path
		FROM leuit_lokasi l
		LEFT JOIN tweb_wil_clusterdesa c ON l.id_cluster = c.id ";

		$query = $this->db->query($sql);
		$data = $query->result_array();

		$j = $offset;
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $j + 1;
			if ($data[$i]['enabled'] == 1)
				$data[$i]['aktif'] = "Ya";
			else
				$data[$i]['aktif'] = "Tidak";
			$j++;
		}
		return $data;
	}

	public function list_data_id($id)
	{
		switch ($o) {
			case 1:
				$order_sql = ' ORDER BY nama';
				break;
			case 2:
				$order_sql = ' ORDER BY nama DESC';
				break;
			case 3:
				$order_sql = ' ORDER BY enabled';
				break;
			case 4:
				$order_sql = ' ORDER BY enabled DESC';
				break;
			case 5:
				$order_sql = ' ORDER BY dusun DESC';
				break;
			case 6:
				$order_sql = ' ORDER BY dusun DESC';
				break;
			default:
				$order_sql = ' ORDER BY id';
		}
		$paging_sql = ' LIMIT ' . $offset . ',' . $limit;

		$sql = "SELECT l.*, " . $this->list_data_sql();
		$sql .= $order_sql;
		$sql .= $paging_sql;

		$query = $this->db->query($sql);
		$data = $query->result_array();

		$j = $offset;
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $j + 1;
			if ($data[$i]['enabled'] == 1)
				$data[$i]['aktif'] = "Ya";
			else
				$data[$i]['aktif'] = "Tidak";
			$j++;
		}
		return $data;
	}

	public function list_data_desaid($desaid)
	{
		$sql = "SELECT l.*, l.id AS id_lokasi, l.id_desa AS id_desa, l.lat AS lat_lokasi, l.lng AS lng_lokasi";
		$sql .= "
		, c.rt AS rt, c.rw AS rw, c.dusun AS dusun, c.path AS path
		FROM leuit_lokasi l
		LEFT JOIN tweb_wil_clusterdesa c ON l.id_cluster = c.id
		WHERE 1 AND c.id_desa = '".$desaid."'";

		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	private function validasi($post)
	{
		$data['nama'] = nomor_surat_keputusan($post['nama']);
		$data['ref_point'] = 0;
		$data['desk'] = htmlentities($post['desk']);
		$data['enabled'] = 1;
		$data['id_cluster'] = $post['id_cluster'];
		$data['nama_jalan'] = $post['nama_jalan'];
		$data['volume'] = $post['volume'];
		$data['tingkat_kekeringan'] = $post['tingkat_kekeringan'];
		// $data['harga'] = $post['harga'];
		$data['id_desa'] = $_SESSION['filterDesa'];

		return $data;
	}

	public function insert()
	{
		$data = $this->validasi($this->input->post());
		$lokasi_file = $_FILES['foto']['tmp_name'];
		$tipe_file = $_FILES['foto']['type'];
		$nama_file = $_FILES['foto']['name'];
		$nama_file = str_replace(' ', '-', $nama_file); 	 // normalkan nama file

		$lokasi_file_pano = $_FILES['foto_pano']['tmp_name'];
		$tipe_file_pano = $_FILES['foto_pano']['type'];
		$nama_file_pano = $_FILES['foto_pano']['name'];
		$nama_file_pano = str_replace(' ', '-', $nama_file_pano); 	 // normalkan nama file

		if (!empty($lokasi_file)) {
			if ($tipe_file == "image/jpg" or $tipe_file == "image/jpeg" or $tipe_file == "image/png" or $tipe_file == "image/x-png") {
				UploadLokasi($nama_file);
				$data['foto'] = $nama_file;
				// $outp = $this->db->insert('leuit_lokasi', $data);
			} else {
				unset($data['foto']);
			}
		}
		if (!empty($lokasi_file_pano)) {
			if ($tipe_file_pano == "image/jpg" or $tipe_file_pano == "image/jpeg" or $tipe_file_pano == "image/png" or $tipe_file_pano == "image/x-png") {
				UploadLokasiPano($nama_file_pano);
				$data['panorama'] = $nama_file_pano;
				// $outp = $this->db->insert('leuit_lokasi', $data);
			} else {
				unset($data['panorama']);
			}
		}

		$outp = $this->db->insert('leuit_lokasi', $data);

		if ($outp)
			$_SESSION['success'] = 1;
		else
			$_SESSION['success'] = -1;
	}

	public function update($id = 0)
	{
		$data = $this->validasi($this->input->post());
		$lokasi_file = $_FILES['foto']['tmp_name'];
		$tipe_file = $_FILES['foto']['type'];
		$nama_file = $_FILES['foto']['name'];
		$nama_file = str_replace(' ', '-', $nama_file); 	 // normalkan nama file

		$lokasi_file_pano = $_FILES['foto_pano']['tmp_name'];
		$tipe_file_pano = $_FILES['foto_pano']['type'];
		$nama_file_pano = $_FILES['foto_pano']['name'];
		$nama_file_pano = str_replace(' ', '-', $nama_file_pano); 	 // normalkan nama file

		if (!empty($lokasi_file)) {
			if ($tipe_file == "image/jpg" or $tipe_file == "image/jpeg" or $tipe_file == "image/png" or $tipe_file == "image/x-png") {
				UploadLokasi($nama_file);
				$data['foto'] = $nama_file;
				// $this->db->where('id', $id);
				// $outp = $this->db->update('leuit_lokasi', $data);
			} else {
				unset($data['foto']);
			}
		}
		
		if (!empty($lokasi_file_pano)) {
			if ($tipe_file_pano == "image/jpg" or $tipe_file_pano == "image/jpeg" or $tipe_file_pano == "image/png" or $tipe_file_pano == "image/x-png") {
				UploadLokasiPano($nama_file_pano);
				$data['panorama'] = $nama_file_pano;
				// $outp = $this->db->insert('leuit_lokasi', $data);
			} else {
				unset($data['panorama']);
			}
		}
		$this->db->where('id', $id);
		$outp = $this->db->update('leuit_lokasi', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function delete($id = '', $semua = false)
	{
		if (!$semua) $this->session->success = 1;

		$outp = $this->db->where('id', $id)->delete('leuit_lokasi');

		status_sukses($outp, $gagal_saja = true); //Tampilkan Pesan
	}

	public function delete_all()
	{
		$this->session->success = 1;

		$id_cb = $_POST['id_cb'];
		foreach ($id_cb as $id) {
			$this->delete($id, $semua = true);
		}
	}

	public function list_point()
	{
		$sql = "SELECT * FROM point WHERE tipe = 2 AND enabled = 1";

		if (isset($_SESSION['subpoint'])) {
			$kf = $_SESSION['subpoint'];
			$sql .= " AND parrent = $kf";
		}

		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function list_subpoint()
	{
		$sql = "SELECT * FROM point WHERE tipe = 0 AND enabled = 1";

		if (isset($_SESSION['point'])) {
			$sqlx = "SELECT * FROM point WHERE id = ?";
			$query = $this->db->query($sqlx, $_SESSION['point']);
			$temp = $query->row_array();

			$kf = $temp['parrent'];
		}

		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function lokasi_lock($id = '', $val = 0)
	{
		$sql = "UPDATE leuit_lokasi SET enabled = ? WHERE id = ?";
		$outp = $this->db->query($sql, array($val, $id));

		status_sukses($outp); //Tampilkan Pesan
	}

	public function get_lokasi($id = 0)
	{
		$data = $this->db
			->select('l.*, l.id as id_lokasi, l.lat as lat, l.lng as lng')
			->select('c.rt AS rt, c.rw as rw, c.dusun as dusun')
			->from('leuit_lokasi l')
			->join('tweb_wil_clusterdesa c', 'l.id_cluster = c.id', 'left')
			->where('l.id', $id)
			->get()->row_array();
		return $data;
	}

	public function get_lokasi_api($id)
	{
		$data = $this->db
			->select('l.*, l.nama AS nama_sarana, l.desk AS desk_sarana')
			->select('m.nama AS jenis')
			->select('m.id AS jenis_id')
			->select('p.nama AS kategori')
			->select('c.rt AS rt, c.rw as rw, c.dusun as dusun, c.path AS path')
			->from('leuit_lokasi l')
			->join('point p', 'l.ref_point = p.id', 'left')
			->join('point m', 'p.parrent = m.id', 'left')
			->join('tweb_wil_clusterdesa c', 'l.id_cluster = c.id', 'left')
			->where('m.id', $id)
			->get()->result_array();
		return $data;
	}

	public function get_lokasi_by_dusun($dusun, $jenis, $kategori)
	{
		$this->db
			->select('l.*, l.nama AS nama_sarana, l.desk AS desk_sarana')
			->select('m.nama AS jenis')
			->select('m.id AS jenis_id')
			->select('p.nama AS kategori')
			->select('c.rt AS rt, c.rw as rw, c.dusun as dusun')
			->from('leuit_lokasi l')
			->join('point p', 'l.ref_point = p.id', 'left')
			->join('point m', 'p.parrent = m.id', 'left')
			->join('tweb_wil_clusterdesa c', 'l.id_cluster = c.id', 'left');
		if (!empty($dusun)) $this->db->where('c.dusun', $dusun);
		if (!empty($jenis)) $this->db->where('m.nama', $jenis);
		if (!empty($kategori)) $this->db->where('p.nama', $kategori);

		$data = $this->db->get()->result_array();
		return $data;
	}

	public function validasi_posisi($post)
	{
		$data['id_desa'] = $post['id_desa'];
		$data['lat'] = $post['lat'];
		$data['lng'] = $post['lng'];
		return $data;
	}

	public function update_position($id_desa = 0)
	{
		$data = $this->validasi_posisi($this->input->post());
		$this->db->where('id_desa', $id_desa);
		$outp = $this->db->update('leuit_lokasi', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function list_dusun()
	{
		$sql = "SELECT * FROM tweb_wil_clusterdesa WHERE rt = '0' AND rw = '0' ";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function list_lokasi()
	{
		$data = $this->db
			->select('l.*, p.nama AS kategori, m.nama AS jenis, p.simbol AS simbol, p.nama AS kategori, d.dusun AS dusun')
			->from('leuit_lokasi l')
			->join('point p', 'l.ref_point = p.id', 'left')
			->join('point m', 'p.parrent = m.id', 'left')
			->join('tweb_wil_clusterdesa d', 'l.id_cluster = d.id', 'left')
			->where('l.enabled = 1')
			->where('p.enabled = 1')
			->where('m.enabled = 1')
			->get()->result_array();
		return $data;
	}

	public function list_lokasi_kat($kategori)
	{
		$data = $this->db
			->select('l.*, p.nama AS kategori, m.nama AS jenis, p.simbol AS simbol')
			->from('leuit_lokasi l')
			->join('point p', 'l.ref_point = p.id', 'left')
			->join('point m', 'p.parrent = m.id', 'left')
			->where('l.enabled = 1')
			->where('p.enabled = 1')
			->where('m.enabled = 1')
			->where('l.ref_point', $kategori)
			->get()->result_array();
		return $data;
	}

	public function list_lokasi_jenis($jenis)
	{
		$data = $this->db
			->select('l.*, p.nama AS kategori, m.nama AS jenis, p.simbol AS simbol')
			->from('leuit_lokasi l')
			->join('point p', 'l.ref_point = p.id', 'left')
			->join('point m', 'p.parrent = m.id', 'left')
			->where('l.enabled = 1')
			->where('p.enabled = 1')
			->where('m.enabled = 1')
			->where('p.parrent', $jenis)
			->get()->result_array();
		return $data;
	}

	public function list_area()
	{
		$data = $this->db
			->select('l.*, p.nama AS kategori, m.nama AS jenis, p.simbol AS simbol, p.color AS color')
			->from('area l')
			->join('polygon p', 'l.ref_polygon = p.id', 'left')
			->join('polygon m', 'p.parrent = m.id', 'left')
			->where('l.enabled', 1)
			->where('p.enabled', 1)
			->where('m.enabled', 1)
			->get()->result_array();
		return $data;
	}

	public function list_garis()
	{
		$data = $this->db
			->select('l.*, p.nama AS kategori, m.nama AS jenis, p.simbol AS simbol, p.color AS color')
			->from('garis l')
			->join('line p', 'l.ref_line = p.id', 'left')
			->join('line m', ' p.parrent = m.id')
			->where('l.enabled', 1)
			->where('p.enabled', 1)
			->where('m.enabled', 1)
			->get()->result_array();
		return $data;
	}
}
