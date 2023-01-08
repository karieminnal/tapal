<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Leuit_distribusi extends Admin_Controller {

	private $set_page;
	private $list_session;

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('header_model');
		$this->load->model('config_model');
		$this->load->model('wilayah_model');
		$this->load->model('leuit_distribusi_model');
		$this->load->model('leuit_panen_model');
		$this->controller = 'leuit_distribusi';
		$this->modul_ini = 220;
		$this->sub_modul_ini = 223;
		$this->header = $this->header_model->get_data();
	}

	public function clear()
	{
		redirect('leuit_distribusi');
	}

	public function index()
	{
		$this->header['minsidebar'] = 1;
		$this->tab_ini = 16;

		if (isset($_REQUEST['year'])) {
			$data['filteryear'] = $_REQUEST['year'];
		} else {
			$data['filteryear'] = '';
		}
		$filterDesa = $_SESSION['filterDesa'];

		$data['func'] = 'index';
		$data['desa'] = $this->config_model->get_desa($filterDesa);
		
		$data['dusun'] = $this->wilayah_model->list_dusun_desa($filterDesa);
		$data['rw'] = $this->wilayah_model->list_rw_bydesa($data['lokasi']['dusun']);
		$data['rt'] = $this->wilayah_model->list_rt_bydesa($data['lokasi']['dusun'], $data['lokasi']['rw']);

		$data["leuit_distribusi"] = $this->leuit_distribusi_model->list_data($data['filteryear'], $filterDesa);
		$data["total_distribusi"] = $this->leuit_distribusi_model->get_total_distribusi_row($data['filteryear'], $filterDesa);
		$data["distribusi_group"] = $this->leuit_distribusi_model->get_total_distribusi_byjenis($data['filteryear'],'', $filterDesa);
		$data["distribusi_get_tahun"] = $this->leuit_distribusi_model->get_distribusi_tahun('');
		// $data["distribusi_group"] = $this->leuit_distribusi_model->get_total_by_dusun($data['filteryear'], $filterDesa);

		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('leuit/distribusi', $data);
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

		if ($id)
		{
			$data['distribusi'] = $this->leuit_distribusi_model->get_distribusi($id);
			$data['form_action'] = site_url("leuit_distribusi/update/$id");
		}
		else
		{
			$data['distribusi'] = null;
			$data['form_action'] = site_url("leuit_distribusi/insert");
		}
		$data['dusun'] = $this->wilayah_model->list_dusun_desa($filterDesa);
		$data['rw'] = $this->wilayah_model->list_rw_bydesa($data['lokasi']['dusun']);
		$data['rt'] = $this->wilayah_model->list_rt_bydesa($data['lokasi']['dusun'], $data['lokasi']['rw']);

		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('leuit/form_distribusi', $data);
		$this->load->view('footer');
	}

	public function insert($tip = 1)
	{
		$this->leuit_distribusi_model->insert($tip);
		redirect("leuit_distribusi");
	}

	public function update($id = '')
	{		
		$this->leuit_distribusi_model->update($id);
		redirect("leuit_distribusi");
	}

	public function update_deskripsi()
	{
		$this->leuit_distribusi_model->update_deskripsi();
		redirect("leuit_distribusi");
	}

	public function delete($id)
	{
		$this->leuit_distribusi_model->delete($id);
		redirect("leuit_distribusi");
	}

	public function deleteAll()
	{
		$this->leuit_distribusi_model->delete_all();
		redirect("leuit_distribusi");
	}
}
