<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class List_desa extends Admin_Controller {

	// private $header;
	// private $set_page;
	// private $list_session;

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('header_model');
		$this->load->model('config_model');
		$this->load->model('wilayah_model');
		$this->modul_ini = 227;
		$this->sub_modul_ini = 228;
		$this->header = $this->header_model->get_data();
	}

	public function index()
	{
		$this->header['minsidebar'] = 1;
		$this->tab_ini = 16;

		$data['func'] = 'index';
		$data['set_page'] = $this->set_page;
		$data["provinsi"] = $this->config_model->get_provinsi_global();

		$data['listdesa'] = $this->config_model->get_data_all();
		$data['listkab'] = $this->config_model->get_kab();
		$data['sebutandesa'] = ucwords($this->setting->sebutan_desa);
		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);

		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('list_desa/index', $data);
		$this->load->view('footer');
	}

	public function sub($desaid='') {
		$this->tab_ini = 16;

		$data['listwil'] = $this->wilayah_model->cluster_by_desa($desaid);
		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('list_desa/sub', $data);
		$this->load->view('footer');
	}
}
