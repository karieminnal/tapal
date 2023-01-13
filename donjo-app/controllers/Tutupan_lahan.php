<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tutupan_lahan extends Admin_Controller {

	// private $header;
	private $set_page;
	private $list_session;

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('header_model');
		$this->load->model('config_model');
		$this->load->model('wilayah_model');
		$this->load->model('tutupan_lahan_model');
		$this->controller = 'tutupan_lahan';
		$this->modul_ini = 7;
		$this->sub_modul_ini = 214;
		$this->set_page = ['20', '50', '100', '500', '1000'];
		$this->header = $this->header_model->get_data();
	}

	public function clear()
	{
		$this->session->unset_userdata($this->list_session);
		$this->session->per_page = $this->set_page[0];
		unset($_SESSION['tutupan_lahan_jenis']);
		redirect('tutupan_lahan');
	}

	public function index($page=1, $o=0)
	{
		$this->header['minsidebar'] = 1;
		$this->tab_ini = 16;

		if (isset($_SESSION['tutupan_lahan_jenis']))
			$data['filter_jenis'] = $_SESSION['tutupan_lahan_jenis'];
		else $data['filter_jenis'] = '';
		if (isset($_POST['per_page']))
			$_SESSION['per_page'] = $_POST['per_page'];
			
		$filterDesa = $_SESSION['filterDesa'];
		$data['per_page'] = $this->session->per_page;

		$data['func'] = 'index';
		$data['set_page'] = $this->set_page;
		$data['desa'] = $this->config_model->get_desa($filterDesa);
		$data['paging']  = $this->tutupan_lahan_model->paging($page);
		$data["tutupan_lahan"] = $this->tutupan_lahan_model->list_data($data['paging']->offset, $data['paging']->per_page);
		$data['tutupan_lahan_jenis'] = $this->tutupan_lahan_model->list_tutupan_lahan_api_jenis();

		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('tutupan_lahan/index', $data);
		$this->load->view('footer');
	}

	public function ajax_map()
	{
		$filterDesa = $_SESSION['filterDesa'];
		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data["desa"] = $this->config_model->get_desa($filterDesa);

		$data['wil_atas'] = $this->config_model->get_desa($filterDesa);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis_desaid();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis_desaid();
		$data['tutupan_lahan_jenis'] = $this->tutupan_lahan_model->list_tutupan_lahan_api_jenis();
		$data['breadcrumb'] = array(
			array('link' => site_url('tutupan_lahan'), 'judul' => "Daftar Tutupan Lahan"),
		);
		$data['form_action'] = site_url("tutupan_lahan/import_shp");
		$namadesa =  $data['wil_atas']['nama_desa'];
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->load->view('header', $header);
			$this->load->view('nav');
			$this->load->view("tutupan_lahan/maps_tutupan_lahan", $data);
			$this->load->view('footer');
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("tutupan_lahan");
		}
	}

	public function import_shp()
	{
		$this->tutupan_lahan_model->import();
		redirect("tutupan_lahan");
	}

	public function update($id = '')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data["desa"] = $this->config_model->get_desa($filterDesa);
		$data["tutupan_lahan"] = $this->tutupan_lahan_model->get_tutupan_lahan($id);

		$data['wil_atas'] = $this->config_model->get_data();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis_desaid();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis_desaid();
		$data['tutupan_lahan_jenis'] = $this->tutupan_lahan_model->list_tutupan_lahan_api_jenis();
		$data['breadcrumb'] = array(
			array('link' => site_url('tutupan_lahan'), 'judul' => "Daftar Tutupan Lahan"),
		);
		$data['form_action'] = site_url("tutupan_lahan/update_deskripsi");
		$namadesa =  $data['wil_atas']['nama_desa'];
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->load->view('header', $header);
			$this->load->view('nav');
			$this->load->view("tutupan_lahan/maps_tutupan_lahan", $data);
			$this->load->view('footer');
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("tutupan_lahan");
		}
	}

	public function update_deskripsi()
	{
		$this->tutupan_lahan_model->update_deskripsi();
		redirect("tutupan_lahan");
	}

	public function filter_jenis()
	{
		unset($_SESSION['tutupan_lahan_jenis']);
		$jenis = $this->input->post('jenis');
		if ($jenis != 0)
			$_SESSION['tutupan_lahan_jenis'] = $jenis;
		else unset($_SESSION['tutupan_lahan_jenis']);
		redirect('tutupan_lahan');
	}

	public function delete()
	{
		// $this->redirect_hak_akses('h', "plan/index/$p/$o");
		$this->tutupan_lahan_model->delete_all();
		redirect("tutupan_lahan");
	}

	public function sawarSearch($dusun = '') {
		
		// $data['list_sawah_search'] = $this->tutupan_lahan_model->list_sawah_bydusun($filterDesa, 5, $dusun);
		$filterDesa = $_SESSION['filterDesa'];
		$result = [];
		$list_sawah = $this->tutupan_lahan_model->list_sawah_bydusun($filterDesa, 5, $dusun);
		if($list_sawah) {
			foreach ($list_sawah as $lahan) {
				$tmp = array(
					'status' => 1,
					"type" => "Feature",
					"id" => $lahan['id'],
					"id_desa" => $lahan['id_desa'],
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
		} else {
			$result[] = array(
				'status' => 0,
				'message' => 'Data tidak ditemukan'
			);
		}
		// header('Content-Type: application/json');
		echo json_encode($result);

		// if($list_sawah) {
		// 	echo json_encode($list_sawah);
		// } else {
		// 	echo json_encode('Data tidak ditemukan');
		// }
	}
}
