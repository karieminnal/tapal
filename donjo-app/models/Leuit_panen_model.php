<?php

class Leuit_panen_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function autocomplete()
	{
		return $this->autocomplete_str('sawah', 'leuit_produksi');
	}

	private function main_sql()
	{
		$this->db->from('leuit_produksi l');
		$this->filter_sql();
	}

	private function search_sql()
	{
		if (isset($_SESSION['cari'])) {
			$cari = $_SESSION['cari'];
			$kw = $this->db->escape_like_str($cari);
			$kw = '%' . $kw . '%';
			$search_sql = " AND l.sawah LIKE '$kw'";
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
			, p.pemilik AS pemilik, p.kelas AS kelas, p.luas AS luas, p.path AS path
			FROM leuit_produksi l
			LEFT JOIN tutupan_lahan p ON l.sawah = p.id 
			WHERE 1 ";

		$sql .= $this->search_sql();
		$sql .= $this->filter_sql();
		return $sql;
	}

	private function filterTahun($year)
	{
		$sql = " AND YEAR(l.tanggal_produksi) = $year";
		return $sql;
	}

	private function filterSawah($sawah)
	{
		$sql = " AND l.sawah = $sawah";
		return $sql;
	}

	private function filterDusun($dusun)
	{
		$sql = " AND l.dusun = $dusun";
		return $sql;
	}

	public function list_data($offset = 0, $per_page, $year, $sawah, $dusun, $desaid)
	{
		// switch ($o) {
		// 	case 1:
		// 		$order_sql = ' ORDER BY l.sawah';
		// 		break;
		// 	case 2:
		// 		$order_sql = ' ORDER BY l.sawah DESC';
		// 		break;
		// 	default:
		// 		$order_sql = ' ORDER BY l.id';
		// }
		// $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

		// $sql = "SELECT l.* " . $this->list_data_sql();
		// $sql .= $order_sql;
		// $sql .= $paging_sql;

		// $query = $this->db->query($sql);
		// $data = $query->result_array();

		// $j = $offset;
		// for ($i = 0; $i < count($data); $i++) {
		// 	$data[$i]['no'] = $j + 1;
		// 	if ($data[$i]['enabled'] == 1)
		// 		$data[$i]['aktif'] = "Ya";
		// 	else
		// 		$data[$i]['aktif'] = "Tidak";
		// 	$j++;
		// }
		// return $data;
		// $this->main_sql();
		// $data = $this->db->select('l.*, p.pemilik AS pemilik, p.kelas AS kelas, p.luas AS luas, p.path AS path')
		// ->join('tutupan_lahan p', 'p.id = l.sawah')
		// ->limit($per_page, $offset)
		// ->get()
		// ->result_array();

		$sql = "SELECT l.*, p.pemilik AS pemilik, p.kelas AS kelas, p.luas AS luas, p.path AS path, EXTRACT(year FROM l.tanggal_produksi) AS tahun, t.dusun AS dusun, c.nama_desa AS nama_desa, c.nama_kabupaten AS nama_kabupaten
			FROM leuit_produksi l 
			LEFT JOIN tutupan_lahan p ON l.sawah = p.id 
			LEFT JOIN tweb_wil_clusterdesa t ON l.dusun = t.id 
			LEFT JOIN config c ON l.id_desa = c.id 
			WHERE l.id != 0";
		
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		
		if($year) {
			$sql .= $this->filterTahun($year);
		}
		if($sawah) {
			$sql .= $this->filterSawah($sawah);
			$sql .= ' ORDER BY l.tanggal_produksi ASC';
		} else if($dusun) {
			$sql .= $this->filterDusun($dusun);
			$sql .= ' ORDER BY l.id ASC';
		} else {
			$sql .= ' ORDER BY l.tanggal_produksi DESC';
		}

		$query = $this->db->query($sql);
		$data = $query->result_array();

		$j = $offset;
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $j + 1;
			$j++;
		}

		return $data;
	}

	public function list_data_all($desaid)
	{
		$sql = "SELECT l.*, p.pemilik AS pemilik, p.kelas AS kelas, p.luas AS luas, p.path AS path, EXTRACT(year FROM l.tanggal_produksi) AS tahun, t.dusun AS dusun, c.nama_desa AS nama_desa, c.nama_kabupaten AS nama_kabupaten
			FROM leuit_produksi l 
			LEFT JOIN tutupan_lahan p ON l.sawah = p.id 
			LEFT JOIN tweb_wil_clusterdesa t ON l.dusun = t.id 
			LEFT JOIN config c ON l.id_desa = c.id 
			WHERE l.id != 0";
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		$sql .= ' ORDER BY l.tanggal_produksi DESC';

		$query = $this->db->query($sql);
		$data = $query->result_array();

		$j = $offset;
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $j + 1;
			$j++;
		}

		return $data;
	}

	public function list_data_id($id)
	{
		switch ($o) {
			case 1:
				$order_sql = ' ORDER BY l.sawah';
				break;
			case 2:
				$order_sql = ' ORDER BY l.sawah DESC';
				break;
			default:
				$order_sql = ' ORDER BY l.id';
		}
		$paging_sql = ' LIMIT ' . $offset . ',' . $limit;

		$sql = "SELECT l.* " . $this->list_data_sql();
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
	
	public function get_total_produksi($year,$sawah, $dusun, $desaid)
	{
		$sql = "SELECT l.*, SUM(l.jumlah_panen) AS TOTAL_ALL 
			FROM leuit_produksi l 
			WHERE l.id != 0";
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		if($year) {
			$sql .= $this->filterTahun($year);
		}
		if($sawah) {
			$sql .= $this->filterSawah($sawah);
		}
		if($dusun) {
			$sql .= $this->filterDusun($dusun);
		}
		$sql .= ' GROUP BY l.id';
		$query = $this->db->query($sql);
		$data = $query->result_array();

		return $data;
	}
	
	public function get_total_produksi_row($year,$sawah, $dusun, $desaid)
	{
		$sql = "SELECT l.*, SUM(l.jumlah_panen) AS TOTAL_ALL 
			FROM leuit_produksi l 
			WHERE l.id != 0";
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		if($year) {
			$sql .= $this->filterTahun($year);
		}
		if($sawah) {
			$sql .= $this->filterSawah($sawah);
		}
		if($dusun) {
			$sql .= $this->filterDusun($dusun);
		}
		$sql .= ' GROUP BY l.id';
		$query = $this->db->query($sql);
		$data = $query->row_array();

		return $data;
	}
	
	
	public function get_total_by_sawah($offset = 0, $per_page, $year, $sawah, $dusun, $tampilsawah, $desaid)
	{
		// $this->main_sql();
		// $data = $this->db
		// 	->select('l.*, p.pemilik AS pemilik, p.kelas AS kelas, p.luas AS luas, SUM(l.jumlah_panen) AS TOTAL')
		// 	->join('tutupan_lahan p', 'p.id = l.sawah')
		// 	->group_by('l.sawah')
		// 	->order_by('l.id ASC')
		// 	->get()->result_array();

		$sql = "SELECT l.*, p.pemilik AS pemilik, p.kelas AS kelas, p.luas AS luas, SUM(l.jumlah_panen) AS TOTAL, t.dusun AS dusun, c.nama_desa AS nama_desa, c.nama_kabupaten AS nama_kabupaten
			FROM leuit_produksi l 
			LEFT JOIN tutupan_lahan p ON l.sawah = p.id 
			LEFT JOIN tweb_wil_clusterdesa t ON l.dusun = t.id 
			LEFT JOIN config c ON l.id_desa = c.id 
			WHERE l.id != 0";
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		if($tampilsawah) {
			$sql .= ' GROUP BY EXTRACT(year FROM l.tanggal_produksi)';
			// $sql .= ' ORDER BY l.tanggal_produksi ASC';
		} else {
			if(isset($_REQUEST['sawah'],$_REQUEST['year'],$_REQUEST['dusun'])) {
				$sql .= $this->filterTahun($year);
				$sql .= $this->filterSawah($sawah);
				$sql .= $this->filterDusun($dusun);
				$sql .= ' GROUP BY l.id';
			} else {
				if($year) {
					$sql .= $this->filterTahun($year);
					$sql .= ' GROUP BY l.sawah';
				} else if($sawah) {
					$sql .= $this->filterSawah($sawah);
					$sql .= ' GROUP BY EXTRACT(year FROM l.tanggal_produksi)';
				} else if($dusun) {
					$sql .= $this->filterDusun($dusun);
					$sql .= ' GROUP BY l.id';
				} else if($desaid) {
					$sql .= ' GROUP BY t.dusun';
				} else {
					$sql .= ' GROUP BY l.id_desa';
				}
			}
		}
		// if(!isset($_REQUEST['ts'],$_REQUEST['sawah'],$_REQUEST['year'])) {
		// 	$sql .= ' GROUP BY l.sawah';
		// }
		$sql .= ' ORDER BY l.tanggal_produksi ASC';
		$query = $this->db->query($sql);
		$data = $query->result_array();

		$j = $offset;
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $j + 1;
			$j++;
		}

		return $data;
	}
	
	public function get_total_by_dusun($offset = 0, $per_page, $year, $sawah, $dusun, $tampilsawah, $desaid)
	{
		// $this->main_sql();
		// $data = $this->db
		// 	->select('l.*, p.pemilik AS pemilik, p.kelas AS kelas, p.luas AS luas, SUM(l.jumlah_panen) AS TOTAL')
		// 	->join('tutupan_lahan p', 'p.id = l.sawah')
		// 	->group_by('l.sawah')
		// 	->order_by('l.id ASC')
		// 	->get()->result_array();

		$sql = "SELECT l.*, p.pemilik AS pemilik, p.kelas AS kelas, p.luas AS luas, SUM(l.jumlah_panen) AS TOTAL, t.dusun AS dusun, c.nama_desa AS nama_desa, c.nama_kabupaten AS nama_kabupaten
			FROM leuit_produksi l 
			LEFT JOIN tutupan_lahan p ON l.sawah = p.id 
			LEFT JOIN tweb_wil_clusterdesa t ON l.dusun = t.id 
			LEFT JOIN config c ON l.id_desa = c.id 
			WHERE l.id != 0";
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		if($tampilsawah) {
			$sql .= ' GROUP BY EXTRACT(year FROM l.tanggal_produksi)';
			// $sql .= ' ORDER BY l.tanggal_produksi ASC';
		} else {
			if(isset($_REQUEST['sawah'],$_REQUEST['year'])) {
				$sql .= $this->filterTahun($year);
				$sql .= $this->filterSawah($sawah);
				$sql .= ' GROUP BY l.id';
			} else if(isset($_REQUEST['dusun'],$_REQUEST['year'])) {
				$sql .= $this->filterTahun($year);
				$sql .= $this->filterDusun($dusun);
				$sql .= ' GROUP BY l.sawah';
			} else {
				if($year) {
					$sql .= $this->filterTahun($year);
					$sql .= ' GROUP BY l.dusun';
				} else if($sawah) {
					$sql .= $this->filterSawah($sawah);
					$sql .= ' GROUP BY EXTRACT(year FROM l.tanggal_produksi)';
				} else if($dusun) {
					$sql .= $this->filterDusun($dusun);
					$sql .= ' GROUP BY l.id';
				} else if($desaid) {
					$sql .= ' GROUP BY t.dusun';
				} else {
					$sql .= ' GROUP BY l.id_desa';
				}
			}
		}
		// if(!isset($_REQUEST['ts'],$_REQUEST['sawah'],$_REQUEST['year'])) {
		// 	$sql .= ' GROUP BY l.sawah';
		// }
		$sql .= ' ORDER BY l.tanggal_produksi ASC';
		$query = $this->db->query($sql);
		$data = $query->result_array();

		$j = $offset;
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $j + 1;
			$j++;
		}

		return $data;
	}
	
	public function get_panen_tahun($desaid)
	{

		$sql = "SELECT l.*, p.pemilik AS pemilik, p.kelas AS kelas, p.luas AS luas, SUM(l.jumlah_panen) AS TOTAL, t.dusun AS dusun, c.nama_desa AS nama_desa, c.nama_kabupaten AS nama_kabupaten
			FROM leuit_produksi l 
			LEFT JOIN tutupan_lahan p ON l.sawah = p.id 
			LEFT JOIN tweb_wil_clusterdesa t ON l.dusun = t.id 
			LEFT JOIN config c ON l.id_desa = c.id 
			WHERE l.id != 0";
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		$sql .= ' GROUP BY EXTRACT(year FROM l.tanggal_produksi)';
		$sql .= ' ORDER BY l.tanggal_produksi ASC';
		$query = $this->db->query($sql);
		$data = $query->result_array();

		$j = $offset;
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $j + 1;
			$j++;
		}

		return $data;
	}

	private function validasi($post)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data['tanggal_produksi'] = tgl_indo_in($post['tanggal_produksi']);
		$data['sawah'] = $post['sawah'];
		$data['harga'] = $post['harga'];
		$data['jumlah_panen'] = $post['jumlah_panen'];
		$data['dusun'] = $post['dusun_id'];
		$data['id_desa'] = $filterDesa;

		return $data;
	}

	public function insert()
	{
		$data = $this->validasi($this->input->post());
		$outp = $this->db->insert('leuit_produksi', $data);

		if ($outp)
			$_SESSION['success'] = 1;
		else
			$_SESSION['success'] = -1;
	}

	public function update($id = 0)
	{
		$data = $this->validasi($this->input->post());
		$this->db->where('id', $id);
		$outp = $this->db->update('leuit_produksi', $data);
		status_sukses($outp); //Tampilkan Pesan
	}

	public function delete($id = '', $semua = false)
	{
		if (!$semua) $this->session->success = 1;
		$outp = $this->db->where('id', $id)->delete('leuit_produksi');
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

	public function get_produksi($id = 0)
	{
		$this->main_sql();
		$data = $this->db->select('l.*, p.pemilik AS pemilik, p.kelas AS kelas, p.luas AS luas, p.path AS path')
		->join('tutupan_lahan p', 'p.id = l.sawah')
		->where('l.id', $id)
		->get()
		->row_array();

		// $data = $this->db
		// 	->select('l.*,')
		// 	->select('c.rt AS rt, c.rw as rw, c.dusun as dusun')
		// 	->from('leuit_lokasi l')
		// 	->join('tweb_wil_clusterdesa c', 'l.id_cluster = c.id', 'left')
		// 	->where('l.id', $id)
		// 	->get()->row_array();
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

	// mobile app sementara
	private function validasiApp($post)
	{
		$data['tanggal_produksi'] = tgl_indo_in($post['tanggal_produksi']);
		$data['sawah'] = $post['sawah'];
		$data['harga'] = $post['harga'];
		$data['jumlah_panen'] = $post['jumlah_panen'];
		$data['dusun'] = $post['dusun'];
		$data['id_desa'] = 2;

		return $data;
	}

	public function insertApp()
	{
		$data = $this->validasiApp($this->input->post());
		$outp = $this->db->insert('leuit_produksi', $data);

		if ($outp)
			$_SESSION['success'] = 1;
		else
			$_SESSION['success'] = -1;
	}
}
