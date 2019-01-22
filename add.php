<?php

/*
 * design the content to be in JSON format
 */
header('Access-Control-Allow-Headers: Content-Type, Authorization');
/*
 * Access-Control-Allow-Origin for allow request from diffrent domain
 * Exp:
 *      "Access-Control-Allow-Origin: *"
 *      "Access-Control-Allow-Origin: http://www.example.org/"
 */
header("Access-Control-Allow-Origin: *");
/*
 * Access-Control-Allow-Methods for allow request method such as GET, POST, OPTIONS
 */
header('Access-Control-Allow-Methods: POST');

/**
* Get Request Header
* for Authorization value
*/
$headers = apache_request_headers();
$token = auth_token($headers);

if($token){
	/**
	 * Get POST Value from AJAX Post
	 */
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata, true);
	

	$data = api_add_new_data($request);
	if ($data) {
		echo json_encode($data); //show JSON Format
		exit();
	}

}else{
	$dataFalse = array(
		'status' => 'gagal',
		'mesej'=>'Invalid token',
		'data' => []
	);
	echo json_encode($dataFalse); //show JSON Format
	exit();
}

function auth_token($headers){
	if(isset($headers['Authorization'])){
		$key = "Abc123";
		$token = explode("Bearer ", $headers['Authorization']);
		if($token[1] == $key){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}	

function __dbConn(){
	$dbHost = "localhost";
	$dbUser = "root";
	$dbPass = "password";
	$dbName = "db_api";
	try {
		$conn = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	} catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
	
}	

function api_add_new_data($data) {
	$conn = __dbConn();
	
	if((isset($data['nama']) && $data['nama'] != '' ) 
	   ||(isset($data['email']) && $data['email'] != '' ) 
	   ||(isset($data['telefon']) && $data['telefon'] != '' ) )){
		$fnama = $data['nama'];
		$femail = $data['email'];
		$ftelefon = $data['telefon'];

		$stmt = $conn->prepare("INSERT INTO users(nama,email,telefon) VALUES(:nama, :email, :telefon)");
		$stmt->bindparam(":nama", $fname);
		$stmt->bindparam(":email", $femail);
		$stmt->bindparam(":telefon", $ftelefon);
		if ($stmt->execute()) {
			$lastInsertId = $conn->lastInsertId(); //Get Last ID after insert
			$dataTrue = array(
				'status' => 'berjaya',
				'data' => array('id' => $lastInsertId, 'nama' => $fnama, 'email' => $femail, 'telefon' => $ftelefon)
			);
			return $dataTrue;
		}else{
			$dataFalse = array(
				'status' => 'gagal',
				'mesej'=>'data empty',
				'data' => []
			);
			return $dataFalse;
		}
	}else{
		$dataFalse = array(
			'status' => 'gagal',
			'mesej'=>'invalid data',
			'data' => []
		);
		return $dataFalse;
	}
}
