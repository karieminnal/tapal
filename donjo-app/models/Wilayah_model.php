<?php class Wilayah_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function autocomplete()
	{
		return $this->autocomplete_str('dusun', 'tweb_wil_clusterdesa');
	}

	private function search_sql()
	{
		if (isset($_SESSION['cari'])) {
			$cari = $this->db->escape_like_str($_SESSION['cari']);
			$kw = $this->db->escape_like_str($cari);
			$kw = '%' . $kw . '%';
			$search_sql = " AND u.dusun LIKE '$kw'";
			return $search_sql;
		}
	}

	public function paging($p = 1, $o = 0)
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
		$filterDesa = $_SESSION['filterDesa'];
		$sql = " FROM tweb_wil_clusterdesa u
			LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id
			WHERE u.rt = '0' AND u.rw = '0' AND u.id_desa= '$filterDesa' ";
		$sql .= $this->search_sql();
		return $sql;
	}

	/*
		Struktur tweb_wil_clusterdesa:
		- baris dengan kolom rt = '0' dan rw = '0' menunjukkan dusun
		- baris dengan kolom rt = '-' dan rw <> '-' menunjukkan rw
		- baris dengan kolom rt <> '0' dan rt <> '0' menunjukkan rt

		Di tabel penduduk_hidup  dan keluarga_aktif, kolom id_cluster adalah id untuk
		baris rt.
	*/
	public function list_data($o = 0, $offset = 0, $limit = 500)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$paging_sql = ' LIMIT ' . $offset . ',' . $limit;

		$select_sql = "SELECT u.*, a.nama AS nama_kadus, a.nik AS nik_kadus,
		(SELECT COUNT(rw.id) FROM tweb_wil_clusterdesa rw WHERE dusun = u.dusun AND rw <> '-' AND rt = '-' AND rw.id_desa= '$filterDesa') AS jumlah_rw,
		(SELECT COUNT(v.id) FROM tweb_wil_clusterdesa v WHERE dusun = u.dusun AND v.rt <> '0' AND v.rt <> '-' AND v.id_desa= '$filterDesa') AS jumlah_rt,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = u.dusun AND id_desa= '$filterDesa') AND u.id_desa= '$filterDesa') AS jumlah_warga,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = u.dusun AND id_desa= '$filterDesa') AND p.sex = 1 AND u.id_desa= '$filterDesa') AS jumlah_warga_l,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = u.dusun AND id_desa= '$filterDesa') AND p.sex = 2 AND u.id_desa= '$filterDesa') AS jumlah_warga_p,
		(SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala = p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = u.dusun AND id_desa= '$filterDesa') AND p.kk_level = 1 AND u.id_desa= '$filterDesa') AS jumlah_kk ";
		$sql = $select_sql . $this->list_data_sql();
		$sql .= $paging_sql;

		$query = $this->db->query($sql);
		$data = $query->result_array();

		//Formating Output
		$j = $offset;
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $j + 1;
			$j++;
		}
		return $data;
	}

	private function bersihkan_data($data)
	{
		$filterDesa = $_SESSION['filterDesa'];
		if (empty((int)$data['id_kepala']))
			unset($data['id_kepala']);
		$data['dusun'] = nama_terbatas(strtoupper($data['dusun'])) ?: 0;
		$data['rw'] = nama_terbatas($data['rw']) ?: 0;
		$data['rt'] = bilangan($data['rt']) ?: 0;
		$data['id_desa'] = $filterDesa;
		return $data;
	}

	private function cek_data($table, $data = [])
	{
		$count = $this->db->get_where($table, $data)->num_rows();
		return $count;
	}

	public function insert()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->bersihkan_data($this->input->post());
		$wil = array(
			'dusun' => $data['dusun'],
			'rw' => '-',
			'rt' => '-',
			'dusun' => $data['dusun'],
			'id_desa' => $filterDesa
		);
		$cek_data = $this->cek_data('tweb_wil_clusterdesa', $wil);
		if ($cek_data) {
			$_SESSION['success'] = -2;
			return;
		}
		$this->db->insert('tweb_wil_clusterdesa', $data);

		$rw = $data;
		$rw['rw'] = "-";
		$this->db->insert('tweb_wil_clusterdesa', $rw);

		$rt = $rw;
		$rt['rt'] = "-";
		$outp = $this->db->insert('tweb_wil_clusterdesa', $rt);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function update($id = 0)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->bersihkan_data($this->input->post());
		$wil = array(
			'dusun' => $data['dusun'], 
			'rw' => '0', 
			'rt' => '0', 
			'id <>' => $id,
			'id_desa' => $filterDesa
		);
		$cek_data = $this->cek_data('tweb_wil_clusterdesa', $wil);
		if ($cek_data) {
			$_SESSION['success'] = -2;
			return;
		}
		$temp = $this->wilayah_model->cluster_by_id($id);
		$this->db->where('dusun', $temp['dusun']);
		$this->db->where('rw', '0');
		$this->db->where('rt', '0');
		$this->db->where('id_desa', $filterDesa);
		$outp1 = $this->db->update('tweb_wil_clusterdesa', $data);

		// Ubah nama dusun di semua baris rw/rt untuk dusun ini
		$outp2 = $this->db->where('dusun', $temp['dusun'])
		->where('id_desa', $filterDesa)
		->update('tweb_wil_clusterdesa', array('dusun' => $data['dusun']));

		if ($outp1 and $outp2) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	//Delete dusun/rw/rt tergantung tipe
	public function delete($tipe = '', $id = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$this->session->success = 1;
		// Perlu hapus berdasarkan nama, supaya baris RW dan RT juga terhapus
		$temp = $this->cluster_by_id($id);
		$rw = $temp['rw'];
		$dusun = $temp['dusun'];
		$desaid = $temp['id_desa'];

		switch ($tipe) {
			case 'dusun':
				$this->db->where('dusun', $dusun)->where('id_desa', $desaid);
				break; //dusun
			case 'rw':
				$this->db->where('rw', $rw)->where('dusun', $dusun)->where('id_desa', $desaid);
				break; //rw
			default:
				$this->db->where('id', $id)->where('id_desa', $desaid);
				break; //rt
		}

		$outp = $this->db->delete('tweb_wil_clusterdesa');

		status_sukses($outp, $gagal_saja = true); //Tampilkan Pesan
	}

	//Bagian RW
	public function list_data_rw($id = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$temp = $this->cluster_by_id($id);
		$dusun = $temp['dusun'];

		$sql = "SELECT u.*, a.nama AS nama_ketua, a.nik AS nik_ketua,
		(SELECT COUNT(rt.id) FROM tweb_wil_clusterdesa rt WHERE dusun = u.dusun AND rw = u.rw AND rt <> '-' AND rt <> '0' AND rt.id_desa= '$filterDesa' ) AS jumlah_rt,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = u.rw AND id_desa= '$filterDesa') AND u.id_desa= '$filterDesa') AS jumlah_warga,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = u.rw AND id_desa= '$filterDesa') AND p.sex = 1 AND u.id_desa= '$filterDesa') AS jumlah_warga_l,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = u.rw AND id_desa= '$filterDesa') AND p.sex = 2 AND u.id_desa= '$filterDesa') AS jumlah_warga_p,
		(SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id  WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = u.rw AND id_desa= '$filterDesa') AND p.kk_level = 1 AND u.id_desa= '$filterDesa') AS jumlah_kk
		FROM tweb_wil_clusterdesa u LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id WHERE u.rt = '0' AND u.rw <> '0' AND u.dusun = '$dusun' AND u.id_desa= '$filterDesa'";
		$query = $this->db->query($sql);
		$data = $query->result_array();

		//Formating Output
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $i + 1;
		}
		return $data;
	}

	public function insert_rw($dusun = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->bersihkan_data($this->input->post());
		$temp = $this->cluster_by_id($dusun);
		$data['dusun'] = $temp['dusun'];
		$wil = array(
			'dusun' => $data['dusun'], 
			'rw' => $data['rw'],
			'id_desa' => $filterDesa
		);
		$cek_data = $this->cek_data('tweb_wil_clusterdesa', $wil);
		if ($cek_data) {
			$_SESSION['success'] = -2;
			return;
		}
		$outp1 = $this->db->insert('tweb_wil_clusterdesa', $data);

		$rt = $data;
		$rt['rt'] = "-";
		$outp2 = $this->db->insert('tweb_wil_clusterdesa', $rt);

		status_sukses($outp1 & $outp2); //Tampilkan Pesan
	}

	public function update_rw($id_rw = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->bersihkan_data($this->input->post());
		$temp = $this->wilayah_model->cluster_by_id($id_rw);
		$wil = array(
			'dusun' => $temp['dusun'], 
			'rw' => $data['rw'], 
			'rt' => '0', 
			'id <>' => $id_rw,
			'id_desa' => $filterDesa
		);
		unset($data['id_rw']);
		$cek_data = $this->cek_data('tweb_wil_clusterdesa', $wil);
		if ($cek_data) {
			$_SESSION['success'] = -2;
			return;
		}
		// Update data RW
		$data['dusun'] = $temp['dusun'];
		$outp1 = $this->db->where('id', $id_rw)
			->update('tweb_wil_clusterdesa', $data);
		// Update nama RW di semua RT untuk RW ini
		$outp2 = $this->db->where('rw', $temp['rw'])
			->update('tweb_wil_clusterdesa', array('rw' => $data['rw']));
		status_sukses($outp1 and $outp2); //Tampilkan Pesan
	}

	//Bagian RT
	public function list_data_rt($dusun = '', $rw = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$sql = "SELECT u.*, a.nama AS nama_ketua, a.nik AS nik_ketua,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = '$rw' AND rt = u.rt AND id_desa= '$filterDesa') AND u.id_desa= '$filterDesa') AS jumlah_warga,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = '$rw' AND rt = u.rt AND id_desa= '$filterDesa') AND p.sex = 1 AND u.id_desa= '$filterDesa') AS jumlah_warga_l,(
		SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = '$rw' AND rt = u.rt AND id_desa= '$filterDesa') AND p.sex = 2 AND u.id_desa= '$filterDesa') AS jumlah_warga_p,
		(SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id  WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = '$rw' AND rt = u.rt AND id_desa= '$filterDesa') AND p.kk_level = 1 AND u.id_desa= '$filterDesa') AS jumlah_kk
		FROM tweb_wil_clusterdesa u LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id WHERE u.rt <> '0' AND u.rw = '$rw' AND u.dusun = '$dusun' AND u.rt <> '-' AND u.id_desa= '$filterDesa'";

		$query = $this->db->query($sql);
		$data = $query->result_array();

		//Formating Output
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['no'] = $i + 1;
		}
		return $data;
	}

	public function insert_rt($id_dusun = '', $id_rw = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->bersihkan_data($this->input->post());
		$temp = $this->cluster_by_id($id_dusun);
		$data['dusun'] = $temp['dusun'];
		$data_rw = $this->cluster_by_id($id_rw);
		$data['rw'] = $data_rw['rw'];
		$wil = array(
			'dusun' => $data['dusun'], 
			'rw' => $data['rw'], 
			'rt' => $data['rt'],
			'id_desa' => $filterDesa
		);
		$cek_data = $this->cek_data('tweb_wil_clusterdesa', $wil);
		if ($cek_data) {
			$_SESSION['success'] = -2;
			return;
		}

		$outp = $this->db->insert('tweb_wil_clusterdesa', $data);
		status_sukses($outp); //Tampilkan Pesan
	}

	public function update_rt($id = 0)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->bersihkan_data($this->input->post());
		$rt_lama = $this->db->where('id', $id)->get('tweb_wil_clusterdesa')->row_array();
		$wil = array(
			'dusun' => $rt_lama['dusun'], 
			'rw' => $rt_lama['rw'], 
			'rt' => $data['rt'], 
			'id <>' => $id,
			'id_desa' => $filterDesa
		);
		$cek_data = $this->cek_data('tweb_wil_clusterdesa', $wil);
		if ($cek_data) {
			$_SESSION['success'] = -2;
			return;
		}
		$data['dusun'] = $rt_lama['dusun'];
		$data['rw'] = $rt_lama['rw'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wil_clusterdesa', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function list_penduduk()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db->select('p.id, p.nik, p.nama, c.dusun')
			->from('penduduk_hidup p')
			->join('tweb_wil_clusterdesa c', 'p.id_cluster = c.id', 'left')
			->where('p.id NOT IN (SELECT c.id_kepala FROM tweb_wil_clusterdesa c WHERE c.id_kepala != 0)')
			->where('id_desa', $filterDesa)
			->get()->result_array();
		return $data;
	}

	public function list_dusun_rt($dusun = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$sql = "SELECT * FROM tweb_clusterdesa WHERE dusun = ? AND rt <> '' AND id_desa= '$filterDesa' ";
		$query = $this->db->query($sql, $id);
		$data = $query->row_array();
		return $data;
	}

	public function get_penduduk($id = 0)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$sql = "SELECT id,nik,nama FROM penduduk_hidup WHERE id = ?";
		$query = $this->db->query($sql, $id);
		$data = $query->row_array();
		return $data;
	}

	public function cluster_by_id($id = 0)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db->where('id', $id)
			->where('id_desa', $filterDesa)
			->get('tweb_wil_clusterdesa')
			->row_array();
		return $data;
	}

	public function list_dusun()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db
			->where('rt', '0')
			->where('rw', '0')
			->where('id_desa', $filterDesa)
			->get('tweb_wil_clusterdesa')
			->result_array();

		return $data;
	}

	public function list_dusun_desa($desaid)
	{
		$data = $this->db
			->where('rt', '0')
			->where('rw', '0')
			->where('id_desa', $desaid)
			->get('tweb_wil_clusterdesa')
			->result_array();

		return $data;
	}

	// public function list_dusun_all()
	// {
	// 	$data = $this->db
	// 		->where('rt', '0')
	// 		->where('rw', '0')
	// 		->where('path !=', NULL)
	// 		->get('tweb_wil_clusterdesa')
	// 		->result_array();

	// 	return $data;
	// }

	public function list_dusun_all()
	{
		$data = $this->db->select('t.*, c.nama_desa AS nama_desa, t.id_desa AS id_desa')
			->from('tweb_wil_clusterdesa t')
			->join('config c', 't.id_desa = c.id', 'left')
			->where('t.rt', '0')
			->where('t.rw', '0')
			->where('t.path !=', NULL)
			->get()->result_array();

		return $data;
	}

	public function list_dusun_api()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db->select('t.*, t.id AS id, t.dusun AS dusun, t.lat AS lat, t.lng AS lng, t.path AS path')
			->from('tweb_wil_clusterdesa t')
			->where('rt', '0')
			->where('rw', '0')
			->where('id_desa', $filterDesa)
			->get()->result_array();

		return $data;
	}

	public function list_rw($dusun = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db
			->where('rt', '0')
			->where('dusun', urldecode($dusun))
			->where('rw <>', '0')
			// ->where('id_desa', $filterDesa)
			->order_by('rw')
			->get('tweb_wil_clusterdesa')
			->result_array();

		return $data;
	}

	public function list_rw_bydesa($dusun = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db
			->where('rt', '0')
			->where('dusun', urldecode($dusun))
			->where('rw <>', '0')
			->where('id_desa', $filterDesa)
			->order_by('rw')
			->get('tweb_wil_clusterdesa')
			->result_array();

		return $data;
	}


	public function list_rt($dusun = '', $rw = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db
			->where('rt <>', '0')
			->where('dusun', urldecode($dusun))
			->where('rw', urldecode($rw))
			// ->where('id_desa', $filterDesa)
			->order_by('rt')
			->get('tweb_wil_clusterdesa')
			->result_array();

		return $data;
	}
	public function list_rt_bydesa($dusun = '', $rw = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db
			->where('rt <>', '0')
			->where('dusun', urldecode($dusun))
			->where('rw', urldecode($rw))
			->where('id_desa', $filterDesa)
			->order_by('rt')
			->get('tweb_wil_clusterdesa')
			->result_array();

		return $data;
	}

	public function get_rt($dusun = '', $rw = '', $rt = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$sql = "SELECT * FROM tweb_wil_clusterdesa WHERE dusun = ? AND rw = ? AND rt = ? AND id_desa= '$filterDesa'";
		$query = $this->db->query($sql, array($dusun, $rw, $rt));
		return $query->row_array();
	}

	public function get_cluster_id($dusun = '', $rw = '', $rt = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db
			->where('dusun', urldecode($dusun))
			->where('rw', urldecode($rw))
			->where('rt', urldecode($rt))
			->where('id_desa', $filterDesa)
			->get('tweb_wil_clusterdesa')
			->row();

		return $data->id;
	}

	public function total()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$sql = "SELECT
		(SELECT COUNT(rw.id) FROM tweb_wil_clusterdesa rw WHERE  rw <> '-' AND rt = '-' AND rw.id_desa= '$filterDesa') AS total_rw,
		(SELECT COUNT(v.id) FROM tweb_wil_clusterdesa v WHERE v.rt <> '0' AND v.rt <> '-' AND v.id_desa= '$filterDesa') AS total_rt,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE id_desa= '$filterDesa')) AS total_warga,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE id_desa= '$filterDesa') AND p.sex = 1 AND u.id_desa= '$filterDesa') AS total_warga_l,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE id_desa= '$filterDesa') AND p.sex = 2 AND u.id_desa= '$filterDesa') AS total_warga_p,
		(SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa) AND p.kk_level = 1 AND u.id_desa= '$filterDesa') AS total_kk
		FROM tweb_wil_clusterdesa u
		LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id WHERE u.rt = '0' AND u.rw = '0' AND u.id_desa= '$filterDesa' limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function total_rw($dusun = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$sql = "SELECT sum(jumlah_rt) AS jmlrt, sum(jumlah_warga) AS jmlwarga, sum(jumlah_warga_l) AS jmlwargal, sum(jumlah_warga_p) AS jmlwargap, sum(jumlah_kk) AS jmlkk
			FROM
			(SELECT u.*, a.nama AS nama_ketua, a.nik AS nik_ketua,
				(SELECT COUNT(rt.id) FROM tweb_wil_clusterdesa rt WHERE dusun = u.dusun AND rw = u.rw AND rt <> '-' AND rt <> '0' AND rt.id_desa= '$filterDesa') AS jumlah_rt,
				(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = u.rw AND id_desa= '$filterDesa')) AS jumlah_warga,
				(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = u.rw AND id_desa= '$filterDesa') AND p.sex = 1 AND u.id_desa= '$filterDesa') AS jumlah_warga_l,
				(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = u.rw AND id_desa= '$filterDesa') AND p.sex = 2 AND u.id_desa= '$filterDesa') AS jumlah_warga_p,
				(SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = u.rw AND id_desa= '$filterDesa') AND p.kk_level = 1 AND u.id_desa= '$filterDesa') AS jumlah_kk
				FROM tweb_wil_clusterdesa u
				LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id
				WHERE u.rt = '0' AND u.rw <> '0' AND u.dusun = '$dusun' AND u.id_desa= '$filterDesa') AS x ";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;
	}

	public function total_rt($dusun = '', $rw = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$sql = "SELECT sum(jumlah_warga) AS jmlwarga, sum(jumlah_warga_l) AS jmlwargal, sum(jumlah_warga_p) AS jmlwargap, sum(jumlah_kk) AS jmlkk
			FROM
				(SELECT u.*, a.nama AS nama_ketua,a.nik AS nik_ketua,
					(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = '$rw' AND rt = u.rt AND id_desa= '$filterDesa')) AS jumlah_warga,
					(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = '$rw' AND rt = u.rt AND id_desa= '$filterDesa') AND p.sex = 1 AND u.id_desa= '$filterDesa') AS jumlah_warga_l,
					(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = '$rw' AND rt = u.rt AND id_desa= '$filterDesa') AND p.sex = 2 AND u.id_desa= '$filterDesa') AS jumlah_warga_p,
					(SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = '$dusun' AND rw = '$rw' AND rt = u.rt AND id_desa= '$filterDesa') AND p.kk_level = 1 AND u.id_desa= '$filterDesa') AS jumlah_kk
					FROM tweb_wil_clusterdesa u
					LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id
					WHERE u.rt <> '0' AND u.rt <> '-' AND u.rw = '$rw' AND u.dusun = '$dusun' AND u.id_desa= '$filterDesa') AS x  ";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;
	}

	private function validasi_koordinat($post)
	{
		$data['id'] = $post['id'];
		$data['zoom'] = $post['zoom'];
		$data['map_tipe'] = $post['map_tipe'];
		$data['lat'] = koordinat($post['lat']) ?: NULL;
		$data['lng'] = koordinat($post['lng']) ?: NULL;
		return $data;
	}

	public function update_kantor_dusun_map($id = 0)
	{
		$data = $this->validasi_koordinat($this->input->post());
		$id = $data['id'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wil_clusterdesa', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function update_wilayah_dusun_map($id = 0)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $_POST;
		$id = $_POST['id'];
		$data['path'] = str_replace(',0]',']',$_POST['path']);
		$this->db->where('id', $id);
		$this->db->where('id_desa', $filterDesa);
		$outp = $this->db->update('tweb_wil_clusterdesa', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function get_dusun_maps($id = 0)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$sql = "SELECT * FROM tweb_wil_clusterdesa WHERE id = ? AND id_desa= '$filterDesa'";
		$query = $this->db->query($sql, $id);
		return $query->row_array();
	}

	public function update_kantor_rw_map($id = 0)
	{
		$data = $this->validasi_koordinat($this->input->post());
		$id = $data['id'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wil_clusterdesa', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function update_wilayah_rw_map($id = 0)
	{
		$data = $_POST;
		$id = $_POST['id'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wil_clusterdesa', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function get_rw_maps($dusun = '', $rw = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$sql = "SELECT * FROM tweb_wil_clusterdesa WHERE dusun = ? AND rw = ? AND id_desa= '$filterDesa'";
		$query = $this->db->query($sql, array($dusun, $rw));
		return $query->row_array();
	}

	public function update_kantor_rt_map($id = 0)
	{
		$data = $this->validasi_koordinat($this->input->post());
		$id = $data['id'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wil_clusterdesa', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function update_wilayah_rt_map($id = 0)
	{
		$data = $_POST;
		$id = $_POST['id'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wil_clusterdesa', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function get_rt_maps($rt_id)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db->where('id', $rt_id)
			->get('tweb_wil_clusterdesa')
			->row_array();
		return $data;
	}

	public function list_rw_gis($dusun = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db->where('rt', '0')->
			//where('dusun', urldecode($dusun))->
			where('rw <>', '0')->order_by('rw')->get('tweb_wil_clusterdesa')->result_array();
		return $data;
	}

	public function list_rw_gis_desaid($dusun = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db->where('rt', '0')->
			where('id_desa', $filterDesa)->
			where('rw <>', '0')->order_by('rw')->get('tweb_wil_clusterdesa')->result_array();
		return $data;
	}

	public function list_rt_gis($dusun = '', $rw = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db->where('rt <>', '0')->
			//where('dusun', urldecode($dusun))->
			//where('rw', $rw)->
			order_by('rt')->get('tweb_wil_clusterdesa')->result_array();
		return $data;
	}

	public function list_rt_gis_desaid($dusun = '', $rw = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $this->db->where('rt <>', '0')->
			where('id_desa', $filterDesa)->
			order_by('rt')->get('tweb_wil_clusterdesa')->result_array();
		return $data;
	}

	public function get_alamat_wilayah($data)
	{
		$alamat_wilayah = "$data[alamat] RT $data[rt] / RW $data[rw] " . ucwords(strtolower($this->setting->sebutan_dusun)) . " " . ucwords(strtolower($data['dusun']));

		return trim($alamat_wilayah);
	}

	public function list_rt_gis_api($dusun = '', $rw = '', $desaId = '')
	{
		if($desaId) {
			$data = $this->db->select('t.*, t.id AS id, t.dusun AS dusun, t.lat AS lat, t.lng AS lng, t.path AS path, c.nama_desa AS desa, c.nama_kabupaten AS kabupaten')
				->from('tweb_wil_clusterdesa t')
				->join('config c', 't.id_desa = c.id', 'left')
				->where('t.rt <>', '0')
				->where('t.path !=', NULL)
				->where('id_desa', $desaId)
				->order_by('t.dusun DESC, rt ASC')
				->get()->result_array();
		} else {
			$data = $this->db->select('t.*, t.id AS id, t.dusun AS dusun, t.lat AS lat, t.lng AS lng, t.path AS path, c.nama_desa AS desa, c.nama_kabupaten AS kabupaten')
				->from('tweb_wil_clusterdesa t')
				->join('config c', 't.id_desa = c.id', 'left')
				->where('t.rt <>', '0')
				->where('t.path !=', NULL)
				->order_by('t.dusun DESC, rt ASC')
				->get()->result_array();
		}
		// if ($desaId) $data .= $this->db->where('t.id_desa', $desaId);
		return $data;
	}

	public function list_rt_gis_api_2($dusun = '', $rw = '', $desaId = '')
	{
		$sql = "SELECT t.*, t.id AS id, t.dusun AS dusun, t.lat AS lat, t.lng AS lng, t.path AS path, c.nama_desa AS desa, c.nama_kabupaten AS kabupaten 
			FROM tweb_wil_clusterdesa t 
			LEFT JOIN config c ON t.id_desa = c.id
			WHERE t.rt <> '0' 
			AND t.path IS NOT NULL";
		// if($desaId) {
		// 	$sql .= " AND t.id_desa= $desaId";
		// }
		// $sql .= " ORDER BY t.rt ASC";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		echo $data;
		// return $data;
		// return $data;
	}
}
