<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('header_model');
		$this->load->model('laporan_bulanan_model');
		$this->load->model('penduduk_log_model');
		$this->load->model('pamong_model');
		$this->load->model('config_model');
		$this->controller = 'laporan';

		//Initialize Session ------------
		$_SESSION['success'] = 0;
		$_SESSION['cari'] = '';
		//-------------------------------

		$this->modul_ini = 3;
		$this->sub_modul_ini = 28;
	}

	public function clear()
	{
		$_SESSION['bulanku'] = date("n");
		$_SESSION['tahunku'] = date("Y");
		$_SESSION['per_page'] = 200;
		redirect('laporan');
	}

	public function index($lap = 0, $p = 1, $o = 0)
	{
		$data['p'] = $p;
		$data['o'] = $o;

		if (isset($_POST['per_page']))
			$_SESSION['per_page'] = $_POST['per_page'];
		$data['per_page'] = $_SESSION['per_page'];

		if (isset($_SESSION['bulanku']))
			$data['bulanku'] = $_SESSION['bulanku'];
		else
		{
			$data['bulanku'] = date("n");
			$_SESSION['bulanku'] = $data['bulanku'];
		}

		if (isset($_SESSION['tahunku']))
			$data['tahunku'] = $_SESSION['tahunku'];
		else
		{
			$data['tahunku'] = date("Y");
			$_SESSION['tahunku'] = $data['tahunku'];
		}

		$data['bulan'] = $data['bulanku'];
		$data['tahun'] = $data['tahunku'];
		$data['config'] = $this->config_model->get_data();
		$data['pamong'] = $this->pamong_model->list_data(true);
		$data['penduduk_awal'] = $this->laporan_bulanan_model->penduduk_awal();
		$data['penduduk_akhir'] = $this->laporan_bulanan_model->penduduk_akhir();
		$data['kelahiran'] = $this->laporan_bulanan_model->kelahiran();
		$data['kematian'] = $this->laporan_bulanan_model->kematian();
		$data['pendatang'] = $this->laporan_bulanan_model->pendatang();
		$data['pindah'] = $this->laporan_bulanan_model->pindah();
		$data['hilang'] = $this->laporan_bulanan_model->hilang();
		$data['lap'] = $lap;
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('laporan/bulanan', $data);
		$this->load->view('footer');
	}

	public function kk_per_dusun($lap = 0, $p = 1, $o = 0)
	{
		$data['p'] = $p;
		$data['o'] = $o;

		if (isset($_POST['per_page']))
			$_SESSION['per_page'] = $_POST['per_page'];
		$data['per_page'] = $_SESSION['per_page'];

		if (isset($_SESSION['bulanku']))
			$data['bulanku'] = $_SESSION['bulanku'];
		else
		{
			$data['bulanku'] = date("n");
			$_SESSION['bulanku'] = $data['bulanku'];
		}

		if (isset($_SESSION['tahunku']))
			$data['tahunku'] = $_SESSION['tahunku'];
		else
		{
			$data['tahunku'] = date("Y");
			$_SESSION['tahunku'] = $data['tahunku'];
		}
		$this->modul_ini = 28;
		$this->sub_modul_ini = 216;

		$data['bulan'] = $data['bulanku'];
		$data['tahun'] = $data['tahunku'];
		$data['config'] = $this->config_model->get_data();
		$data['pamong'] = $this->pamong_model->list_data();
		$data['kk_per_dusun'] = $this->laporan_bulanan_model->kk_per_dusun();
		$data['lap'] = $lap;
		$data['cus'] = "kk_per_dusun";
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('laporan/bulanan', $data);
		$this->load->view('footer');
	}

	public function penduduk_per_umur($lap = 0, $p = 1, $o = 0)
	{
		$data['p'] = $p;
		$data['o'] = $o;

		if (isset($_POST['per_page']))
			$_SESSION['per_page'] = $_POST['per_page'];
		$data['per_page'] = $_SESSION['per_page'];

		if (isset($_SESSION['bulanku']))
			$data['bulanku'] = $_SESSION['bulanku'];
		else
		{
			$data['bulanku'] = date("n");
			$_SESSION['bulanku'] = $data['bulanku'];
		}

		if (isset($_SESSION['tahunku']))
			$data['tahunku'] = $_SESSION['tahunku'];
		else
		{
			$data['tahunku'] = date("Y");
			$_SESSION['tahunku'] = $data['tahunku'];
		}

		$this->modul_ini = 28;
		$this->sub_modul_ini = 217;

		$data['bulan'] = $data['bulanku'];
		$data['tahun'] = $data['tahunku'];
		$data['config'] = $this->config_model->get_data();
		$data['pamong'] = $this->pamong_model->list_data();
		$data['pend_awal'] = $this->laporan_bulanan_model->penduduk_awal_per_umur();
		$data['pend_akhir'] = $this->laporan_bulanan_model->penduduk_akhir_per_umur();
		$data['lahir'] = $this->laporan_bulanan_model->kelahiran_per_umur();
		$data['mati'] = $this->laporan_bulanan_model->kematian_per_umur();
		$data['datang'] = $this->laporan_bulanan_model->datang_per_umur();
		$data['pergi'] = $this->laporan_bulanan_model->pindah_per_umur();
		$data['lap'] = $lap;
		$data['cus'] = "pend_per_umur";
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('laporan/bulanan', $data);
		$this->load->view('footer');
	}

	public function detail_mutasi($lap = 0, $p = 1, $o = 0)
	{
		$data['p'] = $p;
		$data['o'] = $o;

		if (isset($_POST['per_page']))
			$_SESSION['per_page'] = $_POST['per_page'];
		$data['per_page'] = $_SESSION['per_page'];

		if (isset($_SESSION['bulanku']))
			$data['bulanku'] = $_SESSION['bulanku'];
		else
		{
			$data['bulanku'] = date("n");
			$_SESSION['bulanku'] = $data['bulanku'];
		}

		if (isset($_SESSION['tahunku']))
			$data['tahunku'] = $_SESSION['tahunku'];
		else
		{
			$data['tahunku'] = date("Y");
			$_SESSION['tahunku'] = $data['tahunku'];
		}
		$this->modul_ini = 28;
		$this->sub_modul_ini = 218;

		$data['bulan'] = $data['bulanku'];
		$data['tahun'] = $data['tahunku'];
		$data['config'] = $this->config_model->get_data();
		$data['pamong'] = $this->pamong_model->list_data();
		$data['penduduk_awal'] = $this->laporan_bulanan_model->penduduk_awal_per_umur();
		$data['penduduk_akhir'] = $this->laporan_bulanan_model->penduduk_akhir_per_umur();
		$data['detail_mutasi'] = $this->penduduk_log_model->log_bulanan();
		$data['lahir'] = $this->laporan_bulanan_model->kelahiran_per_umur();
		$data['mati'] = $this->laporan_bulanan_model->kematian_per_umur();
		$data['datang'] = $this->laporan_bulanan_model->datang_per_umur();
		$data['pergi'] = $this->laporan_bulanan_model->pindah_per_umur();
		$data['lap'] = $lap;
		$data['cus'] = "detail_mutasi";
		$header = $this->header_model->get_data();

		$this->load->view('header', $header);
		$this->load->view('nav', $nav);
		$this->load->view('laporan/bulanan', $data);
		$this->load->view('footer');
	}

	public function dialog_cetak($cus="")
	{
		$data['aksi'] = "Cetak";
		$data['pamong'] = $this->pamong_model->list_data();
		$data['form_action'] = site_url("laporan/cetak/".$cus);
		$this->load->view('laporan/ajax_cetak', $data);
	}

	public function dialog_unduh($cus="")
	{
		$data['aksi'] = "Unduh";
		$data['pamong'] = $this->pamong_model->list_data();
		$data['form_action'] = site_url("laporan/unduh/".$cus);
		$this->load->view('laporan/ajax_cetak', $data);
	}

	public function cetak($cus="")
	{
		$data = $this->data_cetak();
		switch ($cus) {
			case "kk_per_dusun" :
				$data['kk_per_dusun'] = $this->laporan_bulanan_model->kk_per_dusun();
				$this->load->view('laporan/kk_per_dusun_print', $data);
			  break;
			case "pend_per_umur" :
				$data['pend_awal'] = $this->laporan_bulanan_model->penduduk_awal_per_umur();
				$data['pend_akhir'] = $this->laporan_bulanan_model->penduduk_akhir_per_umur();
				$data['lahir'] = $this->laporan_bulanan_model->kelahiran_per_umur();
				$data['mati'] = $this->laporan_bulanan_model->kematian_per_umur();
				$data['datang'] = $this->laporan_bulanan_model->datang_per_umur();
				$data['pergi'] = $this->laporan_bulanan_model->pindah_per_umur();
				$this->load->view('laporan/pend_per_umur_print', $data);
			  break;
			case "detail_mutasi" :
				$data['penduduk_awal'] = $this->laporan_bulanan_model->penduduk_awal_per_umur();
				$data['penduduk_akhir'] = $this->laporan_bulanan_model->penduduk_akhir_per_umur();
				$data['detail_mutasi'] = $this->penduduk_log_model->log_bulanan();
				$data['lahir'] = $this->laporan_bulanan_model->kelahiran_per_umur();
				$data['mati'] = $this->laporan_bulanan_model->kematian_per_umur();
				$data['datang'] = $this->laporan_bulanan_model->datang_per_umur();
				$data['pergi'] = $this->laporan_bulanan_model->pindah_per_umur();
				$this->load->view('laporan/detail_mutasi_print', $data);
			  break;
			default :
				$this->load->view('laporan/bulanan_print', $data);
		  }
	}

	public function unduh($cus="")
	{
		$data = $this->data_cetak();
		switch ($cus) {
			case "kk_per_dusun" :
				$data['kk_per_dusun'] = $this->laporan_bulanan_model->kk_per_dusun();
				$this->load->view('laporan/kk_per_dusun_excel', $data);
			  break;
			case "pend_per_umur" :
				$data['pend_awal'] = $this->laporan_bulanan_model->penduduk_awal_per_umur();
				$data['pend_akhir'] = $this->laporan_bulanan_model->penduduk_akhir_per_umur();
				$data['lahir'] = $this->laporan_bulanan_model->kelahiran_per_umur();
				$data['mati'] = $this->laporan_bulanan_model->kematian_per_umur();
				$data['datang'] = $this->laporan_bulanan_model->datang_per_umur();
				$data['pergi'] = $this->laporan_bulanan_model->pindah_per_umur();
				$this->load->view('laporan/pend_per_umur_excel', $data);
			  break;
			case "detail_mutasi" :
				$data['penduduk_awal'] = $this->laporan_bulanan_model->penduduk_awal_per_umur();
				$data['penduduk_akhir'] = $this->laporan_bulanan_model->penduduk_akhir_per_umur();
				$data['detail_mutasi'] = $this->penduduk_log_model->log_bulanan();
				$data['lahir'] = $this->laporan_bulanan_model->kelahiran_per_umur();
				$data['mati'] = $this->laporan_bulanan_model->kematian_per_umur();
				$data['datang'] = $this->laporan_bulanan_model->datang_per_umur();
				$data['pergi'] = $this->laporan_bulanan_model->pindah_per_umur();
				$this->load->view('laporan/detail_mutasi_excel', $data);
			  break;
			default :
				$this->load->view('laporan/bulanan_excel', $data);
		  }
	}

	private function data_cetak()
	{
		$data = array();
		$data['config'] = $this->config_model->get_data();
		$data['bulan'] = $_SESSION['bulanku'];
		$data['tahun'] = $_SESSION['tahunku'];
		$data['bln'] = $this->laporan_bulanan_model->bulan($data['bulan']);
		$data['penduduk_awal'] = $this->laporan_bulanan_model->penduduk_awal();
		$data['penduduk_akhir'] = $this->laporan_bulanan_model->penduduk_akhir();
		$data['kelahiran'] = $this->laporan_bulanan_model->kelahiran();
		$data['kematian'] = $this->laporan_bulanan_model->kematian();
		$data['pendatang'] = $this->laporan_bulanan_model->pendatang();
		$data['pindah'] = $this->laporan_bulanan_model->pindah();
		$data['rincian_pindah'] = $this->laporan_bulanan_model->rincian_pindah();
		$data['hilang'] = $this->laporan_bulanan_model->hilang();
		$data['pamong_ttd'] = $this->pamong_model->get_data($_POST['pamong_ttd']);
		$data['ttd'] = $this->pamong_model->get_ttd();
		return $data;
	}

	public function bulan($cus = "")
	{
		$bulanku = $this->input->post('bulan');
		if ($bulanku != "")
			$_SESSION['bulanku'] = $bulanku;
		else unset($_SESSION['bulanku']);

		$tahunku = $this->input->post('tahun');
		if ($tahunku != "")
			$_SESSION['tahunku'] = $tahunku;
		else unset($_SESSION['tahunku']);
		switch ($cus) {
			case "kk_per_dusun" :
				redirect('laporan/kk_per_dusun');
				break;
			case "pend_per_umur" :
				redirect('laporan/penduduk_per_umur');
				break;
			case "detail_mutasi" :
				redirect('laporan/detail_mutasi');
				break;
			default :
				redirect('laporan');
		}
		
	}
}