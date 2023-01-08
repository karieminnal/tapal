<?php
/*
 * File ini:
 *
 * Model di Modul Identitas Desa
 *
 * donjo-app/controllers/Config_models.php
 *
 */

class Config_provinsi_model extends CI_Model
{

	public function __construct(){
		parent::__construct();
	}

	private function main_sql(){
		$this->db->from('config');
	}

	public function get_provinsi(){
		$sql = 'SELECT * FROM provinces ORDER BY name ASC';
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function get_kota($id_provinces){
		$sql = "SELECT  * FROM regencies WHERE province_id ='$id_provinces' ORDER BY name ASC";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function get_kec($id_regencies){
		$sql = "SELECT  * FROM districts WHERE regency_id ='$id_regencies' ORDER BY name ASC";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function get_keldesa($id_district){
		$sql = "SELECT  * FROM villages WHERE district_id ='$id_district' ORDER BY name ASC";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function get_data(){
		$query = $this->db->select('*')->limit(1)->get('config')->row_array();
		return $query;
	}

	public function get_data_all(){
		$sql = 'SELECT * FROM config ORDER BY nama_desa ASC';
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function get_desa($id){
		$sql = "SELECT * FROM config WHERE id = '$id'";
		// echo htmlentities($sql);
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;
	}

	public function get_data_mobile()
	{
		$sql = 'SELECT * FROM config ORDER BY id ASC';
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function get_slider_desa()
	{
		$sql = 'SELECT s.*, s.nama AS kategori, t.id AS id, t.gambar AS gambar, t.nama AS nama, t.tgl_upload AS tgl_upload FROM gambar_gallery t 
		LEFT JOIN gambar_gallery s ON s.id = t.parrent 
		WHERE s.enabled = 1 
		AND s.slider = 1 
		AND t.enabled = 1 
		AND t.tipe = 2 
		ORDER BY t.urut ASC';
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function insert()
	{
		$data = $this->bersihkan_post();
		// $data['id'] = 1; // Hanya ada satu row data desa
		// Data lokasi peta default. Diperlukan untuk menampilkan widget peta lokasi
		$data['lat'] = '-6.81136376';
		$data['lng'] = '108.46914321';
		$data['zoom'] = '16';
		$data['map_tipe'] = 'roadmap';
		unset($data['old_logo']);
		unset($data['old_kantor_desa']);
		$data['logo'] = $this->upload_gambar_desa('logo');
		$data['kantor_desa'] = $this->upload_gambar_desa('kantor_desa');
		if (!empty($data['logo'])) {
			// Ada logo yang berhasil diunggah --> simpan ukuran 100 x 100
			$tipe_file = TipeFile($_FILES['logo']);
			$dimensi = array("width" => 100, "height" => 100);
			resizeImage(LOKASI_LOGO_DESA . $data['logo'], $tipe_file, $dimensi);
			resizeImage(LOKASI_LOGO_DESA . $data['logo'], $tipe_file, array("width" => 16, "height" => 16), LOKASI_LOGO_DESA . 'favicon.ico');
		} else {
			unset($data['logo']);
		}
		unset($data['file_logo']);
		unset($data['file_kantor_desa']);
		$outp = $this->db->insert('config', $data);
		status_sukses($outp); //Tampilkan Pesan
	}

	// TODO: tambahkan validasi di form Identitas Desa
	private function bersihkan_post()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$post = $this->input->post();
		$data['old_logo'] = $post['old_logo'];
		$data['old_kantor_desa'] = $post['old_kantor_desa'];
		$data['nama_desa'] = nama_terbatas($post['nama_desa']);
		$data['kode_desa'] = bilangan($post['kode_desa']);
		$data['kode_pos'] = bilangan($post['kode_pos']);
		$data['nama_kepala_desa'] = nama($post['nama_kepala_desa']);
		$data['nip_kepala_desa'] = nomor_surat_keputusan($post['nip_kepala_desa']);
		$data['alamat_kantor'] = alamat($post['alamat_kantor']);
		$data['email_desa'] = email($post['email_desa']);
		$data['telepon'] = bilangan($post['telepon']);
		$data['website'] = alamat_web($post['website']);
		$data['nama_kecamatan'] = nama_terbatas($post['nama_kecamatan']);
		$data['kode_kecamatan'] = bilangan($post['kode_kecamatan']);
		$data['nama_kepala_camat'] = nama($post['nama_kepala_camat']);
		$data['nip_kepala_camat'] = nomor_surat_keputusan($post['nip_kepala_camat']);
		$data['nama_kabupaten'] = nama($post['nama_kabupaten']);
		$data['kode_kabupaten'] = bilangan($post['kode_kabupaten']);
		$data['nama_propinsi'] = nama_terbatas($post['nama_propinsi']);
		$data['kode_propinsi'] = bilangan($post['kode_propinsi']);
		$data['luas_desa'] = bilangan_koma($post['luas_desa']);
		return $data;
	}

	public function update($id = 0)
	{
		$_SESSION['success'] = 1;
		$_SESSION['error_msg'] = '';

		$data = $this->bersihkan_post();
		$data['logo'] = $this->upload_gambar_desa('logo');
		$data['kantor_desa'] = $this->upload_gambar_desa('kantor_desa');

		if (!empty($data['logo'])) {
			// Ada logo yang berhasil diunggah --> simpan ukuran 100 x 100
			$tipe_file = TipeFile($_FILES['logo']);
			$dimensi = array("width" => 100, "height" => 100);
			resizeImage(LOKASI_LOGO_DESA . $data['logo'], $tipe_file, $dimensi);
			resizeImage(LOKASI_LOGO_DESA . $data['logo'], $tipe_file, array("width" => 16, "height" => 16), LOKASI_LOGO_DESA . 'favicon.ico');
			// Hapus berkas logo lama
			if (!empty($data['old_logo'])) unlink(LOKASI_LOGO_DESA . $data['old_logo']);
		} else {
			unset($data['logo']);
		}

		if (empty($data['kantor_desa'])) unset($data['kantor_desa']);

		unset($data['file_logo']);
		unset($data['old_logo']);
		unset($data['file_kantor_desa']);
		unset($data['old_kantor_desa']);
		$this->db->where('id', $id)->update('config', $data);

		$pamong['pamong_nama'] = $data['nama_kepala_desa'];
		$pamong['pamong_nip'] = $data['nip_kepala_desa'];
		$this->db->where('pamong_id', '707');
		$outp = $this->db->update('tweb_desa_pamong', $pamong);

		if (!$outp) $_SESSION['success'] = -1;
	}

	/*
		Returns:
			- success: nama berkas yang diunggah
			- fail: NULL
	*/
	private function upload_gambar_desa($jenis)
	{
		$this->load->library('upload');
		$this->uploadConfig = array(
			'upload_path' => LOKASI_LOGO_DESA,
			'allowed_types' => 'gif|jpg|jpeg|png',
			'max_size' => max_upload() * 1024,
		);
		// Adakah berkas yang disertakan?
		$adaBerkas = !empty($_FILES[$jenis]['name']);
		if ($adaBerkas !== TRUE) {
			return NULL;
		}
		// Tes tidak berisi script PHP
		if (isPHP($_FILES['logo']['tmp_name'], $_FILES[$jeniss]['name'])) {
			$_SESSION['error_msg'] .= " -> Jenis file ini tidak diperbolehkan ";
			$_SESSION['success'] = -1;
			redirect('identitas_desa');
		}

		$uploadData = NULL;
		// Inisialisasi library 'upload'
		$this->upload->initialize($this->uploadConfig);
		// Upload sukses
		if ($this->upload->do_upload($jenis)) {
			$uploadData = $this->upload->data();
			// Buat nama file unik agar url file susah ditebak dari browser
			$namaFileUnik = tambahSuffixUniqueKeNamaFile($uploadData['file_name']);
			// Ganti nama file asli dengan nama unik untuk mencegah akses langsung dari browser
			$fileRenamed = rename(
				$this->uploadConfig['upload_path'] . $uploadData['file_name'],
				$this->uploadConfig['upload_path'] . $namaFileUnik
			);
			// Ganti nama di array upload jika file berhasil di-rename --
			// jika rename gagal, fallback ke nama asli
			$uploadData['file_name'] = $fileRenamed ? $namaFileUnik : $uploadData['file_name'];
		}
		// Upload gagal
		else {
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = $this->upload->display_errors(NULL, NULL);
		}
		return (!empty($uploadData)) ? $uploadData['file_name'] : NULL;
	}

	public function update_kantor()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $_POST;
		$id = $filterDesa;
		$this->db->where('id', $id);
		$outp = $this->db->update('config', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function update_wilayah()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data = $_POST;
		$id = $filterDesa;
		$this->db->where('id', $id);
		$outp = $this->db->update('config', $data);

		status_sukses($outp); //Tampilkan Pesan
	}
}
