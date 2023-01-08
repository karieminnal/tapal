<?php
class Data_persil_model extends MY_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function autocomplete($cari = '')
	{
		return $this->autocomplete_str('nomor', 'persil', $cari);
	}

	private function search_sql()
	{
		if ($this->session->cari) {
			$cari = $this->session->cari;
			$kw = $this->db->escape_like_str($cari);
			$kw = '%' . $kw . '%';
			$this->db->where("p.nomor like '$kw'");
		}
	}

	public function paging($p = 1)
	{
		$this->main_sql();
		$jml = $this->db->select('p.id')->get()->num_rows();

		$this->load->library('paging');
		$cfg['page'] = $p;
		$cfg['per_page'] = $_SESSION['per_page'];
		$cfg['num_rows'] = $jml;
		$this->paging->init($cfg);

		return $this->paging;
	}

	private function main_sql()
	{
		$this->db->from('persil p');
		// ->join('ref_persil_kelas k', 'k.id = p.kelas', 'left')
		// ->join('tweb_wil_clusterdesa w', 'w.id = p.id_wilayah', 'left');
		// ->join('mutasi_cdesa m', 'p.id = m.id_persil', 'left')
		// ->join('cdesa c', 'c.id = p.cdesa_awal', 'left')
		// ->group_by('p.id, nomor_urut_bidang');
		$this->search_sql();
	}

	public function list_data($offset, $per_page)
	{
		$this->main_sql();
		// $data = $this->db->select('p.*, k.kode, count(m.id_persil) as jml_bidang, c.nomor as nomor_cdesa_awal')
		// 	->select('(CASE WHEN p.id_wilayah IS NOT NULL THEN CONCAT("RT ", w.rt, " / RW ", w.rw, " - ", w.dusun) ELSE p.lokasi END) AS alamat')
		// 	->order_by('nomor, nomor_urut_bidang')
		$data = $this->db->select('p.*')
			// ->limit($per_page,$offset)
			->get()
			->result_array();

		// $j = $offset;
		// for ($i=0; $i<count($data); $i++)
		// {
		// 	$data[$i]['no'] = $j + 1;
		// 	$j++;
		// }

		return $data;
	}

	public function list_persil()
	{
		$data = $this->db
			->select('p.*')
			// ->select('p.id, nomor, nomor_urut_bidang')
			// ->select('CONCAT("RT ", w.rt, " / RW ", w.rw, " - ", w.dusun) as lokasi')
			->from('persil p')
			// ->join('tweb_wil_clusterdesa w', 'w.id = p.id_wilayah')
			// ->order_by('nomor, nomor_urut_bidang')
			->get()->result_array();
		return $data;
	}

	public function list_persil_api()
	{
		$data = $this->db
			->select('p.*')
			->from('persil p')
			->get()->result_array();
		return $data;
	}

	public function get_persil($id)
	{
		$data = $this->db->select('p.*')
			// $data = $this->db->select('p.*, k.kode, k.tipe, k.ndesc, c.nomor as nomor_cdesa_awal')
			// 	->select('CONCAT("RT ", w.rt, " / RW ", w.rw, " - ", w.dusun) as alamat')
			->from('persil p')
			// 	->join('ref_persil_kelas k', 'k.id = p.kelas', 'left')
			// 	->join('tweb_wil_clusterdesa w', 'w.id = p.id_wilayah', 'left')
			// 	->join('cdesa c', 'c.id = p.cdesa_awal', 'left')
			->where('p.id', $id)
			->get()->row_array();
		return $data;
	}

	public function get_list_mutasi($id)
	{
		$this->db
			->select('m.*, m.id_cdesa_masuk, c.nomor as cdesa_masuk, k.id as id_cdesa_keluar')
			->from('persil p')
			->join('mutasi_cdesa m', 'p.id = m.id_persil', 'left')
			->join('cdesa c', 'c.id = m.id_cdesa_masuk', 'left')
			->join('cdesa k', 'k.nomor = m.cdesa_keluar', 'left')
			->where('m.id_persil', $id);
		$data = $this->db->get()->result_array();
		return $data;
	}

	// private function get_persil_by_nomor($nomor, $nomor_urut_bidang)
	private function get_persil_by_nomor($nomor)
	{
		$id = $this->db->select('id')
			->where('nomor', $nomor)
			// ->where('nomor_urut_bidang', $nomor_urut_bidang)
			->get('persil')->row()->id;
		return $id;
	}

	public function simpan_persil($post)
	{
		$data = array();
		$data['nomor'] = bilangan($post['no_persil']);
		$data['nomor_urut_bidang'] = bilangan($post['nomor_urut_bidang']) ?: 0;
		$data['kelas'] = $post['kelas'];
		$data['id_wilayah'] = $post['id_wilayah'] ?: NULL;
		$data['luas_persil'] = bilangan($post['luas_persil']) ?: NULL;
		$data['lokasi'] = $post['lokasi'] ?: NULL;
		$data['jenis_persil'] = $post['jenis_persil'] ?: NULL;
		$data['sppt_pbb'] = $post['sppt_pbb'] ?: NULL;
		$data['peruntukan'] = $post['peruntukan'] ?: NULL;
		$data['id_pemilik'] = $post['id_pemilik'] ?: NULL;

		// $id_persil = $post['id_persil'] ?: $this->get_persil_by_nomor($post['no_persil'], $post['nomor_urut_bidang']);
		$id_persil = $post['id_persil'] ?: $this->get_persil_by_nomor($post['no_persil']);
		if ($id_persil) {
			$this->db->where('id', $id_persil)
				->update('persil', $data);
		} else {
			$data['cdesa_awal'] = bilangan($post['cdesa_awal']);
			$data['nomor'] = $post['no_persil'];
			$this->db->insert('persil', $data);
			$id_persil = 	$this->db->insert_id();
			$this->mutasi_awal($data, $id_persil);
		}
		return $id_persil;
	}

	public function hapus($id)
	{
		$hasil = $this->db->where('id', $id)
			->delete('persil');
		status_sukses($hasil);
	}

	public function list_dusunrwrt()
	{
		$strSQL = "SELECT `id`,`rt`,`rw`,`dusun` FROM `tweb_wil_clusterdesa` WHERE (`rt`>0) ORDER BY `dusun`";
		$query = $this->db->query($strSQL);
		return $query->result_array();
	}

	public function list_persil_kelas($table = '')
	{
		if ($table) {
			$data = $this->db->order_by('kode')
				->get_where('ref_persil_kelas', array('tipe' => $table))
				->result_array();
			$data = array_combine(array_column($data, 'id'), $data);
		} else {
			$data = $this->db->order_by('kode')
				->get('ref_persil_kelas')
				->result_array();
			$data = array_combine(array_column($data, 'id'), $data);
		}

		return $data;
	}

	public function awal_persil($cdesa_awal, $id_persil, $hapus = false)
	{
		// Hapus mutasi awal kalau ada
		$this->db->where('id_persil', $id_persil)
			->where('jenis_mutasi', '9')
			->delete('mutasi_cdesa');
		$cdesa_awal = $hapus ? null : $cdesa_awal; // Kosongkan pemilik awal persil ini
		$this->db->where('id', $id_persil)
			->set('cdesa_awal', $cdesa_awal)
			->update('persil');
		$persil = $this->db->where('id', $id_persil)
			->get('persil')->row_array();
		$this->mutasi_awal($persil, $id_persil);
	}

	private function mutasi_awal($data, $id_persil)
	{
		$mutasi['id_cdesa_masuk'] = $data['cdesa_awal'];
		$mutasi['jenis_mutasi'] = '9';
		$mutasi['tanggal_mutasi'] = date('Y-m-d H:i:s');
		$mutasi['id_persil'] = $id_persil;
		$mutasi['luas'] = $data['luas_persil'];
		$mutasi['keterangan'] = 'Pemilik awal persil ini';
		$this->db->insert('mutasi_cdesa', $mutasi);
	}

	public function insert_persil()
	{
		$this->db->empty_table('persil');
		$data = json_decode($_POST['more_info'], true);
		foreach ($data as &$persil) {
			$persil['Nama_Pemil'] = $persil['props']['Nama_Pemil'];
			$persil['NIK'] = bilangan(angka_tanpa_koma($persil['props']['NIK']));
			$persil['No_Surat_P'] = $persil['props']['No_Surat_P'];
			$persil['Nomor_SPPT'] = $persil['props']['Nomor_SPPT'];
			$persil['NIB'] = $persil['props']['NIB'];
			$persil['Jenis_Pers'] = $persil['props']['Jenis_Pers'];
			$persil['Luas_PTSL'] = angka_tanpa_koma($persil['props']['Luas_PTSL']);
			$persil['Kelas_Tana'] = $persil['props']['Kelas_Tana'];
			$persil['Luas__SPPT'] = angka_tanpa_koma($persil['props']['Luas__SPPT']);
			$persil['Peruntukan'] = $persil['props']['Peruntukan'];
			$persil['Dusun'] = strtoupper($persil['props']['Dusun']);
			$persil['Blok'] = angka_tanpa_koma($persil['props']['Blok']);
			$persil['RT'] = (int)bilangan($persil['props']['RT']);
			$persil['RW'] = (int)bilangan($persil['props']['RW']);
			$persil['Nama_Jalan'] = $persil['props']['Nama_Jalan'];
			$persil['Alamat'] = $persil['props']['Alamat'];
			$persil['Keterangan'] = $persil['props']['Keterangan'];
			unset($persil['props']);
		}
		$outp = $this->db->insert_batch('persil', $data);

		status_sukses($outp); //Tampilkan Pesan
	}
	public function simpan_update()
	{
		$this->db->set('Nama_Pemil', $_POST['Nama_Pemil']);
		$this->db->set('NIK', $_POST['NIK']);
		$this->db->set('No_Surat_P', $_POST['No_Surat_P']);
		$this->db->set('Nomor_SPPT', $_POST['Nomor_SPPT']);
		$this->db->set('NIB', $_POST['NIB']);
		$this->db->set('Jenis_Pers', $_POST['Jenis_Pers']);
		$this->db->set('Luas_PTSL', $_POST['Luas_PTSL']);
		$this->db->set('Kelas_Tana', $_POST['Kelas_Tana']);
		$this->db->set('Luas__SPPT', $_POST['Luas__SPPT']);
		$this->db->set('Peruntukan', $_POST['Peruntukan']);
		$this->db->set('Dusun', $_POST['Dusun']);
		$this->db->set('Blok', $_POST['Blok']);
		$this->db->set('RW', $_POST['RW']);
		$this->db->set('RT', $_POST['RT']);
		$this->db->set('Nama_Jalan', $_POST['Nama_Jalan']);
		$this->db->set('Alamat', $_POST['Alamat']);
		$this->db->set('Keterangan', $_POST['Keterangan']);
		$this->db->set('tgl_diupdate', 'NOW()', FALSE);
		$this->db->where('id', $_POST['id']);
		$this->db->update('persil');
	}

	public function list_penduduk()
	{
		$strSQL = "SELECT `id`,`nama`,`nik` FROM `tweb_penduduk`";
		$query = $this->db->query($strSQL);
		return $query->result_array();
	}

	public function get_cluster_id($dusun = '', $rw = '', $rt = '')
	{
		$data = $this->db
			->where('dusun', urldecode($dusun))
			->where('rw', urldecode($rw))
			->where('rt', urldecode($rt))
			->get('tweb_wil_clusterdesa')
			->row();

		return $data->id;
	}
}
