<?php

/**
 * File ini:
 *
 * Controller untuk Halaman Web
 *
 * /donjo-app/controllers/First.php
 *
 */

defined('BASEPATH') or exit('No direct script access allowed');

class First extends Web_Controller
{

	public function __construct()
	{
		parent::__construct();
		parent::clear_cluster_session();
		session_start();

		// Jika offline_mode dalam level yang menyembunyikan website,
		// tidak perlu menampilkan halaman website
		if ($this->setting->offline_mode == 2) {
			redirect('main');
		} elseif ($this->setting->offline_mode == 1) {
			// Hanya tampilkan website jika user mempunyai akses ke menu admin/web
			// Tampilkan 'maintenance mode' bagi pengunjung website
			$this->load->model('user_model');
			$grup	= $this->user_model->sesi_grup($_SESSION['sesi']);
			if (!$this->user_model->hak_akses($grup, 'web', 'b')) {
				redirect('main/maintenance_mode');
			}
		}

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
		$this->load->model('track_model');
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
		$this->load->model('leuit_lokasi_model');
		$this->load->model('leuit_panen_model');
		$this->load->model('tutupan_lahan_model');
		$this->load->model('tutupan_lahan_jenis_model');
		$this->load->model('plan_lokasi_model');
		$this->load->model('plan_area_model');
		$this->load->model('plan_garis_model');
		$this->load->model('plan_point_model');
		$this->load->model('wilayah_model');
		$this->load->model('user_model');

		$this->load->model('data_persil_model');
	}

	public function auth()
	{
		if ($_SESSION['mandiri_wait'] != 1) {
			$this->first_m->siteman();
		}
		if ($_SESSION['mandiri'] == 1) {
			redirect('mandiri_web/mandiri/1/1');
		} else {
			redirect('/');
		}
	}

	public function logout()
	{
		$this->first_m->logout();
		redirect('/');
	}

	public function ganti()
	{
		$this->first_m->ganti();
		redirect('/');
	}

	public function index($p = 1, $o = 0)
	{
		$data = $this->includes;

		$_SESSION['from_first'] = true;
		$filterDesa = $_SESSION['filterDesa'];
		
		$desaid = $_REQUEST['desaid'];

		$data['p'] = $p;
		$data['paging'] = $this->first_artikel_m->paging($p);
		$data['paging_page'] = 'index';
		$data['paging_range'] = 3;
		$data['start_paging'] = max($data['paging']->start_link, $p - $data['paging_range']);
		$data['end_paging'] = min($data['paging']->end_link, $p + $data['paging_range']);
		$data['pages'] = range($data['start_paging'], $data['end_paging']);
		$data['artikel'] = $this->first_artikel_m->artikel_show($data['paging']->offset, $data['paging']->per_page);

		$data['list_dusun'] = $this->penduduk_model->list_dusun();
		$data['wilayah'] = $this->penduduk_model->list_wil();
		// $data['desa'] = $this->config_model->get_data_all();
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
		$data['kec'] = ucwords($this->setting->sebutan_kecamatan_singkat);
		$data['kab'] = ucwords($this->setting->sebutan_kabupaten_singkat);
		$data['pengurus'] = $this->pamong_model->list_data();

		$data['persilArray'] = $this->data_persil_model->list_persil();
		$data['jenisLokasi'] = $this->plan_point_model->list_data_menu_gis();
		$this->load->model('user_model');
		$data['show_persil'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'data_persil', 'b') ? true : false;
		// $data['show_penduduk'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'penduduk', 'b') ? true : false;
		$data['total_penduduk'] = $this->header_model->penduduk_total();
		$data['tot_pend'] = $this->config_model->penduduk_total($desaid);
		$data['show_leuit_analisa'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'leuit_analisa', 'b') ? true : false;
		$data['show_leuit_distribusi'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'leuit_distribusi', 'b') ? true : false;
		$data['show_leuit_panen'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'leuit_panen', 'b') ? true : false;
		$data['show_leuit_sawah'] = $this->user_model->hak_akses($this->user_model->sesi_grup($_SESSION['sesi']), 'leuit_sawah', 'b') ? true : false;
		$data['getLeuitLokasi'] = $this->leuit_lokasi_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);

		$data['userdata'] = $this->header_model->get_data();

		$data['listprovinsi'] = $this->config_model->get_provinsi();
		$data['listkota'] = $this->config_model->get_kota(32);
		$data['desa'] = $this->config_model->get_desa($desaid);
		$data['listdesa'] = $this->config_model->get_data_all();
		$data['filterDesa'] = $desaid;

