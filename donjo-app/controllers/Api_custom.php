<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Api_custom extends Api_Controller
{

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model([
			'penduduk_model',
			'laporan_penduduk_api_model',
			'wilayah_model',
			'data_persil_model',
			'pamong_model',
			'plan_lokasi_model',
			'config_model',
			'data_persil_model',
			'tutupan_lahan_model',
			'plan_point_model',
			'user_model',
			'leuit_panen_model',
			'leuit_distribusi_model',
			'leuit_analisa_model'
		]);
	}

	public function id_desa()
	{
		$json_send = $this->config_model->get_data();
		header('Content-Type: application/json');
		echo json_encode($json_send);
	}

	private function group_by($key, $data, $count = true)
	{
		$result = array();

		foreach ($data as $val) {
			if (array_key_exists($key, $val)) {
				$result[$val[$key]][] = $val;
			} else {
				$result[""][] = $val;
			}
		}

		if ($count) {
			foreach ($result as $k => $kat) {
				$result[$k]["count"] = count($kat);
			}
		}

		return $result;
	}

	public function index()
	{
		redirect('ppid');
	}

	public function test()
	{
		$this->log_request();
		$json_send = array(
			"status" => "succ",
			"data" => $this->penduduk_model->list_data()
		);
		header('Content-Type: application/json');
		echo json_encode($json_send);
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
			"status" => "succ",
			"data" => $data
		);
		header('Content-Type: application/json');
		echo json_encode($json_send);
	}

	public function data_persil()
	{
		$this->log_request();
		$json_send = array(
			"status" => "succ",
			"data" => $this->data_persil_model->list_data()
		);
		header('Content-Type: application/json');
		echo json_encode($json_send);
	}

	public function plan()
	{
		$this->log_request();
		$json_send = [];
		$lokasi = $this->group_by("dusun", $this->plan_lokasi_model->list_data(), false);
		foreach ($lokasi as $k => $lok) {
			$json_send[$k] = $this->group_by("jenis", $lok, false);
		}
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: http://man.info');
		echo json_encode($json_send);
	}

	public function plan_all()
	{
		$this->log_request();
		$json_send = [];
		$lokasi = $this->plan_lokasi_model->list_dusun();
		// foreach ($lokasi as $k) {
		// 	$json_send[$k] = $this->group_by("kategori", $lok, false);
		// }
		// $json_send = array(
		// 	"status" => "succ",
		// 	"data" => $this->plan_lokasi_model->list_dusun()
		// );
		header('Content-Type: application/json');
		echo json_encode($lokasi);
	}

	public function plan_area()
	{
		$this->log_request();
		$json_send = [];
		$lokasi = $this->plan_lokasi_model->list_area();
		header('Content-Type: application/json');
		echo json_encode($lokasi);
	}

	public function plan_garis()
	{
		$this->log_request();
		$json_send = [];
		$lokasi = $this->plan_lokasi_model->list_garis();
		header('Content-Type: application/json');
		echo json_encode($lokasi);
	}

	public function plan_lokasi()
	{
		// $this->log_request();
		// $json_send = [];
		// $lokasi = $this->plan_lokasi_model->list_lokasi();
		// header('Content-Type: application/json');
		// echo json_encode($lokasi);

		$this->log_request();
		$result = [];
		$lokasiArray = $this->plan_lokasi_model->list_lokasi_api();
		foreach ($lokasiArray as $lokasi) {
			$tmp = array(
				"type" => "Feature",
				"properties" => array(
					"id" => $lokasi['id'],
					"enabled" => $lokasi['enabled'],
					"ref_point" => $lokasi['ref_point'],
					"id_cluster" => $lokasi['id_cluster'],
					"nama" => $lokasi['nama'],
					"jenis" => $lokasi['jenis'],
					"kategori" => $lokasi['kategori'],
					"simbol" => $lokasi['simbol'],
					"dusun" => $lokasi['dusun'],
					"nama_jalan" => $lokasi['nama_jalan'],
					"desk" => $lokasi['desk'],
					"foto" => $lokasi['foto'],
				),
				"geometry" => array(
					"type" => "Point",
					"coordinates" => [json_decode($lokasi['lat']), json_decode($lokasi['lng'])]
				)
			);
			$result[] = $tmp;
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function plan_lokasi_kategori()
	{
		$this->log_request();
		// $jenis = $_REQUEST['jenis'];
		$dataArray = $this->plan_point_model->get_lokasi_kategori();
		header('Content-Type: application/json');
		echo json_encode($dataArray);
	}

	public function plan_lokasi_jenis()
	{
		$this->log_request();
		$id = $_REQUEST['jenis'];
		$result = [];
		$dataArray = $this->plan_lokasi_model->get_lokasi_api($id);
		foreach ($dataArray as $jenis) {
			$tmp = array(
				"type" => "Feature",
				"properties" => array(
					// "id" => $jenis['id'],
					"deskripsi" => $jenis['desk_sarana'],
					"nama" => $jenis['nama_sarana']
				),
				"geometry" => array(
					"type" => 'Polygon',
					"coordinates" => json_decode($jenis['path'])
				)
			);
			$result[] = $tmp;
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function plan_persil()
	{
		if (!$this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'data_persil', 'b'))
			redirect("");
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
					"Alamat" => $persil['Alamat'],
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
		// $result = array(
		// 	"type" => "FeatureCollection",
		// 	"features" => $result
		// );
		// $json_send = array(
		// 	"data" => $persilArray
		// );
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function dusun()
	{
		$this->log_request();
		$result = [];
		$dataArray = $this->wilayah_model->list_dusun_api();
		$jenis = $_REQUEST['jenis'];
		$kategori = $_REQUEST['kategori'];
		foreach ($dataArray as $dusun) {
			$resultSarana = [];
			$saranaAll = $this->plan_lokasi_model->get_lokasi_by_dusun($dusun['dusun'], $jenis, $kategori);
			foreach ($saranaAll as $sarana) {
				$tmpSarana = array(
					"nama" => $sarana['nama_sarana'],
					"kategori" => $sarana['kategori'],
					"jenis" => $sarana['jenis'],
					"desk" => $sarana['desk_sarana'],
				);
				$resultSarana[] = $tmpSarana;
			}

			$tmp = array(
				"type" => "Feature",
				"id" => $dusun['id'],
				"lat" => $dusun['lat'],
				"lng" => $dusun['lng'],
				"properties" => array(
					"nama_dusun" => $dusun['dusun'],
					"sarana_aset" => $resultSarana,
				),
				"geometry" => array(
					"type" => "MultiPolygon",
					"coordinates" => json_decode('['.$dusun['path'].']')
				)
			);
			$result[] = $tmp;
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function plan_tutupan_lahan()
	{
		$this->log_request();
		$result = [];
		$dataArray = $this->tutupan_lahan_model->list_tutupan_lahan_api();
		foreach ($dataArray as $lahan) {
			if ($lahan['jenis'] == 'Jalan' or $lahan['jenis'] == 'Saluran & Sungai') {
				$type = 'LineString';
			} else {
				$type = 'Polygon';
			}
			$tmp = array(
				"type" => "Feature",
				"id" => $lahan['id'],
				"properties" => array(
					"deskripsi" => $lahan['deskripsi'],
					"jenis" => $lahan['jenis'],
					"luas" => $lahan['luas'],
					"pemilik" => $lahan['pemilik'],
					"kelas" => $lahan['kelas'],
					"alamat" => $lahan['alamat'],
					"warna" => $lahan['warna']
				),
				"geometry" => array(
					"type" => 'MultiPolygon',
					"coordinates" => json_decode('['.$lahan['path'].']')
				)
			);
			$result[] = $tmp;
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function plan_tutupan_lahan_jenis()
	{
		$this->log_request();
		// $jenis = $_REQUEST['jenis'];
		$dataArray = $this->tutupan_lahan_model->list_tutupan_lahan_api_jenis();
		header('Content-Type: application/json');
		echo json_encode($dataArray);
	}

	public function plan_tutupan_lahan_jenis_fe()
	{
		$this->log_request();
		$dataArray = $this->tutupan_lahan_model->list_tutupan_lahan_api_jenis_fe();

		$result = [];

		foreach ($dataArray as $jenis) {

			$tmp = array(
				"id" => $jenis['jenis_id'],
				"nama" => $jenis['jenis_nama'],
				"warna" => $jenis['jenis_warna'],
			);
			$result[] = $tmp;
		}

		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function statistik_penduduk($kat, $desaId)
	{
		if(isset($_REQUEST['logApp']) && $_REQUEST['logApp'] == 'true') {

		} else {
			// if (!$this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'penduduk', 'b'))
			// 	redirect("");
		}
		// $desaId = ($_SESSION['filterIdDesa'] ? $_SESSION['filterIdDesa'] : 0);
		$result = [];
		$dataArray = $this->wilayah_model->list_rt_gis_api('','',$desaId);
		// $dataArray = $this->wilayah_model->list_rt_gis_api_2();
		foreach ($dataArray as $rt) {
			$lapKats = $this->laporan_penduduk_api_model->list_data_api($kat, 0, $rt['id']);
			$arrmer = [];
			foreach ($lapKats as $k => $v) {

				// $arrmer[$v['nama']] = $v['jumlah'];
				$id_cluster = $rt['id'];
				$id = $v['id'];
				// $arrmer[$v['nama'] . '_dl'] = site_url("penduduk/statistik_download/$kat/$id/0/$id_cluster");

				$arrmer[$v['nama']] = array(
					'jumlah' => $v['jumlah'],
					// 'file' => site_url("penduduk/statistik_download/$kat/$id/0/$id_cluster")
				);
			}

			$tmp = array(
				"type" => "Feature",
				"id" => $rt['id'],
				"properties" => array_merge(
					array(
						"rt" => $rt['rt'],
						"rw" => $rt['rw'],
						"dusun" => $rt['dusun'],
						"desa" => $rt['desa'],
						"kabupaten" => $rt['kabupaten']
					),
					$arrmer
				),
				"geometry" => array(
					"type" => "Polygon",
					"coordinates" => json_decode($rt['path'])
				)
			);
			$result[] = $tmp;
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function statistik_sub($kat)
	{
		if(isset($_REQUEST['logApp']) && $_REQUEST['logApp'] == 'true') {

		} else {
			// if (!$this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'penduduk', 'b'))
			// 	redirect("");
		}
		$this->log_request();
		$lapKats = $this->laporan_penduduk_api_model->list_data_api_kat($kat);
		$arrmer = [];
		foreach ($lapKats as $k => $v) {
			$arrmer[$v['nama']] = $v['jumlah'];
		}
		header('Content-Type: application/json');
		echo json_encode($arrmer);
	}

	public function analisa_leuit()
	{
		if(isset($_REQUEST['year'])) {
			$year = $_REQUEST['year'];
		} else {
			$year = '';
		}
		// if(isset($_REQUEST['desa'])) {
		// 	$desaId = $_REQUEST['desa'];
		// } else {
		// 	$desaId = '';
		// }
		$result = [];
		$no = 1;
		$dataArray = $this->config_model->get_data_all_leuit($year);
		foreach ($dataArray as $desa) {
			if($desa['total_input'] != null) {
				$total_input = (float)$desa['total_input'];
			} else {
				$total_input = 0;
			}
			if($desa['total_output'] != null) {
				$total_output = (float)$desa['total_output'];
			} else {
				$total_output = 0;
			}
			
			$newKab = str_replace("KABUPATEN","KAB. ",$desa['nama_kabupaten']);
			$tmp = array(
				"no" => $no++,
				"id" => $desa['id'],
				"nama_desa" => $desa['nama_desa'],
				"nama_kecamatan" => $desa['nama_kecamatan'],
				"nama_kabupaten" => $newKab,
				"leuit_input" => ton2($total_input),
				"leuit_output" => ton2($total_output),
				"leuit_stok" => ton2(($total_input - $total_output)),
				"leuit_output_komersil" => ton2($desa['komersil']),
				"leuit_output_produksi" => ton2($desa['produksi']),
				"leuit_output_logistik" => ton2($desa['logistik']),
				"geometry" => array(
					"lat" => $desa['lat'],
					"lng" => $desa['lng'],
					"path" => json_decode($desa['path']),
				),
			);
			$result[] = $tmp;
		}
		$hasil = array("data" => $result);
		header('Content-Type: application/json');
		echo json_encode($hasil);
	}
}
