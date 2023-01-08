<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Api_mobile extends Api_Controller
{

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model([
			'user_model',
			'config_model',
			'pamong_model',
			'web_dokumen_model',

			'first_m',
			'first_artikel_m',

			'penduduk_model',
			'laporan_penduduk_model',
			'wilayah_model',
			'data_persil_model',
			'plan_lokasi_model',
			'data_persil_model',
			'tutupan_lahan_model',
			'plan_point_model'
		]);
	}

	public function index()
	{
		redirect('ppid');
	}

	public function id_desa()
	{
		$dataDesa = $this->config_model->get_data();
		header('Content-Type: application/json');
		echo json_encode($dataDesa);
	}

	public function getDesa()
	{
		$result = null;
		$dataArray = $this->config_model->get_data_mobile();
		foreach ($dataArray as $data) {
			$resultSlider = null;
			$dataSliders = $this->config_model->get_slider_desa();
			foreach ($dataSliders as $slider) {

				$tmpSlider = array(
					'id' => $slider['id'],
					'kategori' => $slider['kategori'],
					'nama' => $slider['nama'],
					'gambar' => $slider['gambar'],
					'tgl_upload' => $slider['tgl_upload'],
				);
				$resultSlider[] = $tmpSlider;
			}
			$tmp = array(
				'nama_desa' => $data['nama_desa'],
				'logo' => $data['logo'],
				'nama_kepala_desa' => $data['nama_kepala_desa'],
				'alamat_kantor' => $data['alamat_kantor'],
				'email_desa' => $data['email_desa'],
				'telepon' => $data['telepon'],
				'website' => $data['website'],
				'kode_pos' => $data['kode_pos'],
				'nama_kecamatan' => $data['nama_kecamatan'],
				'nama_kepala_camat' => $data['nama_kepala_camat'],
				'nama_kabupaten' => $data['nama_kabupaten'],
				'nama_propinsi' => $data['nama_propinsi'],
				'kantor_desa' => $data['kantor_desa'],
				'luas_desa' => $data['luas_desa'],
				'slider' => $resultSlider,
				'lat' => json_decode($data['lat']),
				'lng' => json_decode($data['lng']),
				"path" => json_decode($data['path']),
			);
			$result = $tmp;
		}

		if (is_null($result)) {
			$status = FALSE;
			$error = TRUE;
			$message = 'data tidak ada';
		} else {
			$status = TRUE;
			$error = FALSE;
			$message = 'sukses';
		}

		header('Content-Type: application/json');
		$response = ['status' => $status, 'error' => $error, 'message' => $message, 'data' => $result];
		echo json_encode($response);
	}

	public function getProdukHukum()
	{

		$result = null;
		$dataArray = $this->web_dokumen_model->all_peraturan();
		$result = $dataArray;

		if (is_null($result)) {
			$status = FALSE;
			$error = TRUE;
			$message = 'data tidak ada';
		} else {
			$status = TRUE;
			$error = FALSE;
			$message = 'sukses';
		}

		header('Content-Type: application/json');
		$response = ['status' => $status, 'error' => $error, 'message' => $message, 'data' => $result];
		echo json_encode($response);
	}

	public function pamong($jabatan = false)
	{
		$this->log_request();
		$data = $this->pamong_model->list_data();
		if ($jabatan) {
			$jabatan = ucwords(str_replace("_", " ", $jabatan));
			foreach ($data as $d) {
				if ($jabatan == $d["jabatan"]) {
					$data = $d;
					break;
				}
			}
		}
		$json_send = array(
			"status" => true,
			"data" => $data
		);
		header('Content-Type: application/json');
		echo json_encode($json_send);
	}

	public function getArtikel()
	{

		$result = null;
		$dataArray = $this->first_artikel_m->artikelMobile(0, 1000);
		$result = $dataArray;

		if (is_null($result)) {
			$status = FALSE;
			$error = TRUE;
			$message = 'data tidak ada';
		} else {
			$status = TRUE;
			$error = FALSE;
			$message = 'sukses';
		}

		header('Content-Type: application/json');
		$response = ['status' => $status, 'error' => $error, 'message' => $message, 'data' => $result];
		echo json_encode($response);
	}

	public function getPersil()
	{
		$this->log_request();
		// $json_send = [] ;
		$result = [];
		$persilArray = $this->data_persil_model->list_persil_api();
		foreach ($persilArray as $persil) {
			$tmp = array(
				"type" => "Feature",
				"id" => $persil['id'],
				"properties" => array(
					"Nama_Pemil" => $persil['Nama_Pemil'],
					"NIK" => $persil['NIK'],
					"No_Surat_P" => $persil['No_Surat_P'],
					"Nomor_SPPT" => $persil['Nomor_SPPT'],
					"NIB" => $persil['NIB'],
					"Jenis_Pers" => $persil['Jenis_Pers'],
					"Luas_PTSL" => $persil['Luas_PTSL'],
					"Kelas_Tana" => $persil['Kelas_Tana'],
					"Luas__SPPT" => $persil['Luas__SPPT'],
					"Peruntukan" => $persil['Peruntukan'],
					"Dusun" => $persil['Dusun'],
					"Blok" => $persil['Blok'],
					"RW" => $persil['RW'],
					"RT" => $persil['RT'],
					"Nama_Jalan" => $persil['Nama_Jalan'],
					"Keterangan" => $persil['Keterangan'],
				),
				"geometry" => array(
					"type" => "Polygon",
					"coordinates" => json_decode($persil['path'])
				)
			);
			$result[] = $tmp;
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}
}
