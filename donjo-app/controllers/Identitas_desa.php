<?php
/*
 * File ini:
 *
 * Controller di Modul Identitas Desa
 *
 * donjo-app/controllers/Identitas_desa.php
 *
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Identitas_desa extends Admin_Controller {

	private $_header;
	private $set_page;
	private $list_session;

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model(['header_model', 'config_model', 'wilayah_model', 'provinsi_model']);
		$this->_header = $this->header_model->get_data();
		$this->modul_ini = 200;
		$this->sub_modul_ini = 17;
	}

	public function index()
	{

		if (isset($_SESSION['filterDesa']))
			$data['filterDesa'] = $_SESSION['filterDesa'];
		else $data['filterDesa'] = '';

		$data['main'] = $this->config_model->get_desa($data['filterDesa']);
		$data['desa'] = ucwords($this->setting->sebutan_desa);
		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);
		$data['listprovinsi'] = $this->config_model->get_provinsi();

		$this->load->view('header', $this->_header);
		$this->load->view('nav');
		$this->load->view('identitas_desa/index', $data);
		$this->load->view('footer');
	}

	public function form()
	{
		if (isset($_SESSION['filterDesa']))
			$data['filterDesa'] = $_SESSION['filterDesa'];
		else $data['filterDesa'] = '';
		$filterDesa = $data['filterDesa'];
		// $data['main'] = $this->config_model->get_data();
		$data['desa'] = ucwords($this->setting->sebutan_desa);
		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);
		$data['list_provinsi'] = $this->provinsi_model->list_data();
		$data['listprovinsi'] = $this->config_model->get_provinsi();

		// Buat row data desa di form apabila belum ada data desa
		// if ($data['main'])
		// 	$data['form_action'] = site_url('identitas_desa/update/' . $data['main']['id']);
		// else
		// 	$data['form_action'] = site_url('identitas_desa/insert');

		if ($filterDesa){
			$data['main'] = $this->config_model->get_desa($data['filterDesa']);
			$data['listkota'] = $this->config_model->get_kota($data['main']['kode_propinsi']);
			$data['listkec'] = $this->config_model->get_kec($data['main']['kode_kabupaten']);
			$data['listdesa'] = $this->config_model->get_keldesa($data['main']['kode_kecamatan']);
			$data['form_action'] = site_url("identitas_desa/update/$filterDesa");
		} else {
			$data['main'] = null;
			$data['form_action'] = site_url('identitas_desa/insert');
		}

		$this->load->view('header', $this->_header);
		$this->load->view('nav');
		$this->load->view('identitas_desa/form', $data);
		$this->load->view('footer');
	}

	public function tambahDesa()
	{
		if (isset($_SESSION['filterDesa']))
			$data['filterDesa'] = $_SESSION['filterDesa'];
		else $data['filterDesa'] = '';
		$filterDesa = $data['filterDesa'];
		$data['desa'] = ucwords($this->setting->sebutan_desa);
		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);
		$data['list_provinsi'] = $this->provinsi_model->list_data();
		$data['listprovinsi'] = $this->config_model->get_provinsi();
		
		$data['main'] = null;
		$data['form_action'] = site_url('identitas_desa/insert');

		$this->load->view('header', $this->_header);
		$this->load->view('nav');
		$this->load->view('identitas_desa/form', $data);
		$this->load->view('footer');
	}

	public function insert()
	{
		$this->config_model->insert();
		$insert_id = $this->db->insert_id();
		$_SESSION['filterDesa'] = $insert_id;
		redirect('identitas_desa');
	}

	public function update($id = 0)
	{
		$this->config_model->update($id);
		redirect('identitas_desa');
	}

	public function maps($tipe = 'kantor')
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data_desa = $this->config_model->get_desa($filterDesa);
		$data['thisdesa'] = $this->config_model->get_desa($filterDesa);
		$data['desa'] = ucwords($this->setting->sebutan_desa);
		$data['wil_ini'] = $data_desa;
		$data['wil_atas']['lat'] = -6.9024589;
		$data['wil_atas']['lng'] = 107.6165074;
		$data['wil_atas']['zoom'] = 9;
		$data['wil_atas'] = $this->config_model->get_desa($filterDesa);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis_desaid();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis_desaid();
		$data['nama_wilayah'] = ucwords($desa . " " . $data_desa['nama_desa']);
		$data['wilayah'] = ucwords($desa . " " . $data_desa['nama_desa']);
		$data['breadcrumb'] = array(
			array('link' => site_url("identitas_desa"), 'judul' => "Identitas " . ucwords($desa)),
		);

		$data['form_action'] = site_url("identitas_desa/update_maps/$tipe");

		$this->load->view('header', $this->_header);
		$this->load->view('nav');
		$this->load->view('sid/wilayah/maps_' . $tipe, $data);
		$this->load->view('footer');
	}

	public function update_maps($tipe = 'kantor')
	{
		if ($tipe = 'kantor')
			$this->config_model->update_kantor();
		else
			$this->config_model->update_wilayah();

		redirect("identitas_desa");
	}

}
