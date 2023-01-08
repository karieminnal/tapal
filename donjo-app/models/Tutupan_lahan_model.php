<?php
class Tutupan_lahan_model extends MY_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function paging($p = 1)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$this->main_sql();
		$jml = $this->db->select('t.id')->where('t.id_desa', $filterDesa)->get()->num_rows();

		$this->load->library('paging');
		$cfg['page'] = $p;
		$cfg['per_page'] = $_SESSION['per_page'];
		$cfg['num_rows'] = $jml;
		$this->paging->init($cfg);

		return $this->paging;
	}

	private function filter_sql()
	{
		if (isset($_SESSION['tutupan_lahan_jenis'])) {
			$this->db->where('jenis', $_SESSION['tutupan_lahan_jenis']);
		}
	}

	private function main_sql()
	{
		$this->db->from('tutupan_lahan t');
		$this->filter_sql();
	}

	public function list_data($offset = 0, $per_page)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$this->main_sql();
		$data = $this->db->select('t.*, j.nama as jenis_nama')
			->join('tutupan_lahan_jenis j', 'j.id = t.jenis')
			->where('t.id_desa', $filterDesa)
			->limit($per_page, $offset)
			->get()
			->result_array();

		$j = $offset;
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $j + 1;
			$j++;
		}

		return $data;
	}

	public function list_tutupan_lahan_api()
	{
		$data = $this->db
			->select('p.id AS id, p.path AS path, p.deskripsi AS deskripsi, p.luas AS luas, p.pemilik AS pemilik, p.kelas AS kelas, p.alamat AS alamat')
			->select('j.nama AS jenis, j.warna AS warna')
			->from('tutupan_lahan p')
			->join('tutupan_lahan_jenis j', 'j.id = p.jenis')
			->get()->result_array();
		return $data;
	}

	public function list_tutupan_lahan_api_jenis()
	{
		$data = $this->db
			->select('*')
			->from('tutupan_lahan_jenis')
			->get()->result_array();
		return $data;
	}

	public function list_tutupan_lahan_api_jenis_fe()
	{
		$data = $this->db
		->select('p.id AS id')
		->select('j.id AS jenis_id, j.nama AS jenis_nama, j.warna AS jenis_warna')
		->from('tutupan_lahan_jenis j')
		->join('tutupan_lahan p', 'j.id = p.jenis')
		->group_by('jenis_nama')
		->get()->result_array();
		return $data;
	}

	public function get_tutupan_lahan($id)
	{
		$data = $this->db->select('t.*')
			->from('tutupan_lahan t')
			->where('t.id', $id)
			->get()->row_array();
		return $data;
	}

	public function get_tutupan_lahan_jenis($jenis)
	{
		$data = $this->db->select('t.*')
			->from('tutupan_lahan t')
			->where('t.jenis', $jenis)
			->get()->result_array();
		return $data;
	}

	public function get_tutupan_lahan_desa_jenis($desaid, $jenis)
	{
		$data = $this->db->select('t.*')
			->from('tutupan_lahan t')
			->where('t.jenis', $jenis)
			->where('t.id_desa', $desaid)
			->get()->result_array();
		return $data;
	}

	public function get_tutupan_lahan_bydusun($desaid, $jenis, $dusun ='')
	{
		// $data = $this->db->select('t.*')
		// 	->from('tutupan_lahan t')
		// 	->where('t.jenis', $jenis)
		// 	->where('t.id_desa', $desaid)
		// 	->get()->result_array();

		$sql = "SELECT *, FROM tutupan_lahan 
		WHERE jenis = '$jenis' AND id_desa = '$desaid' ";

		if($dusun !== '') {
			$cari = $dusun;
			$kw = $this->db->escape_like_str($cari);
			$kw = '%' . $kw . '%';
			$data .= " AND l.nama LIKE '$kw'";
			// $this->db->where('alamat', $dusun);
		}
		// $sql .= $order_sql;
		// $sql .= $paging_sql;

		$query = $this->db->query($sql);
		$data = $query->result_array();
		// return $data;
		return $data;
	}


	public function list_sawah_bydusun($desaid, $jenis, $dusun)
	{
		$sql = "SELECT * FROM tutupan_lahan WHERE jenis = '$jenis' AND id_desa = '$desaid' AND alamat LIKE '%" .$this->db->escape_like_str(urldecode($dusun))."%'";

		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	public function import()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$this->db->where('jenis', $_POST['jenis']);
		// $this->db->where('id_desa', $filterDesa);
		// $this->db->delete('tutupan_lahan');
		// $this->db->reset_query();
		$data = json_decode($_POST['more_info'], true);
		foreach ($data as &$k) {
			$k['jenis'] = $_POST['jenis'];
			$k['id_desa'] = $filterDesa;
			$k['luas'] = $k['props']['Luas'];
			$k['pemilik'] = $k['props']['Pemilik'];
			$k['kelas'] = $k['props']['Kelas'];
			$k['alamat'] = $k['props']['Alamat'];
			$k['deskripsi'] = $k['props']['more_info'];
			unset($k['props']);
		}
		$outp = $this->db->insert_batch('tutupan_lahan', $data);

		status_sukses($outp); //Tampilkan Pesan
	}
	public function update_deskripsi()
	{
		$this->db->set('deskripsi', $_POST['more_info']);
		$this->db->set('tgl_diupdate', 'NOW()', FALSE);
		$this->db->set('jenis', $_POST['jenis']);
		$this->db->set('luas', $_POST['luas']);
		$this->db->set('pemilik', $_POST['pemilik']);
		$this->db->set('kelas', $_POST['kelas']);
		$this->db->where('id', $_POST['id']);
		$outp = $this->db->update('tutupan_lahan');
		status_sukses($outp);
	}

	public function delete($id = '', $semua = false)
	{
		if (!$semua) $this->session->success = 1;
		$filterDesa = $_SESSION['filterDesa'];
		$outp = $this->db->where('jenis', $id)
		->where('id_desa', $filterDesa)
		->delete('tutupan_lahan');

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
}
