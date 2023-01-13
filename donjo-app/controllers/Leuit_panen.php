<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Leuit_panen extends Admin_Controller {

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
		$this->load->model('leuit_panen_model');
		$this->load->model('tutupan_lahan_model');
		// $this->load->model('leuit_produksi');
		$this->controller = 'leuit_panen';
		$this->modul_ini = 220;
		$this->sub_modul_ini = 222;
		$this->set_page = ['20', '50', '100'];
		$this->header = $this->header_model->get_data();
	}

	public function clear()
	{
		$this->session->unset_userdata($this->list_session);
		$this->session->per_page = $this->set_page[0];
		// unset($_SESSION['tutupan_lahan_jenis']);
		redirect('leuit_panen');
	}

	public function index($page=1, $o=0)
	{
		$this->header['minsidebar'] = 1;
		$this->tab_ini = 16;

		if (isset($_POST['per_page']))
			$_SESSION['per_page'] = $_POST['per_page'];

		if (isset($_REQUEST['year'])) {
			$data['filteryear'] = $_REQUEST['year'];
		} else {
			$data['filteryear'] = '';
		}
		if (isset($_REQUEST['sawah'])) {
			$data['filtersawah'] = $_REQUEST['sawah'];
		} else {
			$data['filtersawah'] = '';
		}
		if (isset($_REQUEST['dusun'])) {
			$data['filterdusun'] = $_REQUEST['dusun'];
		} else {
			$data['filterdusun'] = '';
		}
		if (isset($_REQUEST['ts'])) {
			$data['tampilsawah'] = $_REQUEST['ts'];
		} else {
			$data['tampilsawah'] = '';
		}
		$filterDesa = $_SESSION['filterDesa'];

		$data['per_page'] = $this->session->per_page;

		$data['func'] = 'index';
		$data['set_page'] = $this->set_page;
		$data['desa'] = $this->config_model->get_desa($filterDesa);
		
		$data['dusun'] = $this->wilayah_model->list_dusun_desa($filterDesa);
		$data['rw'] = $this->wilayah_model->list_rw_bydesa($data['lokasi']['dusun']);
		$data['rt'] = $this->wilayah_model->list_rt_bydesa($data['lokasi']['dusun'], $data['lokasi']['rw']);
		$data['list_sawah'] = $this->tutupan_lahan_model->get_tutupan_lahan_desa_jenis($filterDesa, 5);

		$data['paging']  = $this->leuit_panen_model->paging($page);
		$data["leuit_panen"] = $this->leuit_panen_model->list_data($data['paging']->offset, $data['paging']->per_page, $data['filteryear'], $data['filtersawah'], $data['filterdusun'], $filterDesa);
		$data["total_produksi"] = $this->leuit_panen_model->get_total_produksi_row($data['filteryear'], $data['filtersawah'], $dusun, $filterDesa);
		$data["panen_group"] = $this->leuit_panen_model->get_total_by_dusun($data['paging']->offset, $data['paging']->per_page, $data['filteryear'], $data['filtersawah'], $data['filterdusun'], $data['tampilsawah'], $filterDesa);
		$data["panen_get_tahun"] = $this->leuit_panen_model->get_panen_tahun($filterDesa);

		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('leuit/panen', $data);
		$this->load->view('footer');
	}

	public function form($id = '')
	{
		$this->header['minsidebar'] = 1;
		$this->tab_ini = 16;
		$filterDesa = $_SESSION['filterDesa'];
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['desa'] = $this->config_model->get_desa($filterDesa);
		$data['wil_atas'] = $this->config_model->get_desa($filterDesa);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun_desa($filterDesa);
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		// $data["tutupan_lahan"] = $this->tutupan_lahan_model->get_tutupan_lahan($id);
		
		$data['list_sawah'] = $this->tutupan_lahan_model->get_tutupan_lahan_desa_jenis($filterDesa, 5);

		if ($id)
		{
			$data['produksi'] = $this->leuit_panen_model->get_produksi($id);
			$data['form_action'] = site_url("leuit_panen/update/$id");
		}
		else
		{
			$data['produksi'] = null;
			$data['form_action'] = site_url("leuit_panen/insert");
		}
		$data['dusun'] = $this->wilayah_model->list_dusun_desa($filterDesa);
		$data['list_sawah_opt'] = $this->tutupan_lahan_model->list_sawah_bydusun($filterDesa, 5, $data['produksi']['dusun']);
		$data['rw'] = $this->wilayah_model->list_rw_bydesa($data['lokasi']['dusun']);
		$data['rt'] = $this->wilayah_model->list_rt_bydesa($data['lokasi']['dusun'], $data['lokasi']['rw']);

		// $data['dusun_id'] = $this->wilayah_model->get_dusun_maps($id);

		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('leuit/form_produksi', $data);
		$this->load->view('footer');
	}

	public function insert($tip = 1)
	{
		$this->leuit_panen_model->insert($tip);
		redirect("leuit_panen");
	}

	public function update($id = '')
	{
		// $header = $this->header_model->get_data();
		// $header['minsidebar'] = 1;
		// $sebutan_desa = ucwords($this->setting->sebutan_desa);
		// $data["desa"] = $this->config_model->get_data();
		// $data["leuit_panen"] = $this->leuit_panen_model->get_produksi($id);

		// $data['wil_atas'] = $this->config_model->get_data();
		// $data['dusun_gis'] = $this->wilayah_model->list_dusun();
		// $data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		// $data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		// $data['breadcrumb'] = array(
		// 	array('link' => site_url('leuit_panen'), 'judul' => "Daftar Sawah"),
		// );
		// $data['form_action'] = site_url("leuit_panen/update_deskripsi");
		// $namadesa =  $data['wil_atas']['nama_desa'];
		// if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		// {
		// 	$this->load->view('header', $header);
		// 	$this->load->view('nav');
		// 	$this->load->view("leuit/panen", $data);
		// 	$this->load->view('footer');
		// }
		// else
		// {
		// 	$_SESSION['success'] = -1;
		// 	$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
		// 	redirect("leuit_panen");
		// }
		
		$this->leuit_panen_model->update($id);
		redirect("leuit_panen");
	}

	public function update_deskripsi()
	{
		$this->leuit_panen_model->update_deskripsi();
		redirect("leuit_panen");
	}

	public function delete($id)
	{
		// $this->redirect_hak_akses('h', "plan/index/$p/$o");
		$this->leuit_panen_model->delete($id);
		redirect("leuit_panen");
	}

	public function deleteAll()
	{
		// $this->redirect_hak_akses('h', "plan/index/$p/$o");
		$this->leuit_panen_model->delete_all();
		redirect("leuit_panen");
	}
}
