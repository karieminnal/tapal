<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Leuit_sawah extends Admin_Controller {

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
		$this->load->model('leuit_sawah_model');
		$this->controller = 'leuit_sawah';
		$this->modul_ini = 220;
		$this->sub_modul_ini = 221;
		$this->set_page = ['20', '50', '100'];
		$this->header = $this->header_model->get_data();
	}

	public function clear()
	{
		$this->session->unset_userdata($this->list_session);
		$this->session->per_page = $this->set_page[0];
		unset($_SESSION['tutupan_lahan_jenis']);
		redirect('leuit_sawah');
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

		$data['per_page'] = $this->session->per_page;

		$data['func'] = 'index';
		$data['set_page'] = $this->set_page;
		$data["desa"] = $this->config_model->get_data();
		$data['paging']  = $this->leuit_sawah_model->paging($page);
		$data["leuit_sawah"] = $this->leuit_sawah_model->list_data($data['paging']->offset, $data['paging']->per_page);
		$data['tutupan_lahan_jenis'] = $this->leuit_sawah_model->list_leuit_sawah_api_jenis();

		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('leuit/index', $data);
		$this->load->view('footer');
	}

	public function ajax_map()
	{
		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data["desa"] = $this->config_model->get_data();

		$data['wil_atas'] = $this->config_model->get_data();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['tutupan_lahan_jenis'] = $this->leuit_sawah_model->list_leuit_sawah_api_jenis();
		$data['breadcrumb'] = array(
			array('link' => site_url('leuit_sawah'), 'judul' => "Daftar Sawah"),
		);
		$data['form_action'] = site_url("leuit_sawah/import_shp");
		$namadesa =  $data['wil_atas']['nama_desa'];
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->load->view('header', $header);
			$this->load->view('nav');
			$this->load->view("leuit/maps_leuit_sawah", $data);
			$this->load->view('footer');
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("leuit_sawah");
		}
	}

	public function import_shp()
	{
		$this->leuit_sawah_model->import();
		redirect("leuit_sawah");
	}

	public function update($id = '')
	{
		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data["desa"] = $this->config_model->get_data();
		$data["leuit_sawah"] = $this->leuit_sawah_model->get_leuit_sawah($id);

		$data['wil_atas'] = $this->config_model->get_data();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['tutupan_lahan_jenis'] = $this->leuit_sawah_model->list_leuit_sawah_api_jenis();
		$data['breadcrumb'] = array(
			array('link' => site_url('leuit_sawah'), 'judul' => "Daftar Sawah"),
		);
		$data['form_action'] = site_url("leuit_sawah/update_deskripsi");
		$namadesa =  $data['wil_atas']['nama_desa'];
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->load->view('header', $header);
			$this->load->view('nav');
			$this->load->view("leuit/maps_leuit_sawah", $data);
			$this->load->view('footer');
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("leuit_sawah");
		}
	}

	public function update_deskripsi()
	{
		$this->leuit_sawah_model->update_deskripsi();
		redirect("leuit_sawah");
	}

	public function filter_jenis()
	{
		unset($_SESSION['tutupan_lahan_jenis']);
		$jenis = $this->input->post('jenis');
		if ($jenis != 0)
			$_SESSION['tutupan_lahan_jenis'] = $jenis;
		else unset($_SESSION['tutupan_lahan_jenis']);
		redirect('leuit_sawah');
	}

	public function delete()
	{
		// $this->redirect_hak_akses('h', "plan/index/$p/$o");
		$this->leuit_sawah_model->delete_all();
		redirect("leuit_sawah");
	}
}
