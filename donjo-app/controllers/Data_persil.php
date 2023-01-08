<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_persil extends Admin_Controller
{

	// private $header;
	private $set_page;
	private $list_session;

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('header_model');
		$this->load->model('config_model');
		$this->load->model('data_persil_model');
		$this->load->model('cdesa_model');
		$this->load->model('penduduk_model');
		$this->load->model('wilayah_model');
		$this->controller = 'data_persil';
		$this->modul_ini = 7;
		$this->sub_modul_ini = 213;
		$this->set_page = ['20', '50', '100'];
		$this->header = $this->header_model->get_data();
		$this->list_session = ['cari'];
	}

	public function clear()
	{
		$this->session->unset_userdata($this->list_session);
		$this->session->per_page = $this->set_page[0];
		redirect('data_persil');
	}

	// TODO: fix
	public function autocomplete()
	{
		$data = $this->data_persil_model->autocomplete($this->input->post('cari'));
		echo json_encode($data);
	}

	public function search()
	{
		$this->session->cari = $this->input->post('cari') ?: NULL;
		redirect('data_persil');
	}

	public function index($page = 1, $o = 0)
	{
		$this->header['minsidebar'] = 1;
		$this->tab_ini = 13;

		$data['cari'] = htmlentities($_SESSION['cari']) ?: '';
		if (isset($_POST['per_page']))
			$_SESSION['per_page'] = $_POST['per_page'];
		else
			$_SESSION['per_page'] = $this->set_page[0];
		$data['per_page'] = $this->session->per_page;

		$data['func'] = 'index';
		$data['set_page'] = $this->set_page;
		$data["desa"] = $this->config_model->get_data();
		$data['paging']  = $this->data_persil_model->paging($page);
		$data["persil"] = $this->data_persil_model->list_data($data['paging']->offset, $data['paging']->per_page);
		// $data["persil_kelas"] = $this->data_persil_model->list_persil_kelas();
		// $data['keyword'] = $this->data_persil_model->autocomplete();

		// var_dump($data['persil']);die();

		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('data_persil/persil', $data);
		$this->load->view('footer');
	}

	public function rincian($id = 0)
	{
		$this->tab_ini = 13;
		$data = [];
		$data['persil'] = $this->data_persil_model->get_persil($id);
		$data['mutasi'] = $this->data_persil_model->get_list_mutasi($id);
		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('data_persil/rincian_persil', $data);
		$this->load->view('footer');
	}

	public function form($id = '', $id_cdesa = '')
	{
		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$this->tab_ini = 13;

		if ($id) $data["persil"] = $this->data_persil_model->get_persil($id);
		if ($id_cdesa) $data["id_cdesa"] = $id_cdesa;
		$data['list_cdesa'] = $this->cdesa_model->list_c_desa();
		$data["persil_lokasi"] = $this->data_persil_model->list_dusunrwrt();
		$data["persil_kelas"] = $this->data_persil_model->list_persil_kelas();
		$data["peruntukan_persil"] = unserialize(PERUNTUKAN_PERSIL);
		$data["list_penduduk"] = $this->data_persil_model->list_penduduk();

		$this->load->view('header', $header);
		$this->load->view('nav');
		$this->load->view('data_persil/form_persil', $data);
		$this->load->view('footer');
	}

	public function simpan_persil($page = 1)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('no_persil', 'Nomor Surat Persil', 'required|trim|numeric');
		// $this->form_validation->set_rules('nomor_urut_bidang','Nomor Urut Bidang','required|trim|numeric');
		// $this->form_validation->set_rules('kelas','Kelas Tanah','required|trim|numeric');

		if ($this->form_validation->run() != false) {
			$id_persil = $this->data_persil_model->simpan_persil($this->input->post());
			$cdesa_awal = $this->input->post('cdesa_awal');
			if (!$this->input->post('id_persil') and $cdesa_awal)
				redirect("cdesa/mutasi/$cdesa_awal/$id_persil");
			else
				redirect("data_persil");
		}

		$this->session->success = -1;
		$this->session->error_msg = trim(strip_tags(validation_errors()));
		$id	= $this->input->post('id_persil');
		redirect("data_persil/form/" . $id);
	}

	public function hapus($id)
	{
		$this->redirect_hak_akses('h', "data_persil");
		$this->data_persil_model->hapus($id);
		redirect("data_persil/clear");
	}

	public function import()
	{
		$data['form_action'] = site_url("data_persil/import_proses");
		$this->load->view('data_persil/import', $data);
	}

	public function import_proses()
	{
		$this->data_persil_model->impor_persil();
		redirect("data_persil");
	}

	public function cetak_persil($o = 0)
	{
		$data['data_persil'] = $this->data_persil_model->list_persil('', $o, 0, 10000);
		$this->load->view('data_persil/persil_print', $data);
	}

	public function excel($mode = "", $o = 0)
	{
		$data['mode'] = $mode;
		if ($mode == 'persil')
			$data['data_persil'] = $this->data_persil_model->list_persil('', $o, 0, 10000);
		else
			$data['data_persil'] = $this->data_persil_model->list_c_desa('', $o, 0, 10000);
		$data["persil_jenis"] = $this->data_persil_model->list_persil_jenis();
		$this->load->view('data_persil/persil_excel', $data);
	}

	public function kelasid()
	{
		$data = [];
		$id = $this->input->post('id');
		$kelas = $this->data_persil_model->list_persil_kelas($id);
		foreach ($kelas as $key => $item) {
			$data[] = array('id' => $key, 'kode' => $item['kode'], 'ndesc' => $item['ndesc']);
		}
		echo json_encode($data);
	}

	public function ajax_map()
	{
		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data["desa"] = $this->config_model->get_data();

		$data['wil_atas'] = $this->config_model->get_data();
		// $data['persil'] = $this->data_persil_model->get_persil();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['breadcrumb'] = array(
			array('link' => site_url('data_persil'), 'judul' => "Daftar Persil"),
		);
		$data['form_action'] = site_url("data_persil/import_shp");
		$namadesa =  $data['wil_atas']['nama_desa'];
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path'])))) {
			$this->load->view('header', $header);
			$this->load->view('nav');
			$this->load->view("data_persil/maps_persil", $data);
			$this->load->view('footer');
		} else {
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("data_persil");
		}
	}

	public function import_shp()
	{
		$this->data_persil_model->insert_persil();
		redirect("data_persil");
	}

	public function update($id = '')
	{
		$header = $this->header_model->get_data();
		$header['minsidebar'] = 1;
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data["desa"] = $this->config_model->get_data();
		$data["persil"] = $this->data_persil_model->get_persil($id);

		$data['wil_atas'] = $this->config_model->get_data();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['breadcrumb'] = array(
			array('link' => site_url('data_persil'), 'judul' => "Daftar Persil"),
		);
		$data['form_action'] = site_url("data_persil/simpan_update");
		$namadesa =  $data['wil_atas']['nama_desa'];
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path'])))) {
			$this->load->view('header', $header);
			$this->load->view('nav');
			$this->load->view("data_persil/maps_persil", $data);
			$this->load->view('footer');
		} else {
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("data_persil");
		}
	}

	public function simpan_update()
	{
		$this->data_persil_model->simpan_update();
		redirect("data_persil");
	}
}
