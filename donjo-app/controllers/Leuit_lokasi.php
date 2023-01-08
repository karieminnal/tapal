<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Leuit_lokasi extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('header_model');
		$this->load->model('wilayah_model');
		$this->load->model('config_model');
		$this->load->model('leuit_lokasi_model');
		$this->load->model('plan_area_model');
		$this->load->model('plan_garis_model');
		$this->modul_ini = 220;
		$this->sub_modul_ini = 225;
	}

	public function clear()
	{
		unset($_SESSION['cari']);
		unset($_SESSION['filter']);
		unset($_SESSION['point']);
		unset($_SESSION['subpoint']);
		redirect('leuit_lokasi');
	}

	public function index($p = 1, $o = 0)
	{

		$data['p'] = $p;
		$data['o'] = $o;

		if (isset($_SESSION['cari']))
			$data['cari'] = $_SESSION['cari'];
		else $data['cari'] = '';

		if (isset($_SESSION['filter']))
			$data['filter'] = $_SESSION['filter'];
		else $data['filter'] = '';

		if (isset($_SESSION['point']))
			$data['point'] = $_SESSION['point'];
		else $data['point'] = '';

		if (isset($_SESSION['subpoint']))
			$data['subpoint'] = $_SESSION['subpoint'];
		else $data['subpoint'] = '';

		if (isset($_POST['per_page']))
			$_SESSION['per_page'] = $_POST['per_page'];
		
		$filterDesa = $_SESSION['filterDesa'];

		$data['per_page'] = $_SESSION['per_page'];

		// $data['paging'] = $this->leuit_lokasi_model->paging($p, $o);
		$data['main'] = $this->leuit_lokasi_model->list_data_desaid($filterDesa);
		$data['keyword'] = $this->leuit_lokasi_model->autocomplete();
		$data['list_point'] = $this->leuit_lokasi_model->list_point();
		$data['list_subpoint'] = $this->leuit_lokasi_model->list_subpoint();
		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$nav['tip'] = 3;

		// $data['lokasi'] = $this->leuit_lokasi_model->get_lokasi($filterDesa);

		$data['desa'] = $this->config_model->get_desa($filterDesa);
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['wil_atas'] = $this->config_model->get_data();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['all_lokasi'] = $this->leuit_lokasi_model->list_data();
		$data['all_garis'] = $this->plan_garis_model->list_data();
		$data['all_area'] = $this->plan_area_model->list_data();
		$data['desaid'] = $filterDesa;
		$data['form_action_maps'] = site_url("leuit_lokasi/update_maps/$filterDesa");

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('leuit/table', $data);
		$this->load->view('footer');
	}

	public function form($p = 1, $o = 0, $id = '')
	{
		$data['p'] = $p;
		$data['o'] = $o;

		$data['desa'] = $this->config_model->get_data();;
		$data['list_point'] = $this->leuit_lokasi_model->list_point();
		$data['dusun'] = $this->leuit_lokasi_model->list_dusun();

		if ($id) {
			$data['lokasi'] = $this->leuit_lokasi_model->get_lokasi($id);
			$data['form_action'] = site_url("leuit_lokasi/update/$id/$p/$o");
			$data['form_action_maps'] = site_url("leuit_lokasi/update_maps/$id/$p/$o");
		} else {
			$data['lokasi'] = NULL;
			$data['form_action'] = site_url("leuit_lokasi/insert");
			$data['form_action_maps'] = '';
		}

		$data['dusun'] = $this->wilayah_model->list_dusun();
		$data['rw'] = $this->wilayah_model->list_rw_bydesa($data['lokasi']['dusun']);
		$data['rt'] = $this->wilayah_model->list_rt_bydesa($data['lokasi']['dusun'], $data['lokasi']['rw']);

		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$nav['tip'] = 3;

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('leuit/form', $data);
		$this->load->view('footer');
	}

	public function ajax_lokasi_maps($p = 1, $o = 0, $id = '')
	{
		$data['p'] = $p;
		$data['o'] = $o;
		if ($id) {
			$data['lokasi'] = $this->leuit_lokasi_model->get_lokasi($id);
		} else {
			$data['lokasi'] = NULL;
		}
		$filterDesa = $_SESSION['filterDesa'];
		$data['desa'] = $this->config_model->get_desa($filterDesa);
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['wil_atas'] = $this->config_model->get_data();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['all_lokasi'] = $this->leuit_lokasi_model->list_data();
		$data['all_garis'] = $this->plan_garis_model->list_data();
		$data['all_area'] = $this->plan_area_model->list_data();
		$data['form_action'] = site_url("leuit_lokasi/update_maps/$p/$o/$id");
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav');
		$this->load->view("leuit/maps", $data);
		$this->load->view('footer');
	}

	public function update_maps($id_desa = '')
	{
		$this->leuit_lokasi_model->update_position($id_desa);
		redirect("leuit_lokasi");
	}

	public function search()
	{
		$cari = $this->input->post('cari');
		if ($cari != '')
			$_SESSION['cari'] = $cari;
		else unset($_SESSION['cari']);
		redirect('leuit_lokasi');
	}

	public function filter()
	{
		$filter = $this->input->post('filter');
		if ($filter != 0)
			$_SESSION['filter'] = $filter;
		else unset($_SESSION['filter']);
		redirect('leuit_lokasi');
	}

	public function point()
	{
		$point = $this->input->post('point');
		if ($point != 0)
			$_SESSION['point'] = $point;
		else unset($_SESSION['point']);
		redirect('leuit_lokasi');
	}

	public function subpoint()
	{
		unset($_SESSION['point']);
		$subpoint = $this->input->post('subpoint');
		if ($subpoint != 0)
			$_SESSION['subpoint'] = $subpoint;
		else unset($_SESSION['subpoint']);
		redirect('leuit_lokasi');
	}

	public function insert($tip = 1)
	{
		$this->leuit_lokasi_model->insert($tip);
		redirect("leuit_lokasi/index/$tip");
	}

	public function update($id = '', $p = 1, $o = 0)
	{
		$this->leuit_lokasi_model->update($id);
		redirect("leuit_lokasi/index/$p/$o");
	}

	public function delete($p = 1, $o = 0, $id = '')
	{
		$this->redirect_hak_akses('h', "plan/index/$p/$o");
		$this->leuit_lokasi_model->delete($id);
		redirect("leuit_lokasi/index/$p/$o");
	}

	public function delete_all($p = 1, $o = 0)
	{
		$this->redirect_hak_akses('h', "plan/index/$p/$o");
		$this->leuit_lokasi_model->delete_all();
		redirect("leuit_lokasi/index/$p/$o");
	}

	public function lokasi_lock($id = '')
	{
		$this->leuit_lokasi_model->lokasi_lock($id, 1);
		redirect("leuit_lokasi/index/$p/$o");
	}

	public function lokasi_unlock($id = '')
	{
		$this->leuit_lokasi_model->lokasi_lock($id, 2);
		redirect("leuit_lokasi/index/$p/$o");
	}
}
