<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Setting_provinsi extends Admin_Controller {

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
		$this->sub_modul_ini = 226;
		$this->header = $this->header_model->get_data();
	}

	public function index()
	{
		$this->header['minsidebar'] = 1;
		$this->tab_ini = 16;

		$data['func'] = 'index';
		$data['set_page'] = $this->set_page;
		$data["provinsi"] = $this->config_model->get_provinsi_global();

		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('setting_provinsi/index', $data);
		$this->load->view('footer');
	}

	public function updateMap()
	{
		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data["provinsi"] = $this->config_model->get_provinsi_global();
		$data['listprovinsi'] = $this->config_model->get_provinsi();
		$data['listkota'] = $this->config_model->get_kota($data['provinsi']['id_provinsi']);
		$data['listkec'] = $this->config_model->get_kec($data['provinsi']['id_kota']);
		$data['listkel'] = $this->config_model->get_keldesa($data['provinsi']['id_kecamatan']);

		$data['wil_atas'] = $this->config_model->get_provinsi_global();
		$data['breadcrumb'] = array(
			array('link' => site_url('setting_provinsi'), 'judul' => "Wilayah Provinsi"),
		);
		$data['form_action'] = site_url("setting_provinsi/import_shp");
		$namaprov =  $data['wil_atas']['nama_provinsi'];

		$this->load->view('header', $header);
		$this->load->view('nav');
		$this->load->view("setting_provinsi/maps_provinsi", $data);
		$this->load->view('footer');
	}

	public function import_shp()
	{
		$this->config_model->importShp();
		// print_r($this->config_model->importShp());
		redirect("setting_provinsi");
	}


	public function form()
	{
		$data["provinsi"] = $this->config_model->get_provinsi_global();
		$data['listprovinsi'] = $this->config_model->get_provinsi();
		$data['listkota'] = $this->config_model->get_kota($data['provinsi']['id_provinsi']);
		$data['listkec'] = $this->config_model->get_kec($data['provinsi']['id_kota']);
		$data['listkel'] = $this->config_model->get_keldesa($data['provinsi']['id_kecamatan']);
		$data['form_action'] = site_url("setting_provinsi/update_deskripsi");

		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$nav['tip'] = 3;

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('setting_provinsi/form', $data);
		$this->load->view('footer');
	}

	// public function update($id = '')
	// {
	// 	$header = $this->header_model->get_data();
	// 	$header['minsidebar'] = 1;
	// 	$sebutan_desa = ucwords($this->setting->sebutan_desa);
	// 	$data["provinsi"] = $this->config_model->get_provinsi_global();
	// 	$data['breadcrumb'] = array(
	// 		array('link' => site_url('setting_provinsi'), 'judul' => "Setting Provinsi"),
	// 	);
	// 	$data['form_action'] = site_url("setting_provinsi/update_deskripsi");
	// 	$namadesa =  $data['wil_atas']['nama_desa'];
	// 	if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
	// 	{
	// 		$this->load->view('header', $header);
	// 		$this->load->view('nav');
	// 		$this->load->view("setting_provinsi/maps_provinsi", $data);
	// 		$this->load->view('footer');
	// 	}
	// 	else
	// 	{
	// 		$_SESSION['success'] = -1;
	// 		$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
	// 		redirect("setting_provinsi");
	// 	}
	// }

	public function update_deskripsi()
	{
		$this->config_model->updateProvinsi();
		redirect("setting_provinsi");
	}
}
