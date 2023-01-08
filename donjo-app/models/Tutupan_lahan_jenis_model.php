<?php

class Tutupan_lahan_jenis_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function paging($p=1, $o=0)
	{
		$sql = "SELECT COUNT(*) AS jml " . $this->list_data_sql();
		$query = $this->db->query($sql);
		$row = $query->row_array();
		$jml_data = $row['jml'];

		$this->load->library('paging');
		$cfg['page'] = $p;
		$cfg['per_page'] = $_SESSION['per_page'];
		$cfg['num_rows'] = $jml_data;
		$this->paging->init($cfg);

		return $this->paging;
	}

	private function list_data_sql()
	{
		$sql = " FROM tutupan_lahan_jenis";
		return $sql;
	}

	public function list_data($o=0, $offset=0, $limit=1000)
	{
		switch ($o)
		{
			case 1: $order_sql = ' ORDER BY nama'; break;
			case 2: $order_sql = ' ORDER BY nama DESC'; break;
			default:$order_sql = ' ORDER BY id';
		}

		$paging_sql = ' LIMIT ' .$offset. ',' .$limit;

		$sql = "SELECT * " . $this->list_data_sql();
		$sql .= $order_sql;
		$sql .= $paging_sql;

		$query = $this->db->query($sql);
		$data=$query->result_array();

		$j = $offset;
		for ($i=0; $i<count($data); $i++)
		{
			$data[$i]['no'] = $j + 1;
			$j++;
		}
		return $data;
	}

	private function validasi($post)
	{
		$data['nama'] = nomor_surat_keputusan($post['nama']);
		$data['warna'] = htmlentities($post['warna']);
		return $data;
	}

	public function insert()
	{
		$data = $this->validasi($this->input->post());
		$outp = $this->db->insert('tutupan_lahan_jenis', $data);
		status_sukses($outp); //Tampilkan Pesan
	}

	public function update($id=0)
	{
	  $data = $this->validasi($this->input->post());
		$this->db->where('id', $id);
		$outp = $this->db->update('tutupan_lahan_jenis', $data);

		if($outp) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	public function delete($id='', $semua=false)
	{
		if (!$semua) $this->session->success = 1;

		if ($this->cek_in_use_jenis($id)){
			return session_error(": Data Masih Dipakai");
		}

		$outp = $this->db->where('id', $id)->delete('tutupan_lahan_jenis');


		status_sukses($outp, $gagal_saja=true); //Tampilkan Pesan
	}

	public function delete_all()
	{
		$this->session->success = 1;

		$id_cb = $_POST['id_cb'];
		foreach ($id_cb as $id)
		{
			$this->delete($id, $semua=true);
		}
	}

	public function get_tutupan_lahan_jenis($id=0)
	{
		$sql = "SELECT * FROM tutupan_lahan_jenis WHERE id = ?";
		$query = $this->db->query($sql, $id);
		$data = $query->row_array();
		return $data;
	}

	private function cek_in_use_jenis($jenis){
		$sql = "SELECT * FROM tutupan_lahan WHERE jenis = ?";
		$query = $this->db->query($sql, $jenis);
		$data = $query->num_rows();
		return $data > 0 ? true : false;
	}
}
?>
