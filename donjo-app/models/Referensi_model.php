<?php

define("MASA_BERLAKU", serialize([
	"d" => "Hari",
	"w" => "Minggu",
	"M" => "Bulan",
	"y" => "Tahun"
]));

define("KATEGORI_PUBLIK", serialize([
	"Informasi Berkala" => "1",
	"Informasi Serta-merta" => "2",
	"Informasi Setiap Saat" => "3",
	"Informasi Dikecualikan" => "4"
]));

define("STATUS_PERMOHONAN", serialize(array(
	"Sedang diperiksa" => "0",
	"Belum lengkap" => "1",
	"Menunggu tandatangan" => "2",
	"Siap diambil" => "3",
	"Sudah diambil" => "4",
	"Dibatalkan" => "9"
)));

define("LINK_TIPE", serialize([
	'1' => 'Artikel Statis',
	'7' => 'Kategori Artikel',
	'2' => 'Statistik Penduduk',
	'3' => 'Statistik Keluarga',
	'4' => 'Statistik Program Bantuan',
	'5' => 'Halaman Statis Lainnya',
	'6' => 'Artikel Keuangan',
	'99' => 'Eksternal'
]));

// Statistik Penduduk
define("STAT_PENDUDUK", serialize([
	'13' => 'Umur (Rentang)',
	'15' => 'Umur (Kategori)',
	'0' => 'Pendidikan Dalam KK',
	'14' => 'Pendidikan Sedang Ditempuh',
	'1' => 'Pekerjaan',
	'2' => 'Status Perkawinan',
	'3' => 'Agama',
	'4' => 'Jenis Kelamin',
	'hubungan_kk' => 'Hubungan Dalam KK',
	'5' => 'Warga Negara',
	'6' => 'Status Penduduk',
	'7' => 'Golongan Darah',
	'9' => 'Penyandang Cacat',
	'10' => 'Penyakit Menahun',
	'16' => 'Akseptor KB',
	'17' => 'Akta Kelahiran',
	'18' => 'Kepemilikan KTP',
	'19' => 'Jenis Asuransi',
	'covid' => 'Status Covid'
]));

// Statistik Keluarga
define("STAT_KELUARGA", serialize([
	'kelas_sosial' => 'Kelas Sosial'
]));

// Statistik Bantuan
define("STAT_BANTUAN", serialize([
	'bantuan_penduduk' => 'Penerima Bantuan Penduduk',
	'bantuan_keluarga' => 'Penerima Bantuan Keluarga'
]));

// Statistik Lainnya
define("STAT_LAINNYA", serialize([
	'dpt' => 'Calon Pemilih',
	'wilayah' => 'Wilayah Administratif',
	'peraturan_desa' => 'Produk Hukum',
	'informasi_publik' => 'Informasi Publik',
	'peta' => 'Peta',
	'data_analisis' => 'Data Analisis'
]));

define("LIST_LAP", serialize(array(
	'15' => 'Umur',
	'0' => 'Pendidikan dalam KK',
	'14' => 'Pendidikan sedang Ditempuh',
	'1' => 'Pekerjaan',
	'2' => 'Status Perkawinan',
	'3' => 'Agama',
	'4' => 'Jenis Kelamin',
	'5' => 'Warga Negara',
	'6' => 'Status Penduduk',
	'7' => 'Golongan Darah',
	'9' => 'Penyandang Cacat',
	'10' => 'Sakit Menahun',
	'16' => 'Akseptor KB',
	'17' => 'Akte Kelahiran',
	'18' => 'Kepemilikan KTP',
	'19' => 'Jenis Asuransi',
	'bantuan_penduduk' => 'Penerima Bantuan Penduduk',
	'bantuan_keluarga' => 'Penerima Bantuan Keluarga',
	// 'covid' => 'Status Covid'
)));

define("LIST_LAP_FRONT", serialize(array(
	'15' => 'Umur',
	// '0' => 'Pendidikan dalam KK',
	// '14' => 'Pendidikan sedang Ditempuh',
	'1' => 'Pekerjaan',
	'2' => 'Status Perkawinan',
	'3' => 'Agama',
	'4' => 'Jenis Kelamin',
	// '5' => 'Warga Negara',
	// '6' => 'Status Penduduk',
	// '7' => 'Golongan Darah',
	// '9' => 'Penyandang Cacat',
	// '10' => 'Sakit Menahun',
	// '16' => 'Akseptor KB',
	// '17' => 'Akte Kelahiran',
	// '18' => 'Kepemilikan KTP',
	// '19' => 'Jenis Asuransi',
	// 'bantuan_penduduk' => 'Penerima Bantuan Penduduk',
	// 'bantuan_keluarga' => 'Penerima Bantuan Keluarga',
	// 'covid' => 'Status Covid'
)));


class Referensi_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function list_nama($tabel)
	{
		$data = $this->list_data($tabel);
		$list = [];
		foreach ($data as $key => $value) {
			$list[$value['id']] = $value['nama'];
		}
		return $list;
	}

	public function list_data($tabel, $kecuali = '', $termasuk = null)
	{
		if ($kecuali) $this->db->where("id NOT IN ($kecuali)");

		if ($termasuk) $this->db->where("id IN ($termasuk)");

		$data = $this->db->select('*')->order_by('id')->get($tabel)->result_array();
		return $data;
	}

	public function list_kode_array($s_array)
	{
		$list = array_flip(unserialize($s_array));
		return $list;
	}

	public function list_wajib_ktp()
	{
		$wajib_ktp = array_flip(unserialize(WAJIB_KTP));
		return $wajib_ktp;
	}

	public function list_ktp_el()
	{
		$ktp_el = array_flip(unserialize(KTP_EL));
		return $ktp_el;
	}

	public function list_status_rekam()
	{
		$status_rekam = array_flip(unserialize(STATUS_REKAM));
		return $status_rekam;
	}

	public function list_by_id($tabel, $id = 'id')
	{
		$data = $this->db->order_by($id)
			->get($tabel)
			->result_array();
		$data = array_combine(array_column($data, $id), $data);
		return $data;
	}

	public function list_ref($stat = STAT_PENDUDUK)
	{
		$list_ref = unserialize($stat);
		return $list_ref;
	}

	public function list_ref_flip($s_array)
	{
		$list = array_flip(unserialize($s_array));
		return $list;
	}

	public function list_lap()
	{
		$list_lap = unserialize(LIST_LAP);
		return $list_lap;
	}

	public function list_lap_front()
	{
		$list_lap_front = unserialize(LIST_LAP_FRONT);
		return $list_lap_front;
	}
}
