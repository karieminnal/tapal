<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobile_app extends Web_Controller
{

	public function __construct()
	{
		parent::__construct();
		parent::clear_cluster_session();
		session_start();

		mandiri_timeout();
		$this->load->model(['header_model', 'pamong_model', 'penduduk_model', 'config_model', 'referensi_model', 'wilayah_model', 'provinsi_model']);
		$this->load->model('first_m');
		$this->load->model('first_artikel_m');
		$this->load->model('teks_berjalan_model');
		$this->load->model('first_gallery_m');
		$this->load->model('first_menu_m');
		$this->load->model('web_menu_model');
		$this->load->model('first_penduduk_m');
		$this->load->model('penduduk_model');
		$this->load->model('surat_model');
		$this->load->model('keluarga_model');
		$this->load->model('web_widget_model');
		$this->load->model('web_gallery_model');
		$this->load->model('laporan_penduduk_model');
		$this->load->model('keluar_model');
		$this->load->model('keuangan_model');
		$this->load->model('keuangan_manual_model');
		$this->load->model('web_dokumen_model');
		$this->load->model('mailbox_model');
		$this->load->model('lapor_model');
		$this->load->model('program_bantuan_model');
		$this->load->model('keuangan_manual_model');
		$this->load->model('keuangan_grafik_model');
		$this->load->model('keuangan_grafik_manual_model');
		$this->load->model('plan_lokasi_model');
		$this->load->model('plan_area_model');
		$this->load->model('plan_garis_model');
		$this->load->model('plan_point_model');
		$this->load->model('wilayah_model');
		$this->load->model('user_model');
		$this->load->model('leuit_lokasi_model');
		$this->load->model('leuit_panen_model');
		$this->load->model('leuit_distribusi_model');
		$this->load->model('tutupan_lahan_model');

		$this->load->model('data_persil_model');
	}


	public function index()
	{
		$data = $this->includes;

		$_SESSION['from_first'] = true;

		$data['list_dusun'] = $this->penduduk_model->list_dusun();
		$data['wilayah'] = $this->penduduk_model->list_wil();
		$data['desa'] = $this->config_model->get_data();
		$data['penduduk'] = $this->penduduk_model->list_data_map();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun_all();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['list_lap'] = $this->referensi_model->list_lap();
		$data['list_lap_front'] = $this->referensi_model->list_lap_front();
		$data['lokasi'] = $this->plan_lokasi_model->list_lokasi();
		$data['garis'] = $this->plan_garis_model->list_garis();
		$data['area'] = $this->plan_area_model->list_area();

		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);
		$data['pengurus'] = $this->pamong_model->list_data();

		$data['persilArray'] = $this->data_persil_model->list_persil();
		$data['jenisLokasi'] = $this->plan_point_model->list_data_menu_gis();
		$this->load->model('user_model');
		$data['show_persil'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'data_persil', 'b') ? true : false;
		$data['show_penduduk'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'penduduk', 'b') ? true : false;
		$data['total_penduduk'] = $this->header_model->penduduk_total();

		$data['userdata'] = $this->header_model->get_data();
		$this->_get_common_data($data);
		$this->load->view('web/app/gis.php', $data);
	}

	public function saranaPrasarana()
	{
		$data = $this->includes;

		$_SESSION['from_first'] = true;

		$data['list_dusun'] = $this->penduduk_model->list_dusun();
		$data['wilayah'] = $this->penduduk_model->list_wil();
		$data['desa'] = $this->config_model->get_data();
		$data['penduduk'] = $this->penduduk_model->list_data_map();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun_all();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['list_lap'] = $this->referensi_model->list_lap();
		$data['list_lap_front'] = $this->referensi_model->list_lap_front();
		$data['lokasi'] = $this->plan_lokasi_model->list_lokasi();
		$data['garis'] = $this->plan_garis_model->list_garis();
		$data['area'] = $this->plan_area_model->list_area();

		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);

		$data['jenisLokasi'] = $this->plan_point_model->list_data_menu_gis();
		$this->load->model('user_model');

		$data['userdata'] = $this->header_model->get_data();
		$data['listprovinsi'] = $this->config_model->get_provinsi();
		$data['listkota'] = $this->config_model->get_kota(32);
		// $data['desa'] = $this->config_model->get_desa($desaid);
		$data['listdesa'] = $this->config_model->get_data_all();
		// $data['filterDesa'] = $desaid;
		$this->_get_common_data($data);
		$this->load->view('web/app/saranaprasarana.php', $data);
	}

	public function asetDesa()
	{
		$data = $this->includes;

		$_SESSION['from_first'] = true;

		$data['list_dusun'] = $this->penduduk_model->list_dusun();
		$data['wilayah'] = $this->penduduk_model->list_wil();
		$data['desa'] = $this->config_model->get_data();
		$data['penduduk'] = $this->penduduk_model->list_data_map();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun_all();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['list_lap'] = $this->referensi_model->list_lap();
		$data['list_lap_front'] = $this->referensi_model->list_lap_front();
		$data['lokasi'] = $this->plan_lokasi_model->list_lokasi();
		$data['garis'] = $this->plan_garis_model->list_garis();
		$data['area'] = $this->plan_area_model->list_area();

		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);

		$data['jenisLokasi'] = $this->plan_point_model->list_data_menu_gis();
		$this->load->model('user_model');

		$data['userdata'] = $this->header_model->get_data();

		$this->_get_common_data($data);
		$this->load->view('web/app/asetdesa.php', $data);
	}

	public function potensiDesa()
	{
		$data = $this->includes;

		$_SESSION['from_first'] = true;

		$data['list_dusun'] = $this->penduduk_model->list_dusun();
		$data['wilayah'] = $this->penduduk_model->list_wil();
		$data['desa'] = $this->config_model->get_data();
		$data['penduduk'] = $this->penduduk_model->list_data_map();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun_all();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['list_lap'] = $this->referensi_model->list_lap();
		$data['list_lap_front'] = $this->referensi_model->list_lap_front();
		$data['lokasi'] = $this->plan_lokasi_model->list_lokasi();
		$data['garis'] = $this->plan_garis_model->list_garis();
		$data['area'] = $this->plan_area_model->list_area();

		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);

		$data['jenisLokasi'] = $this->plan_point_model->list_data_menu_gis();
		$this->load->model('user_model');

		$data['userdata'] = $this->header_model->get_data();

		$this->_get_common_data($data);
		$this->load->view('web/app/potensidesa.php', $data);
	}

	public function tutupanLahan()
	{
		$data = $this->includes;

		$_SESSION['from_first'] = true;

		$data['list_dusun'] = $this->penduduk_model->list_dusun();
		$data['wilayah'] = $this->penduduk_model->list_wil();
		$data['desa'] = $this->config_model->get_data();
		$data['penduduk'] = $this->penduduk_model->list_data_map();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun_all();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['list_lap'] = $this->referensi_model->list_lap();
		$data['list_lap_front'] = $this->referensi_model->list_lap_front();
		$data['lokasi'] = $this->plan_lokasi_model->list_lokasi();
		$data['garis'] = $this->plan_garis_model->list_garis();
		$data['area'] = $this->plan_area_model->list_area();

		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);
		$data['pengurus'] = $this->pamong_model->list_data();

		$data['persilArray'] = $this->data_persil_model->list_persil();
		$data['jenisLokasi'] = $this->plan_point_model->list_data_menu_gis();
		$this->load->model('user_model');
		$data['show_persil'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'data_persil', 'b') ? true : false;
		$data['show_penduduk'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'penduduk', 'b') ? true : false;
		$data['total_penduduk'] = $this->header_model->penduduk_total();

		$data['userdata'] = $this->header_model->get_data();
		$this->_get_common_data($data);
		$this->load->view('web/app/tutupanlahan.php', $data);
	}

	public function persil()
	{
		$data = $this->includes;

		$_SESSION['from_first'] = true;

		$data['list_dusun'] = $this->penduduk_model->list_dusun();
		$data['wilayah'] = $this->penduduk_model->list_wil();
		$data['desa'] = $this->config_model->get_data();
		$data['penduduk'] = $this->penduduk_model->list_data_map();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun_all();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['list_lap'] = $this->referensi_model->list_lap();
		$data['list_lap_front'] = $this->referensi_model->list_lap_front();
		$data['lokasi'] = $this->plan_lokasi_model->list_lokasi();
		$data['garis'] = $this->plan_garis_model->list_garis();
		$data['area'] = $this->plan_area_model->list_area();

		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);
		$data['pengurus'] = $this->pamong_model->list_data();

		$data['persilArray'] = $this->data_persil_model->list_persil();
		$data['jenisLokasi'] = $this->plan_point_model->list_data_menu_gis();
		$this->load->model('user_model');
		$data['show_persil'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'data_persil', 'b') ? true : false;
		$data['show_penduduk'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'penduduk', 'b') ? true : false;
		$data['total_penduduk'] = $this->header_model->penduduk_total();

		$data['userdata'] = $this->header_model->get_data();
		$this->_get_common_data($data);
		$this->load->view('web/app/persil.php', $data);
	}

	public function sebaranPenduduk()
	{
		$data = $this->includes;

		$_SESSION['from_first'] = true;

		$data['list_dusun'] = $this->penduduk_model->list_dusun();
		$data['wilayah'] = $this->penduduk_model->list_wil();
		$data['desa'] = $this->config_model->get_data();
		$data['penduduk'] = $this->penduduk_model->list_data_map();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun_all();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['list_lap'] = $this->referensi_model->list_lap();
		$data['list_lap_front'] = $this->referensi_model->list_lap_front();
		$data['lokasi'] = $this->plan_lokasi_model->list_lokasi();
		$data['garis'] = $this->plan_garis_model->list_garis();
		$data['area'] = $this->plan_area_model->list_area();

		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);

		$data['jenisLokasi'] = $this->plan_point_model->list_data_menu_gis();
		$this->load->model('user_model');

		$data['userdata'] = $this->header_model->get_data();

		$this->_get_common_data($data);
		$this->load->view('web/app/sebaranpenduduk.php', $data);
	}

	private function _get_common_data(&$data)
	{
		$data['desa'] = $this->config_model->get_data();
		$data['menu_atas'] = $this->first_menu_m->list_menu_atas();
		$data['menu_atas'] = $this->first_menu_m->list_menu_atas();
		$data['menu_kiri'] = $this->first_menu_m->list_menu_kiri();
		$data['teks_berjalan'] = $this->teks_berjalan_model->list_data(TRUE);
		$data['slide_artikel'] = $this->first_artikel_m->slide_show();
		$data['slider_gambar'] = $this->first_artikel_m->slider_gambar();
		$data['w_cos'] = $this->web_widget_model->get_widget_aktif();
		$data['desaall'] = $this->config_model->get_data_all();
		$data['data_config'] = $this->config_model->get_desa($filterDesa);
		$data['data_prov'] = $this->config_model->get_provinsi_global();
		$data['getLeuitLokasi'] = $this->leuit_lokasi_model->list_data_mobile();

		$this->web_widget_model->get_widget_data($data);
		$data['data_config'] = $this->config_model->get_data();
		$data['flash_message'] = $this->session->flashdata('flash_message');
		if ($this->setting->apbdes_footer and $this->setting->apbdes_footer_all) {
			$data['transparansi'] = $this->setting->apbdes_manual_input
				? $this->keuangan_grafik_manual_model->grafik_keuangan_tema()
				: $this->keuangan_grafik_model->grafik_keuangan_tema();
		}
		// Pembersihan tidak dilakukan global, karena artikel yang dibuat oleh
		// petugas terpecaya diperbolehkan menampilkan <iframe> dsbnya..
		$list_kolom = array(
			'arsip',
			'w_cos'
		);
		foreach ($list_kolom as $kolom) {
			$data[$kolom] = $this->security->xss_clean($data[$kolom]);
		}
	}

	// sementara
	function loadLeuitDataDesa() {
		$desaid = '2';
		$data['listdesa'] = $this->config_model->get_data_all();
		$data["leuit_panen"] = $this->leuit_panen_model->list_data('', '', '', '', '', $desaid);
		$data["total_produksi"] = $this->leuit_panen_model->get_total_produksi('', '', '', '', '', $desaid);
		$data["panen_group"] = $this->leuit_panen_model->get_total_by_dusun('', '', '', '', '', '', $desaid);

		$data["leuit_distribusi"] = $this->leuit_distribusi_model->list_data('', $desaid);
		$data["total_distribusi"] = $this->leuit_distribusi_model->get_total_distribusi('', $desaid);
		$data["distribusi_group"] = $this->leuit_distribusi_model->get_total_distribusi_byjenis('','', $desaid);

		$this->load->view('web/app/listdata.php', $data);
	}

	public function inputData() {
		$filterDesa = 2;
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['desa'] = $this->config_model->get_desa($filterDesa);
		$data['wil_atas'] = $this->config_model->get_desa($filterDesa);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun_desa($filterDesa);
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		
		$data['list_sawah'] = $this->tutupan_lahan_model->get_tutupan_lahan_desa_jenis($filterDesa, 5);
		$data['produksi'] = null;
		$data['form_action'] = site_url("mobile_app/insert");
		$data['dusun'] = $this->wilayah_model->list_dusun_desa($filterDesa);
		$data['rw'] = $this->wilayah_model->list_rw_bydesa($data['lokasi']['dusun']);
		$data['rt'] = $this->wilayah_model->list_rt_bydesa($data['lokasi']['dusun'], $data['lokasi']['rw']);

		$this->load->view('web/app/inputdata.php', $data);
	}

	public function insert(){
		$this->leuit_panen_model->insertApp();
		redirect("mobile_app/loadLeuitDataDesa");
	}


	public function inputDataDistribusi() {
		$filterDesa = 2;
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['desa'] = $this->config_model->get_desa($filterDesa);
		$data['wil_atas'] = $this->config_model->get_desa($filterDesa);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun_desa($filterDesa);
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		
		$data['distribusi'] = null;
		$data['form_action'] = site_url("mobile_app/insertDistribusi");
		$data['dusun'] = $this->wilayah_model->list_dusun_desa($filterDesa);
		$data['rw'] = $this->wilayah_model->list_rw_bydesa($data['lokasi']['dusun']);
		$data['rt'] = $this->wilayah_model->list_rt_bydesa($data['lokasi']['dusun'], $data['lokasi']['rw']);

		$this->load->view('web/app/inputdata_distribusi.php', $data);
	}
	public function insertDistribusi(){
		$this->leuit_distribusi_model->insertApp();
		redirect("mobile_app/loadLeuitDataDesa");
	}
}
