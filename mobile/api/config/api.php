<?php
include '../../config.php';

$response = array();
header('Content-Type: application/json');

if (mysqli_connect_errno()) {
	$response["error"] = TRUE;
	$response["message"] = "Gagal konek ke database";
	echo json_encode($response);
	exit;
}

if (isset($_POST["type"]) && ($_POST["type"] == "config")) {
	$sql = 'SELECT * FROM config ORDER BY id ASC';
	$result = $mysqli->query($sql);
	$response_data = null;
	while ($data = $result->fetch_assoc()) {
		$sql_slider = 'SELECT s.*, s.nama AS kategori, t.id AS id, t.gambar AS gambar, t.nama AS nama, t.tgl_upload AS tgl_upload FROM gambar_gallery t 
			LEFT JOIN gambar_gallery s ON s.id = t.parrent 
			WHERE s.enabled = 1 
			AND s.slider = 1 
			AND t.enabled = 1 
			AND t.tipe = 2 
			ORDER BY t.urut ASC';
		$result_slider = $mysqli->query($sql_slider);

		$slider = null;
		while ($data_slider = $result_slider->fetch_assoc()) {
			$tmpSlider = array(
				'id' => $data_slider['id'],
				'kategori' => $data_slider['kategori'],
				'nama' => $data_slider['nama'],
				'gambar' => $data_slider['gambar'],
				'tgl_upload' => $data_slider['tgl_upload'],
			);
			$slider[] = $tmpSlider;
		}

		$tmp = array(
			'nama_desa' => $data['nama_desa'],
			'logo' => $data['logo'],
			'nama_kepala_desa' => $data['nama_kepala_desa'],
			'alamat_kantor' => $data['alamat_kantor'],
			'email_desa' => $data['email_desa'],
			'telepon' => $data['telepon'],
			'website' => $data['website'],
			'kode_pos' => $data['kode_pos'],
			'nama_kecamatan' => $data['nama_kecamatan'],
			'nama_kepala_camat' => $data['nama_kepala_camat'],
			'nama_kabupaten' => $data['nama_kabupaten'],
			'nama_propinsi' => $data['nama_propinsi'],
			'kantor_desa' => $data['kantor_desa'],
			'luas_desa' => $data['luas_desa'],
			'slider' => $slider,
			'lat' => json_decode($data['lat']),
			'lng' => json_decode($data['lng']),
			"path" => json_decode($data['path']),
		);
		$response_data = $tmp;
	}

	if (is_null($response_data)) {
		$status = FALSE;
		$error = TRUE;
		$message = 'data tidak ada';
	} else {
		$status = TRUE;
		$error = FALSE;
		$message = 'success';
	}

	header('Content-Type: application/json');
	$response = ['status' => $status, 'error' => $error, 'message' => $message, 'data' => $response_data];
	echo json_encode($response);
} else {
	$response["error"] = TRUE;
	$response["message"] = "Parameter salah!";
	echo json_encode($response);
	exit;
}
