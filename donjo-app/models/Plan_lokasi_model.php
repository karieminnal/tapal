<?php

class Plan_lokasi_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function autocomplete()
	{
		return $this->autocomplete_str('nama', 'lokasi');
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
		$filterDesa = $_SESSION['filterDesa'];
		$sql = "SELECT COUNT(l.id) AS id " . $this->list_data_sql($filterDesa);
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

	private function list_data_sql($filterDesa)
	{
		// $filterDesa = $_SESSION['filterDesa'];
		$sql = "
			, c.rt AS rt, c.rw AS rw, c.dusun AS dusun, c.path AS path
			FROM lokasi l
			LEFT JOIN point p ON l.ref_point = p.id
			LEFT JOIN point m ON p.parrent = m.id
			LEFT JOIN tweb_wil_clusterdesa c ON l.id_cluster = c.id
			WHERE l.id_desa = '$filterDesa' ";
		// $sql .= " AND l.id_desa = $filterDesa ";

		$sql .= $this->search_sql();
		$sql .= $this->filter_sql();
		$sql .= $this->point_sql();
		$sql .= $this->subpoint_sql();
		return $sql;
	}

	public function list_data($o = 0, $offset = 0, $limit = 1000)
	{
		$filterDesa = $_SESSION['filterDesa'];
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

		$sql = "SELECT l.*, p.nama AS kategori, m.nama AS jenis, p.simbol AS simbol, c.rt AS rt, c.rw AS rw, c.dusun AS dusun, c.path AS path
		FROM lokasi l
		LEFT JOIN point p ON l.ref_point = p.id
		LEFT JOIN point m ON p.parrent = m.id
		LEFT JOIN tweb_wil_clusterdesa c ON l.id_cluster = c.id
		WHERE c.id_desa = '$filterDesa' ";
		// $sql .= $order_sql;
		// $sql .= $paging_sql;

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
		$filterDesa = $_SESSION['filterDesa'];
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

		$sql = "SELECT l.*, p.nama AS kategori, m.nama AS jenis, p.simbol AS simbol " . $this->list_data_sql($filterDesa);
		// $sql .= " AND c.id_desa = $filterDesa";
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

	private function validasi($post)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data['nama'] = nomor_surat_keputusan($post['nama']);
		$data['ref_point'] = $post['ref_point'];
		$data['desk'] = htmlentities($post['desk']);
		$data['enabled'] = $post['enabled'];
		$data['id_cluster'] = $post['id_cluster'];
		$data['nama_jalan'] = $post['nama_jalan'];
		$data['id_desa'] = $filterDesa;

		return $data;
	}

	public function insert()
	{
		$data = $this->validasi($this->input->post());
		$lokasi_file = $_FILES['foto']['tmp_name'];
		$tipe_file = $_FILES['foto']['type'];
		$nama_file = $_FILES['foto']['name'];
		$nama_file = str_replace(' ', '-', $nama_file); 	 // normalkan nama file
		if (!empty($lokasi_file)) {
			if ($tipe_file == "image/jpg" or $tipe_file == "image/jpeg" or $tipe_file == "image/png" or $tipe_file == "image/x-png") {
				UploadLokasi($nama_file);
				$data['foto'] = $nama_file;
				$outp = $this->db->insert('lokasi', $data);
			}
		} else {
			unset($data['foto']);
			$outp = $this->db->insert('lokasi', $data);
		}

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
		if (!empty($lokasi_file)) {
			if ($tipe_file == "image/jpg" or $tipe_file == "image/jpeg" or $tipe_file == "image/png" or $tipe_file == "image/x-png") {
				UploadLokasi($nama_file);
				$data['foto'] = $nama_file;
				$this->db->where('id', $id);
				$outp = $this->db->update('lokasi', $data);
			}
		} else {
			unset($data['foto']);
			$this->db->where('id', $id);
			$outp = $this->db->update('lokasi', $data);
		}
		status_sukses($outp); //Tampilkan Pesan
	}

	public function delete($id = '', $semua = false)
	{
		if (!$semua) $this->session->success = 1;

		$outp = $this->db->where('id', $id)->delete('lokasi');

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

	public function import()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = json_decode($_POST['extract_data'], true);
		foreach ($data as &$k) {
			$k['nama'] = $k['props']['nama_lokas'];
			$k['ref_point'] = $k['props']['id_jenis'];
			$k['id_cluster'] = $k['props']['id_cluster'];
			$k['id_desa'] = $filterDesa;
			$k['lat'] = $k['props']['lat'];
			$k['lng'] = $k['props']['lng'];
			unset($k['props']);
		}
		$outp = $this->db->insert_batch('lokasi', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function list_point()
	{
		$filterDesa = $_SESSION['filterDesa'];
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
		$sql = "UPDATE lokasi SET enabled = ? WHERE id = ?";
		$outp = $this->db->query($sql, array($val, $id));

		status_sukses($outp); //Tampilkan Pesan
	}

	public function get_lokasi($id = 0)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db
			->select('l.*,')
			->select('c.rt AS rt, c.rw as rw, c.dusun as dusun')
			->from('lokasi l')
			->join('tweb_wil_clusterdesa c', 'l.id_cluster = c.id', 'left')
			->where('l.id', $id)
			->where('c.id_desa', $filterDesa)
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
			->from('lokasi l')
			->join('point p', 'l.ref_point = p.id', 'left')
			->join('point m', 'p.parrent = m.id', 'left')
			->join('tweb_wil_clusterdesa c', 'l.id_cluster = c.id', 'left')
			->where('m.id', $id)
			->get()->result_array();
		return $data;
	}

	public function get_lokasi_by_dusun($dusun, $jenis, $kategori)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$this->db
			->select('l.*, l.nama AS nama_sarana, l.desk AS desk_sarana')
			->select('m.nama AS jenis')
			->select('m.id AS jenis_id')
			->select('p.nama AS kategori')
			->select('c.rt AS rt, c.rw as rw, c.dusun as dusun')
			->from('lokasi l')
			->join('point p', 'l.ref_point = p.id', 'left')
			->join('point m', 'p.parrent = m.id', 'left')
			->join('tweb_wil_clusterdesa c', 'l.id_cluster = c.id', 'left');
		if (!empty($filterDesa)) $this->db->where('c.id_desa', $filterDesa);
		if (!empty($dusun)) $this->db->where('c.dusun', $dusun);
		if (!empty($jenis)) $this->db->where('m.nama', $jenis);
		if (!empty($kategori)) $this->db->where('p.nama', $kategori);

		$data = $this->db->get()->result_array();
		return $data;
	}

	public function update_position($id = 0)
	{
		$data['lat'] = koordinat($this->input->post('lat'));
		$data['lng'] = koordinat($this->input->post('lng'));
		$this->db->where('id', $id);
		$outp = $this->db->update('lokasi', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function list_dusun()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$sql = "SELECT * FROM tweb_wil_clusterdesa WHERE rt = '0' AND rw = '0' AND id_desa = $filterDesa";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function list_lokasi()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db
			->select('l.*, p.nama AS kategori, m.nama AS jenis, p.simbol AS simbol, p.nama AS kategori, d.dusun AS dusun')
			->from('lokasi l')
			->join('point p', 'l.ref_point = p.id', 'left')
			->join('point m', 'p.parrent = m.id', 'left')
			->join('tweb_wil_clusterdesa d', 'l.id_cluster = d.id', 'left')
			->where('l.enabled = 1')
			->where('p.enabled = 1')
			->where('m.enabled = 1')
			->where('d.id_desa', $filterDesa)
			->get()->result_array();
		return $data;
	}

	public function list_lokasi_api($desaId)
	{
		$this->db
			->select('l.*, p.nama AS kategori, m.nama AS jenis, p.simbol AS simbol, p.nama AS kategori, d.dusun AS dusun, c.nama_desa AS nama_desa')
			->from('lokasi l')
			->join('point p', 'l.ref_point = p.id', 'left')
			->join('point m', 'p.parrent = m.id', 'left')
			->join('tweb_wil_clusterdesa d', 'l.id_cluster = d.id', 'left')
			->join('config c', 'd.id_desa = c.id', 'left')
			->where('l.enabled = 1')
			->where('p.enabled = 1')
			->where('m.enabled = 1');
		if($desaId) {
			$this->db->where("d.id_desa", $desaId);
		}
		$data = $this->db->get()->result_array();
		return $data;
	}

	public function jumlah_by_kat($ref_point, $desaId)
	{
		$this->db
			->select('COUNT(l.id) AS jumlah')
			->from('lokasi l')
			->join('point p', 'l.ref_point = p.id', 'left')
			->join('point m', 'p.parrent = m.id', 'left')
			->join('tweb_wil_clusterdesa d', 'l.id_cluster = d.id', 'left')
			->join('config c', 'd.id_desa = c.id', 'left')
			->where('l.enabled = 1')
			->where('l.ref_point', $ref_point)
			->where('p.enabled = 1')
			->where('m.enabled = 1');
		if($desaId) {
			$this->db->where("d.id_desa", $desaId);
		}
		$data = $this->db->get()->result_array();
		return $data;
	}

	public function list_lokasi_kat($kategori)
	{
		$data = $this->db
			->select('l.*, p.nama AS kategori, m.nama AS jenis, p.simbol AS simbol')
			->from('lokasi l')
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
			->from('lokasi l')
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
