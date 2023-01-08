<?php

class Leuit_analisa_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function autocomplete()
	{
		return $this->autocomplete_str('sawah', 'leuit_analisa');
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
			FROM leuit_analisa l
			LEFT JOIN tutupan_lahan p ON l.sawah = p.id 
			WHERE 1 ";

		$sql .= $this->search_sql();
		$sql .= $this->filter_sql();
		return $sql;
	}

	private function filterTahun($year)
	{
		$sql = " AND YEAR(l.tanggal_analisa) = $year";
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

	public function list_data_input($year, $desaid)
	{
		$sql = "SELECT l.*, p.pemilik AS pemilik, p.kelas AS kelas, p.luas AS luas, p.path AS path, 
			EXTRACT(year FROM l.tanggal_produksi) AS tahun, t.dusun AS dusun, c.nama_desa AS nama_desa, c.nama_kabupaten AS nama_kabupaten, 
			SUM(l.jumlah_panen) AS TOTAL_ALL 
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
		$sql .= ' GROUP BY l.id_desa';
		$sql .= ' ORDER BY l.tanggal_produksi DESC';

		$query = $this->db->query($sql);
		$data = $query->result_array();

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

		$query = $this->db->query($sql);
		$data = $query->result_array();

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
}
