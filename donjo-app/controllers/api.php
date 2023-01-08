<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR | E_PARSE);

class Api extends Api_Controller
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
			'user_model'
		]);
	}

	private function http_response_code($code = NULL) {
        if ($code !== NULL) {
            switch ($code) {
                case 100: $text = 'Continue';
                    break;
                case 101: $text = 'Switching Protocols';
                    break;
                case 200: $text = 'OK';
                    break;
                case 201: $text = 'Created';
                    break;
                case 202: $text = 'Accepted';
                    break;
                case 203: $text = 'Non-Authoritative Information';
                    break;
                case 204: $text = 'No Content';
                    break;
                case 205: $text = 'Reset Content';
                    break;
                case 206: $text = 'Partial Content';
                    break;
                case 300: $text = 'Multiple Choices';
                    break;
                case 301: $text = 'Moved Permanently';
                    break;
                case 302: $text = 'Moved Temporarily';
                    break;
                case 303: $text = 'See Other';
                    break;
                case 304: $text = 'Not Modified';
                    break;
                case 305: $text = 'Use Proxy';
                    break;
                case 400: $text = 'Bad Request';
                    break;
                case 401: $text = 'Unauthorized';
                    break;
                case 402: $text = 'Payment Required';
                    break;
                case 403: $text = 'Forbidden';
                    break;
                case 404: $text = 'Not Found';
                    break;
                case 405: $text = 'Method Not Allowed';
                    break;
                case 406: $text = 'Not Acceptable';
                    break;
                case 407: $text = 'Proxy Authentication Required';
                    break;
                case 408: $text = 'Request Time-out';
                    break;
                case 409: $text = 'Conflict';
                    break;
                case 410: $text = 'Gone';
                    break;
                case 411: $text = 'Length Required';
                    break;
                case 412: $text = 'Precondition Failed';
                    break;
                case 413: $text = 'Request Entity Too Large';
                    break;
                case 414: $text = 'Request-URI Too Large';
                    break;
                case 415: $text = 'Unsupported Media Type';
                    break;
                case 500: $text = 'Internal Server Error';
                    break;
                case 501: $text = 'Not Implemented';
                    break;
                case 502: $text = 'Bad Gateway';
                    break;
                case 503: $text = 'Service Unavailable';
                    break;
                case 504: $text = 'Gateway Time-out';
                    break;
                case 505: $text = 'HTTP Version not supported';
                    break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                    break;
            }
            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
            header($protocol . ' ' . $code . ' ' . $text);
            $GLOBALS['http_response_code'] = $code;
        } else {
            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
        }
        return $code;
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

	public function desa($id = 0)
	{
		$this->log_request();
		$json_send = [];
		if($id) {
			$desa = $this->config_model->get_desa($id);
		} else {
			$desa = $this->config_model->get_data_all();
		}
		// foreach ($desaall as $desa) {
		// 	$json_send[$k] = $this->group_by("jenis", $lok, false);
		// }
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: http://man.info');
		echo json_encode($desa);
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
		header('Content-Type: application/json');
		echo json_encode($lokasi);
	}

	public function lokasi()
	{
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

	public function lokasi_kategori()
	{
		$this->log_request();
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
					"type" => "Polygon",
					"coordinates" => json_decode($dusun['path'])
				)
			);
			$result[] = $tmp;
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function tutupan_lahan()
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
					"type" => 'Polygon',
					"coordinates" => json_decode($lahan['path'])
				)
			);
			$result[] = $tmp;
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function tutupan_lahan_jenis()
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
		$result = [];
		$dataArray = $this->wilayah_model->list_rt_gis_api('','',$desaId);
		foreach ($dataArray as $rt) {
			$lapKats = $this->laporan_penduduk_api_model->list_data_api($kat, 0, $rt['id']);
			$arrmer = [];
			foreach ($lapKats as $k => $v) {
				$id_cluster = $rt['id'];
				$id = $v['id'];

				$arrmer[$v['nama']] = array(
					'jumlah' => $v['jumlah'],
				);
			}

			$tmp = array(
				// 'status' => $this->http_response_code(),
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
		$this->log_request();
		$lapKats = $this->laporan_penduduk_api_model->list_data_api_kat($kat);
		$arrmer = [];
		foreach ($lapKats as $k => $v) {
			$arrmer[$v['nama']] = $v['jumlah'];
		}
		header('Content-Type: application/json');
		echo json_encode($arrmer);
	}
}