		$data['headline'] = $this->first_artikel_m->get_headline();
		$data['cari'] = htmlentities($this->input->get('cari'));
		if ($this->setting->covid_rss) {
			$data['feed'] = array(
				'items' => $this->first_artikel_m->get_feed(),
				'title' => 'BERITA COVID19.GO.ID',
				'url' => 'https://www.covid19.go.id'
			);
		}

		if ($this->setting->apbdes_footer) {
			$data['transparansi'] = $this->setting->apbdes_manual_input
				? $this->keuangan_grafik_manual_model->grafik_keuangan_tema()
				: $this->keuangan_grafik_model->grafik_keuangan_tema();
		}

		// $data['covid'] = $this->laporan_penduduk_model->list_data('covid');

		$cari = trim($this->input->get('cari'));
		if (!empty($cari)) {
			// Judul artikel bisa digunakan untuk serangan XSS
			$data["judul_kategori"] = htmlentities("Hasil pencarian : " . substr($cari, 0, 50));
		}

		$this->_get_common_data($data, $desaid);
		$this->track_model->track_desa('first');
		$this->load->view($this->template, $data);
	}

	function loadModalProfil($desaid) {
		$data['desa'] = $this->config_model->get_desa($desaid);
		$this->load->view('gis/profil_desa', $data);
	}

	function loadModalLeuit($desaid) {
		$data['desa'] = $this->config_model->get_desa($desaid);
		$data['dusun'] = $this->wilayah_model->list_dusun_desa($desaid);
		$data['list_sawah'] = $this->tutupan_lahan_model->get_tutupan_lahan_jenis(5);
		$data['leuitLokasi'] = $this->leuit_lokasi_model->list_data_desaid($desaid);
		$this->load->view('gis/leuit_desa', $data);
	}

	function loadModalLeuit360($desaid) {
		$data['desa'] = $this->config_model->get_desa($desaid);
		$data['list_sawah'] = $this->tutupan_lahan_model->get_tutupan_lahan_jenis(5);
		$data['leuitLokasi'] = $this->leuit_lokasi_model->list_data_desaid($desaid);
		$this->load->view('gis/leuit_desa_360', $data);
	}

	function loadModalLeuitStat($desaid) {
		if (isset($_REQUEST['year'])) {
			$data['filteryear'] = $_REQUEST['year'];
		} else {
			$data['filteryear'] = '';
		}
		if (isset($_REQUEST['dusun'])) {
			$data['filterdusun'] = $_REQUEST['dusun'];
		} else {
			$data['filterdusun'] = '';
		}
		if (isset($_REQUEST['sawah'])) {
			$data['filtersawah'] = $_REQUEST['sawah'];
		} else {
			$data['filtersawah'] = '';
		}
		if (isset($_REQUEST['ts'])) {
			$data['tampilsawah'] = $_REQUEST['ts'];
		} else {
			$data['tampilsawah'] = '';
		}
		$data['leuitLokasi'] = $this->leuit_lokasi_model->list_data_desaid($desaid);
		$data["leuit_panen"] = $this->leuit_panen_model->list_data('', '', $data['filteryear'], $data['filtersawah'], $data['filterdusun'], $desaid);
		$data["total_produksi"] = $this->leuit_panen_model->get_total_produksi($data['filteryear'], $data['filtersawah'], $data['filterdusun'], $desaid);
		$data["panen_group"] = $this->leuit_panen_model->get_total_by_dusun('', '', $data['filteryear'], $data['filtersawah'], $data['filterdusun'], $data['tampilsawah'], $desaid);
		$this->load->view('gis/leuit_stat', $data);
	}

	function loadLeuitAllData() {
		$data = $this->includes;
		if (isset($_REQUEST['desa'])) {
			$desaid = $_REQUEST['desa'];
		} else {
			$desaid = '';
		}
		$data['listdesa'] = $this->config_model->get_data_all();
		$data["leuit_panen"] = $this->leuit_panen_model->list_data('', '', '', '', '', $desaid);
		$data["total_produksi"] = $this->leuit_panen_model->get_total_produksi('', '', '', '', '', $desaid);
		$data["panen_group"] = $this->leuit_panen_model->get_total_by_dusun('', '', '', '', '', '', $desaid);
		$this->load->view('gis/leuit_stat_all', $data);
	}

	function loadLeuitDataStok() {
		$data = $this->includes;
		if (isset($_REQUEST['desa'])) {
			$desaid = $_REQUEST['desa'];
		} else {
			$desaid = '';
		}
		$data['listdesa'] = $this->config_model->get_data_all();
		$data["leuit_panen"] = $this->leuit_panen_model->list_data('', '', '', '', '', $desaid);
		$data["total_produksi"] = $this->leuit_panen_model->get_total_produksi('', '', '', '', '', $desaid);
		$data["panen_group"] = $this->leuit_panen_model->get_total_by_dusun('', '', '', '', '', '', $desaid);
		$this->load->view('gis/leuit_data_stok', $data);
	}

	function getProvinsi() {
		switch ($_GET['jenis']) {
			//ambil data kota / kabupaten
			case 'kota':
			$id_provinces = $_POST['id_provinces'];
			if($id_provinces == '') {
				exit;
			} else {
				$listData = $this->config_model->get_kota($id_provinces);
				foreach ($listData as $data) {
					echo '<option value="'.$data['id'].'" data-name="'.$data['name'].'">'.$data['name'].'</option>';
				}
				exit;    
			}
			break;
		  
			//ambil data kecamatan
			case 'kecamatan':
			$id_regencies = $_POST['id_regencies'];
			if($id_regencies == '') {
				exit;
			} else {
				$listData = $this->config_model->get_kec($id_regencies);
				foreach ($listData as $data) {
					echo '<option value="'.$data['id'].'" data-name="'.$data['name'].'">'.$data['name'].'</option>';
				}
				exit;    
			}
			break;
			
			//ambil data kelurahan
			case 'kelurahan':
			$id_district = $_POST['id_district'];
			if($id_district == '') {
				exit;
			} else {
				$listData = $this->config_model->get_keldesa($id_district);
				foreach ($listData as $data) {
					echo '<option value="'.$data['id'].'" data-name="'.$data['name'].'">'.$data['name'].'</option>';
				}
				exit;    
			}
			break;
		}
	}

	public function cetak_biodata($id = '')
	{
		if ($_SESSION['mandiri'] != 1) {
			redirect('first');
			return;
		}
		// Hanya boleh mencetak data pengguna yang login
		$id = $_SESSION['id'];

		$data['desa'] = $this->config_model->get_data();
		$data['penduduk'] = $this->penduduk_model->get_penduduk($id);
		$this->load->view('sid/kependudukan/cetak_biodata', $data);
	}

	public function cetak_kk($id = '')
	{
		if ($_SESSION['mandiri'] != 1) {
			redirect('first');
			return;
		}
		// Hanya boleh mencetak data pengguna yang login
		$id = $_SESSION['id'];

		// $id adalah id penduduk. Cari id_kk dulu
		$id_kk = $this->penduduk_model->get_id_kk($id);
		$data = $this->keluarga_model->get_data_cetak_kk($id_kk);

		$this->load->view("sid/kependudukan/cetak_kk_all", $data);
	}

	public function kartu_peserta($id = 0)
	{
		if ($_SESSION['mandiri'] != 1) {
			redirect('first');
			return;
		}
		$this->load->model('program_bantuan_model');
		$data = $this->program_bantuan_model->get_program_peserta_by_id($id);
		// Hanya boleh menampilkan data pengguna yang login
		// ** Bagi program sasaran pendududk **
		if ($data['peserta'] == $_SESSION['nik']) {
			$this->load->view('program_bantuan/kartu_peserta', $data);
		}
	}

	public function mandiri($p = 1, $m = 0, $kat = 1)
	{
		// if ($_SESSION['mandiri'] != 1) {
		// 	redirect('first');
		// }

		$data = $this->includes;
		$data['p'] = $p;
		$data['menu_surat_mandiri'] = $this->surat_model->list_surat_mandiri();
		$data['m'] = $m;
		$data['kat'] = $kat;

		$this->_get_common_data($data);

		/* nilai $m
			1 untuk menu profilku
			2 untuk menu layanan
			3 untuk menu lapor
			4 untuk menu bantuan
			5 untuk menu surat mandiri
		*/
		switch ($m) {
			case 1:
				$data['list_kelompok'] = $this->penduduk_model->list_kelompok($_SESSION['id']);
				$data['list_dokumen'] = $this->penduduk_model->list_dokumen($_SESSION['id']);
				break;
			case 21:
				$data['tab'] = 2;
				$data['m'] = 2;
			case 2:
				$this->load->model('permohonan_surat_model');
				$data['surat_keluar'] = $this->keluar_model->list_data_perorangan($_SESSION['id']);
				$data['permohonan'] = $this->permohonan_surat_model->list_permohonan_perorangan($_SESSION['id']);
				break;
			case 3:
				$inbox = $this->mailbox_model->get_inbox_user($_SESSION['nik']);
				$outbox = $this->mailbox_model->get_outbox_user($_SESSION['nik']);
				$data['main_list'] = $kat == 1 ? $inbox : $outbox;
				$data['submenu'] = $this->mailbox_model->list_menu();
				$_SESSION['mailbox'] = $kat;
				break;
			case 4:
				$this->load->model('program_bantuan_model', 'pb');
				$data['daftar_bantuan'] = $this->pb->daftar_bantuan_yang_diterima($_SESSION['nik']);
				break;
			case 5:
				$data['list_dokumen'] = $this->penduduk_model->list_dokumen($_SESSION['id']);
				break;
			default:
				break;
		}
		$data['penduduk'] = $this->penduduk_model->get_penduduk($_SESSION['id']);
		$this->load->view('web/mandiri/layout.mandiri.php', $data);
	}

	public function mandiri_surat($id_permohonan = '')
	{
		if ($_SESSION['mandiri'] != 1) {
			redirect('first');
		}

		$this->load->model('permohonan_surat_model');
		$data = $this->includes;
		$data['menu_surat_mandiri'] = $this->surat_model->list_surat_mandiri();
		$data['menu_dokumen_mandiri'] = $this->lapor_model->get_surat_ref_all();
		$data['m'] = 5;
		$data['permohonan'] = $this->permohonan_surat_model->get_permohonan($id_permohonan);
		$this->_get_common_data($data);
		$data['list_dokumen'] = $this->penduduk_model->list_dokumen($_SESSION['id']);
		$data['penduduk'] = $this->penduduk_model->get_penduduk($_SESSION['id']);

		// Ambil data anggota KK
		if ($data['penduduk']['kk_level'] === '1') //Jika Kepala Keluarga
		{
			$data['kk'] = $this->keluarga_model->list_anggota($data['penduduk']['id_kk']);
		}

		$this->load->view('web/mandiri/layout.mandiri.php', $data);
	}

	public function cek_syarat()
	{
		$id_permohonan = $this->input->post('id_permohonan');
		$permohonan = $this->db->where('id', $id_permohonan)
			->get('permohonan_surat')
			->row_array();
		$syarat_permohonan = json_decode($permohonan['syarat'], true);
		$dokumen = $this->penduduk_model->list_dokumen($_SESSION['id']);
		$id = $this->input->post('id_surat');
		$syarat_surat = $this->surat_master_model->get_syarat_surat($id);
		$data = array();
		$no = $_POST['start'];

		foreach ($syarat_surat as $no_syarat => $baris) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $baris['ref_syarat_nama'];
			// Gunakan view sebagai string untuk mempermudah pembuatan pilihan
			$pilihan_dokumen = $this->load->view('web/mandiri/pilihan_syarat.php', array('dokumen' => $dokumen, 'syarat_permohonan' => $syarat_permohonan, 'syarat_id' => $baris['ref_syarat_id']), TRUE);
			$row[] = $pilihan_dokumen;
			$data[] = $row;
		}

		$output = array(
			"recordsTotal" => 10,
			"recordsFiltered" => 10,
			'data' => $data
		);
		echo json_encode($output);
	}

	/*
	| Artikel bisa ditampilkan menggunakan parameter pertama sebagai id, dan semua parameter lainnya dikosongkan. url artikel/:id
	| Kalau menggunakan slug, dipanggil menggunakan url artikel/:thn/:bln/:hri/:slug
	*/
	public function artikel($url)
	{
		$this->load->model('shortcode_model');
		$data = $this->includes;

		$data['single_artikel'] = $this->first_artikel_m->get_artikel($url);
		$id = $data['single_artikel']['id'];

		// replace isi artikel dengan shortcodify
		$data['single_artikel']['isi'] = $this->shortcode_model->shortcode($data['single_artikel']['isi']);
		$data['detail_agenda'] = $this->first_artikel_m->get_agenda($id); //Agenda
		$data['komentar'] = $this->first_artikel_m->list_komentar($id);
		$this->_get_common_data($data);

		// Validasi pengisian komentar di add_comment()
		// Kalau tidak ada error atau artikel pertama kali ditampilkan, kosongkan data sebelumnya
		if (empty($_SESSION['validation_error'])) {
			$_SESSION['post']['owner'] = '';
			$_SESSION['post']['email'] = '';
			$_SESSION['post']['no_hp'] = '';
			$_SESSION['post']['komentar'] = '';
			$_SESSION['post']['captcha_code'] = '';
		}
		$this->set_template('layouts/artikel.tpl.php');
		$this->load->view($this->template, $data);
	}

	public function arsip($p = 1)
	{
		$data = $this->includes;
		$data['p'] = $p;
		$data['paging']  = $this->first_artikel_m->paging_arsip($p);
		$data['farsip'] = $this->first_artikel_m->full_arsip($data['paging']->offset, $data['paging']->per_page);

		$this->_get_common_data($data);

		$this->set_template('layouts/arsip.tpl.php');
		$this->load->view($this->template, $data);
	}

	// Halaman arsip album galeri
	public function gallery($p = 1)
	{
		$data = $this->includes;
		$data['p'] = $p;
		$data['paging'] = $this->first_gallery_m->paging($p);
		$data['paging_range'] = 3;
		$data['start_paging'] = max($data['paging']->start_link, $p - $data['paging_range']);
		$data['end_paging'] = min($data['paging']->end_link, $p + $data['paging_range']);
		$data['pages'] = range($data['start_paging'], $data['end_paging']);
		$data['gallery'] = $this->first_gallery_m->gallery_show($data['paging']->offset, $data['paging']->per_page);

		$this->_get_common_data($data);

		$this->set_template('layouts/gallery.tpl.php');
		$this->load->view($this->template, $data);
	}

	// halaman rincian tiap album galeri
	public function sub_gallery($gal = 0, $p = 1)
	{
		$data = $this->includes;
		$data['p'] = $p;
		$data['gal'] = $gal;
		$data['paging'] = $this->first_gallery_m->paging2($gal, $p);
		$data['paging_range'] = 3;
		$data['start_paging'] = max($data['paging']->start_link, $p - $data['paging_range']);
		$data['end_paging'] = min($data['paging']->end_link, $p + $data['paging_range']);
		$data['pages'] = range($data['start_paging'], $data['end_paging']);

		$data['gallery'] = $this->first_gallery_m->sub_gallery_show($gal, $data['paging']->offset, $data['paging']->per_page);
		$data['parrent'] = $this->first_gallery_m->get_parrent($gal);
		$data['mode'] = 1;

		$this->_get_common_data($data);

		$this->set_template('layouts/sub_gallery.tpl.php');
		$this->load->view($this->template, $data);
	}

	public function statistik($stat = 0, $tipe = 0)
	{
		if (!$this->web_menu_model->menu_aktif('statistik/' . $stat)) show_404();

		$data = $this->includes;

		$data['heading'] = $this->laporan_penduduk_model->judul_statistik($stat);
		$data['jenis_laporan'] = $this->laporan_penduduk_model->jenis_laporan($stat);
		$data['stat'] = $this->laporan_penduduk_model->list_data($stat);
		$data['tipe'] = $tipe;
		$data['st'] = $stat;

		$this->_get_common_data($data);

		$this->set_template('layouts/stat.tpl.php');
		$this->load->view($this->template, $data);
	}

	public function ajax_peserta_program_bantuan()
	{
		$peserta = $this->program_bantuan_model->get_peserta_bantuan();
		$data = array();
		$no = $_POST['start'];

		foreach ($peserta as $baris) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $baris['program'];
			$row[] = $baris['peserta'];
			$row[] = $baris['alamat'];
			$data[] = $row;
		}

		$output = array(
			"recordsTotal" => $this->program_bantuan_model->count_peserta_bantuan_all(),
			"recordsFiltered" => $this->program_bantuan_model->count_peserta_bantuan_filtered(),
			'data' => $data
		);
		echo json_encode($output);
	}

	public function data_analisis($stat = "", $sb = 0, $per = 0)
	{
		$data = $this->includes;

		if ($stat == "") {
			$data['list_indikator'] = $this->first_penduduk_m->list_indikator();
			$data['list_jawab'] = null;
			$data['indikator'] = null;
		} else {
			$data['list_indikator'] = "";
			$data['list_jawab'] = $this->first_penduduk_m->list_jawab($stat, $sb, $per);
			$data['indikator'] = $this->first_penduduk_m->get_indikator($stat);
		}

		$this->_get_common_data($data);

		$this->set_template('layouts/analisis.tpl.php');
		$this->load->view($this->template, $data);
	}

	public function dpt()
	{
		if (!$this->web_menu_model->menu_aktif('dpt')) show_404();

		$this->load->model('dpt_model');
		$data = $this->includes;
		$data['main'] = $this->dpt_model->statistik_wilayah();
		$data['total'] = $this->dpt_model->statistik_total();
		$data['tanggal_pemilihan'] = $this->dpt_model->tanggal_pemilihan();
		$this->_get_common_data($data);
		$data['tipe'] = 4;
		$this->set_template('layouts/stat.tpl.php');
		$this->load->view($this->template, $data);
	}

	public function wilayah()
	{
		if (!$this->web_menu_model->menu_aktif('wilayah')) show_404();

		$this->load->model('wilayah_model');
		$data = $this->includes;

		$data['main']    = $this->first_penduduk_m->wilayah();
		$data['heading'] = "Populasi Per Wilayah";
		$data['tipe'] = 3;
		$data['total'] = $this->wilayah_model->total();
		$data['st'] = 1;
		$this->_get_common_data($data);

		$this->set_template('layouts/stat.tpl.php');
		$this->load->view($this->template, $data);
	}

	public function peraturan_desa()
	{
		if (!$this->web_menu_model->menu_aktif('peraturan_desa')) show_404();

		$this->load->model('web_dokumen_model');
		$data = $this->includes;

		$data['cek'] = $cek;
		$data['kategori'] = $this->referensi_model->list_data('ref_dokumen', 1);
		$data['tahun'] = $this->web_dokumen_model->tahun_dokumen();
		$data['heading'] = "Produk Hukum";
		// $data['halaman_statis'] = 'web/halaman_statis/peraturan_desa';
		$this->_get_common_data($data);

		// $this->set_template('layouts/halaman_statis.tpl.php');
		// $this->load->view($this->template, $data);
		$this->load->view('web/halaman_statis/peraturan_desa', $data);
	}

	public function ajax_table_peraturan()
	{
		$kategori_dokumen = '';
		$tahun_dokumen = '';
		$tentang_dokumen = '';
		$data = $this->web_dokumen_model->all_peraturan($kategori_dokumen, $tahun_dokumen, $tentang_dokumen);
		echo json_encode($data);
	}

	// function filter peraturan
	public function filter_peraturan()
	{
		$kategori_dokumen = $this->input->post('kategori');
		$tahun_dokumen = $this->input->post('tahun');
		$tentang_dokumen = $this->input->post('tentang');

		$data = $this->web_dokumen_model->all_peraturan($kategori_dokumen, $tahun_dokumen, $tentang_dokumen);
		echo json_encode($data);
	}

	public function informasi_publik()
	{
		if (!$this->web_menu_model->menu_aktif('informasi_publik')) show_404();

		$this->load->model('web_dokumen_model');
		$data = $this->includes;

		$data['kategori'] = $this->referensi_model->list_data('ref_dokumen', 1);
		$data['tahun'] = $this->web_dokumen_model->tahun_dokumen();
		$data['heading'] = "Informasi Publik";
		$data['halaman_statis'] = 'web/halaman_statis/informasi_publik';
		$this->_get_common_data($data);

		$this->set_template('layouts/halaman_statis.tpl.php');
		$this->load->view($this->template, $data);
	}

	public function ajax_informasi_publik()
	{
		$informasi_publik = $this->web_dokumen_model->get_informasi_publik();
		$data = array();
		$no = $_POST['start'];

		foreach ($informasi_publik as $baris) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='" . site_url('dokumen_web/unduh_berkas/') . $baris['id'] . "' target='_blank'>" . $baris['nama'] . "</a>";
			$row[] = $baris['tahun'];
			// Ambil judul kategori
			$row[] = $this->referensi_model->list_kode_array(KATEGORI_PUBLIK)[$baris['kategori_info_publik']];
			$row[] = $baris['tgl_upload'];
			$data[] = $row;
		}

		$output = array(
			"recordsTotal" => $this->web_dokumen_model->count_informasi_publik_all(),
			"recordsFiltered" => $this->web_dokumen_model->count_informasi_publik_filtered(),
			'data' => $data
		);
		echo json_encode($output);
	}

	public function kategori($id, $p = 1)
	{
		$data = $this->includes;

		$data['p'] = $p;
		$data["judul_kategori"] = $this->first_artikel_m->get_kategori($id);
		$data['paging']  = $this->first_artikel_m->paging_kat($p, $id);
		$data['paging_page']  = 'kategori/' . $id;
		$data['paging_range'] = 3;
		$data['start_paging'] = max($data['paging']->start_link, $p - $data['paging_range']);
		$data['end_paging'] = min($data['paging']->end_link, $p + $data['paging_range']);
		$data['pages'] = range($data['start_paging'], $data['end_paging']);
		$data['artikel'] = $this->first_artikel_m->list_artikel($data['paging']->offset, $data['paging']->per_page, $id);

		$this->_get_common_data($data);
		$this->load->view($this->template, $data);
	}

	public function add_comment($id = 0, $slug = NULL)
	{
		$sql = "SELECT *, YEAR(tgl_upload) AS thn, MONTH(tgl_upload) AS bln, DAY(tgl_upload) AS hri, slug AS slug  FROM artikel a WHERE id=$id ";
		$query = $this->db->query($sql, 1);
		$data = $query->row_array();
		// Periksa isian captcha
		include FCPATH . 'securimage/securimage.php';
		$securimage = new Securimage();
		$_SESSION['validation_error'] = false;

		if ($securimage->check($_POST['captcha_code']) == false) {
			$this->session->set_flashdata('flash_message', 'Kode anda salah. Silakan ulangi lagi.');
			$_SESSION['post'] = $_POST;
			$_SESSION['validation_error'] = true;
			redirect($_SERVER['HTTP_REFERER'] . "#kolom-komentar");
		}

		$res = $this->first_artikel_m->insert_comment($id);
		$data['data_config'] = $this->config_model->get_data();

		// cek kalau berhasil disimpan dalam database
		if ($res) {
			$this->session->set_flashdata('flash_message', 'Komentar anda telah berhasil dikirim dan perlu dimoderasi untuk ditampilkan.');
		} else {
			$_SESSION['post'] = $_POST;
			if (!empty($_SESSION['validation_error']))
				$this->session->set_flashdata('flash_message', validation_errors());
			else
				$this->session->set_flashdata('flash_message', 'Komentar anda gagal dikirim. Silakan ulangi lagi.');
		}

		$_SESSION['sukses'] = 1;
		redirect("first/artikel/" . $data['thn'] . "/" . $data['bln'] . "/" . $data['hri'] . "/" . $data['slug'] . "#kolom-komentar");
	}

	private function _get_common_data(&$data, $desaid)
	{
		$filterDesa = $_SESSION['filterDesa'];
		$data['desa'] = $this->config_model->get_desa($desaid);
		$data['desaall'] = $this->config_model->get_data_all();
		$data['menu_atas'] = $this->first_menu_m->list_menu_atas();
		$data['menu_atas'] = $this->first_menu_m->list_menu_atas();
		$data['menu_kiri'] = $this->first_menu_m->list_menu_kiri();
		$data['teks_berjalan'] = $this->teks_berjalan_model->list_data(TRUE);
		$data['slide_artikel'] = $this->first_artikel_m->slide_show();
		$data['slider_gambar'] = $this->first_artikel_m->slider_gambar();
		$data['w_cos'] = $this->web_widget_model->get_widget_aktif();

		$this->web_widget_model->get_widget_data($data);
		$data['data_config'] = $this->config_model->get_desa($filterDesa);
		$data['data_prov'] = $this->config_model->get_provinsi_global();

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

	public function peta()
	{
		if (!$this->web_menu_model->menu_aktif('peta')) show_404();

		$this->load->model('wilayah_model');
		$data = $this->includes;

		$data['list_dusun'] = $this->penduduk_model->list_dusun();
		$data['wilayah'] = $this->penduduk_model->list_wil();
		$data['desa'] = $this->config_model->get_data();
		$data['penduduk'] = $this->penduduk_model->list_data_map();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['list_lap'] = $this->referensi_model->list_lap();
		$data['list_lap_front'] = $this->referensi_model->list_lap_front();
		$data['covid'] = $this->laporan_penduduk_model->list_data('covid');
		$data['lokasi'] = $this->plan_lokasi_model->list_lokasi();
		$data['garis'] = $this->plan_garis_model->list_garis();
		$data['area'] = $this->plan_area_model->list_area();

		$data['halaman_peta'] = 'web/halaman_statis/peta';
		$this->_get_common_data($data);

		$this->set_template('layouts/peta_statis.tpl.php');
		$this->load->view($this->template, $data);
	}

	public function load_apbdes()
	{
		$data['transparansi'] = $this->keuangan_grafik_model->grafik_keuangan_tema();

		$this->_get_common_data($data);
		$this->load->view('gis/apbdes_web', $data);
	}

	public function load_aparatur_desa()
	{
		$this->_get_common_data($data);
		$this->load->view('gis/aparatur_desa_web', $data);
	}

	public function load_aparatur_wilayah($id = '', $kd_jabatan = 0)
	{
		$data['penduduk'] = $this->penduduk_model->get_penduduk($id);

		switch ($kd_jabatan) {
			case '1':
				$data['jabatan'] = "Kepala Dusun";
				break;
			case '2':
				$data['jabatan'] = "Ketua RW";
				break;
			case '3':
				$data['jabatan'] = "Ketua RT";
				break;
			default:
				$data['jabatan'] = "Data belum diinput";
				break;
		}

		$this->load->view('gis/aparatur_wilayah', $data);
	}

	public function ajax_table_surat_permohonan()
	{
		$data = $this->penduduk_model->list_dokumen($_SESSION['id']);
		for ($i = 0; $i < count($data); $i++) {
			$berkas = $data[$i]['satuan'];
			$list_dokumen[$i][] = $data[$i]['no'];
			$list_dokumen[$i][] = $data[$i]['id'];
			$list_dokumen[$i][] = "<a href='" . site_url("mandiri_web/unduh_berkas/" . $data[$i][id]) . "/{$data[$i][id_pend]}" . "'>" . $data[$i]["nama"] . '</a>';
			$list_dokumen[$i][] = tgl_indo2($data[$i]['tgl_upload']);
			$list_dokumen[$i][] = $data[$i]['nama'];
			$list_dokumen[$i][] = $data[$i]['dok_warga'];
		}
		$list['data'] = count($list_dokumen) > 0 ? $list_dokumen : array();
		echo json_encode($list);
	}

	public function ajax_upload_dokumen_pendukung()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama Dokumen', 'required');

		if ($this->form_validation->run() !== true) {
			$data['success'] = -1;
			$data['message'] = validation_errors();
			echo json_encode($data);
			return;
		}

		$this->session->unset_userdata('success');
		$this->session->unset_userdata('error_msg');
		$success_msg = 'Berhasil menyimpan data';

		if ($_SESSION['id']) {
			$_POST['id_pend'] = $this->session->id;
			$id_dokumen = $this->input->post('id');
			unset($_POST['id']);

			if ($id_dokumen) {
				$hasil = $this->web_dokumen_model->update($id_dokumen, $this->session->id, $mandiri = true);
				if (!$hasil) {
					$data['success'] = -1;
					$data['message'] = 'Gagal update';
				}
			} else {
				$_POST['dok_warga'] = 1; // Boleh diubah di layanan mandiri
				$this->web_dokumen_model->insert($mandiri = true);
			}
			$data['success'] = $this->session->success;
			$data['message'] = $data['success'] == -1 ? $this->session->error_msg : $success_msg;
		} else {
			$data['success'] = -1;
			$data['message'] = 'Anda tidak mempunyai hak akses itu';
		}

		echo json_encode($data);
	}

	public function ajax_get_dokumen_pendukung()
	{
		$id_dokumen = $this->input->post('id_dokumen');
		$data = $this->web_dokumen_model->get_dokumen($id_dokumen, $this->session->id);

		$data['anggota'] = $this->web_dokumen_model->get_dokumen_di_anggota_lain($id_dokumen);

		if (empty($data)) {
			$data['success'] = -1;
			$data['message'] = 'Tidak ditemukan';
		} elseif ($this->session->id != $data['id_pend']) {
			$data = ['message' => 'Anda tidak mempunyai hak akses itu'];
		}
		echo json_encode($data);
	}

	public function ajax_hapus_dokumen_pendukung()
	{
		$id_dokumen = $this->input->post('id_dokumen');
		$data = $this->web_dokumen_model->get_dokumen($id_dokumen);
		if (empty($data)) {
			$data['success'] = -1;
			$data['message'] = 'Tidak ditemukan';
		} elseif ($_SESSION['id'] != $data['id_pend']) {
			$data['success'] = -1;
			$data['message'] = 'Anda tidak mempunyai hak akses itu';
		} else {
			$this->web_dokumen_model->delete($id_dokumen);
			$data['success'] = $this->session->userdata('success') ?: '1';
		}
		echo json_encode($data);
	}

	public function ambil_data_covid()
	{
		if ($content = getUrlContent($this->input->post('endpoint'))) {
			echo $content;
		}
	}
	
	public function filterDesa()
	{
		$filter = $this->input->post('filterDesa');
		if ($filter != 0)
			$_SESSION['filterDesa'] = $filter;
		else unset($_SESSION['filterDesa']);
		redirect('/');
	}
	
	public function filterIdDesa()
	{
		$filter = $this->input->post('filterIdDesa');
		if ($filter!= 0)
			$_SESSION['filterIdDesa'] = $filter;
		else unset($_SESSION['filterIdDesa']);
		// redirect('/');
	}
}
