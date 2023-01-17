<?php

class Leuit_distribusi_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function autocomplete()
	{
		return $this->autocomplete_str('sawah', 'leuit_distribusi');
	}

	private function main_sql()
	{
		$this->db->from('leuit_distribusi l');
	}

	private function list_data_sql()
	{
		$sql = " 
			FROM leuit_distribusi l
			LEFT JOIN tutupan_lahan p ON l.sawah = p.id 
			WHERE 1 ";

		return $sql;
	}

	private function filterTahun($year)
	{
		$sql = " AND YEAR(l.tanggal_distribusi) = $year";
		return $sql;
	}

	public function list_data($year, $desaid)
	{

		$sql = "SELECT l.*, EXTRACT(year FROM l.tanggal_distribusi) AS tahun, c.nama_desa AS nama_desa, c.nama_kabupaten AS nama_kabupaten
			FROM leuit_distribusi l 
			LEFT JOIN config c ON l.id_desa = c.id 
			WHERE l.id != 0";
		
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		
		if($year) {
			$sql .= $this->filterTahun($year);
		}
			$sql .= ' ORDER BY l.tanggal_distribusi DESC';

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
		$sql = "SELECT l.*, EXTRACT(year FROM l.tanggal_distribusi) AS tahun, c.nama_desa AS nama_desa, c.nama_kabupaten AS nama_kabupaten
			FROM leuit_distribusi l 
			LEFT JOIN config c ON l.id_desa = c.id 
			WHERE l.id != 0";
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		$sql .= ' ORDER BY l.tanggal_distribusi DESC';

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
		$order_sql = ' ORDER BY l.id';

		$sql = "SELECT l.* " . $this->list_data_sql();

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
	
	public function get_total_distribusi($year, $desaid)
	{
		$sql = "SELECT l.*, SUM(l.jumlah_distribusi) AS TOTAL_ALL 
			FROM leuit_distribusi l 
			WHERE l.id != 0";
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		if($year) {
			$sql .= $this->filterTahun($year);
		}
		// $sql .= ' GROUP BY l.id';

		$query = $this->db->query($sql);
		$data = $query->result_array();

		return $data;
	}
	
	public function get_total_distribusi_row($year, $desaid)
	{
		$sql = "SELECT l.*, SUM(l.jumlah_distribusi) AS TOTAL_ALL 
			FROM leuit_distribusi l 
			WHERE 1";
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		if($year) {
			$sql .= $this->filterTahun($year);
		}
		// $sql .= ' GROUP BY l.id';

		$query = $this->db->query($sql);
		$data = $query->row_array();

		return $data;
	}
	
	public function get_total_distribusi_byjenis($year, $jenis, $desaid)
	{
		$sql = "SELECT l.*, SUM(l.jumlah_distribusi) AS TOTAL 
			FROM leuit_distribusi l 
			WHERE l.id != 0";
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		if($year) {
			$sql .= $this->filterTahun($year);
		}
		// if($jenis) {
		// 	$sql .= ' GROUP BY l.jumlah_distribusi';
		// }
		$sql .= ' GROUP BY l.jenis';

		$query = $this->db->query($sql);
		$data = $query->result_array();

		return $data;
	}
	
	public function get_distribusi_tahun($desaid)
	{

		$sql = "SELECT l.*  
			FROM leuit_distribusi l 
			LEFT JOIN config c ON l.id_desa = c.id 
			WHERE l.id != 0";
		if($desaid) {
			$sql .= " AND l.id_desa = '".$desaid."'";
		}
		$sql .= ' GROUP BY EXTRACT(year FROM l.tanggal_distribusi)';
		$sql .= ' ORDER BY l.tanggal_distribusi ASC';
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
		$data['tanggal_distribusi'] = tgl_indo_in($post['tanggal_distribusi']);
		$data['harga'] = $post['harga'];
		$data['jumlah_distribusi'] = $post['jumlah_distribusi'];
		$data['id_desa'] = $filterDesa;

		return $data;
	}

	public function insert()
	{
		$data = $this->validasi($this->input->post());
		$outp = $this->db->insert('leuit_distribusi', $data);

		if ($outp)
			$_SESSION['success'] = 1;
		else
			$_SESSION['success'] = -1;
	}

	public function update($id = 0)
	{
		$data = $this->validasi($this->input->post());
		$this->db->where('id', $id);
		$outp = $this->db->update('leuit_distribusi', $data);
		status_sukses($outp); //Tampilkan Pesan
	}

	public function delete($id = '', $semua = false)
	{
		if (!$semua) $this->session->success = 1;
		$outp = $this->db->where('id', $id)->delete('leuit_distribusi');
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

	public function get_distribusi($id = 0)
	{
		$this->main_sql();
		$data = $this->db->select('l.*')
		->where('id', $id)
		->get()
		->row_array();
		return $data;
	}

	// mobile app sementara
	private function validasiApp($post)
	{
		$data['tanggal_distribusi'] = tgl_indo_in($post['tanggal_distribusi']);
		$data['harga'] = $post['harga'];
		$data['jenis'] = $post['jenis'];
		$data['jumlah_distribusi'] = $post['jumlah_distribusi'];
		$data['id_desa'] = 2;

		return $data;
	}

	public function insertApp()
	{
		$data = $this->validasiApp($this->input->post());
		$outp = $this->db->insert('leuit_distribusi', $data);

		if ($outp)
			$_SESSION['success'] = 1;
		else
			$_SESSION['success'] = -1;
	}
}
