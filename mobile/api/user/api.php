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

if (isset($_POST["type"]) && ($_POST["type"] == "userall")) {
	$sql_get_user = 'SELECT * FROM user ORDER BY id ASC';
	$resultUsers = $mysqli->query($sql_get_user);

	$response_data = null;
	while ($data = $resultUsers->fetch_assoc()) {
		$response_data[] = $data;
	}

	if (is_null($response_data)) {
		$status = false;
	} else {
		$status = true;
	}

	header('Content-Type: application/json');
	$response = ['status' => $status, 'data' => $response_data];
	echo json_encode($response);
} else if (isset($_POST["type"]) && ($_POST["type"] == "login") && isset($_POST["email"]) && isset($_POST["password"])) {

	$email = $_POST["email"];

	$userPass = "SELECT password FROM user WHERE email = '$email'";
	$resultPass = $mysqli->query($userPass);
	$userPass = mysqli_fetch_assoc($resultPass);
	$password = password_verify($_POST["password"], $userPass['password']);

	if ($password) {
		$userQuery = "SELECT id, nama, email, id_grup, company, phone, foto FROM user WHERE email = '$email'";
		$result = $mysqli->query($userQuery);

		if ($result->num_rows == 0) {
			$response["error"] = TRUE;
			$response["message"] = "Pengguna tidak ditemukan atau detil akun salah";
			echo json_encode($response);
			exit;
		} else {
			$user = mysqli_fetch_assoc($result);
			$response["error"] = FALSE;
			$response["message"] = "Login berhasil";
			$response["user"] = $user;
			echo json_encode($response);
			exit;
		}
	} else {
		$response["error"] = TRUE;
		$response["message"] = "Pengguna tidak ditemukan atau detil akun salah";
		echo json_encode($response);
		exit;
	}
} else {
	$response["error"] = TRUE;
	$response["message"] = "Parameter salah!";
	echo json_encode($response);
	exit;
}
