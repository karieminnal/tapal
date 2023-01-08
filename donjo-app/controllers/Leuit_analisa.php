<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Leuit_analisa extends Admin_Controller {

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
		$this->load->model('leuit_analisa_model');
		$this->load->model('leuit_panen_model');
		$this->load->model('leuit_distribusi_model');
		$this->load->model('tutupan_lahan_model');
		$this->controller = 'leuit_analisa';
		$this->modul_ini = 220;
		$this->sub_modul_ini = 224;
		$this->set_page = ['20', '50', '100'];
		$this->header = $this->header_model->get_data();
	}

	public function clear()
	{
		$this->session->unset_userdata($this->list_session);
		$this->session->per_page = $this->set_page[0];
		// unset($_SESSION['tutupan_lahan_jenis']);
		redirect('leuit_analisa');
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
		if (isset($_REQUEST['desa'])) {
			$data['desaid'] = $_REQUEST['desa'];
		} else {
			$data['desaid'] = '';
		}

		$data['func'] = 'index';
		$data["desa"] = $this->config_model->get_data();
		// $data["leuit_input"] = $this->leuit_analisa_model->list_data_input($data['filteryear'], $data['desaid']);
		// $data['paging']  = $this->leuit_analisa_model->paging($page);
		// $data["leuit_analisa"] = $this->leuit_analisa_model->list_data($data['paging']->offset, $data['paging']->per_page);

		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('leuit/analisa', $data);
		$this->load->view('footer');
	}
}
