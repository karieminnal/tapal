<?php
class Leuit_sawah_model extends MY_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function paging($p = 1)
	{
		$this->main_sql();
		$jml = $this->db->select('t.id')->get()->num_rows();

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
		$this->db->from('leuit_sawah t');
		$this->filter_sql();
	}

	public function list_data($offset = 0, $per_page)
	{
		$this->main_sql();
		$data = $this->db->select('t.*, j.nama as jenis_nama')
			->join('tutupan_lahan_jenis j', 'j.id = t.jenis')
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

	public function list_leuit_sawah_api()
	{
		$data = $this->db
			->select('p.id AS id, p.path AS path, p.deskripsi AS deskripsi, p.pemilik AS pemilik, p.luas AS luas')
			->select('j.nama AS jenis, j.warna AS warna')
			->from('leuit_sawah p')
			->join('tutupan_lahan_jenis j', 'j.id = p.jenis')
			->get()->result_array();
		return $data;
	}

	public function list_leuit_sawah_api_jenis()
	{
		$data = $this->db
			->select('*')
			->from('tutupan_lahan_jenis')
			->get()->result_array();
		return $data;
	}

	public function get_leuit_sawah($id)
	{
		$data = $this->db->select('t.*')
			->from('leuit_sawah t')
			->where('t.id', $id)
			->get()->row_array();
		return $data;
	}

	public function import()
	{
		$this->db->where('jenis', $_POST['jenis']);
		$this->db->delete('leuit_sawah');
		$this->db->reset_query();
		$data = json_decode($_POST['more_info'], true);
		foreach ($data as &$k) {
			$k['jenis'] = $_POST['jenis'];
			$k['luas'] = $k['props']['Luas'];
			$k['deskripsi'] = $k['props']['more_info'];
			$k['pemilik'] = $k['props']['Pemilik'];
			unset($k['props']);
		}
		$outp = $this->db->insert_batch('leuit_sawah', $data);

		status_sukses($outp); //Tampilkan Pesan
	}
	public function update_deskripsi()
	{
		$this->db->set('deskripsi', $_POST['more_info']);
		$this->db->set('pemilik', $_POST['more_info']);
		$this->db->set('tgl_diupdate', 'NOW()', FALSE);
		$this->db->set('jenis', $_POST['jenis']);
		$this->db->set('luas', $_POST['luas']);
		$this->db->where('id', $_POST['id']);
		$outp = $this->db->update('leuit_sawah');
		status_sukses($outp);
	}

	public function delete($id = '', $semua = false)
	{
		if (!$semua) $this->session->success = 1;

		$outp = $this->db->where('jenis', $id)->delete('leuit_sawah');

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
