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
	 
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	*/


	$data = api_get_all_data("SELECT * FROM users");
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
	
function api_get_all_data($query) {
	$conn = __dbConn();
	$stmt = $conn->prepare($query); //SELECT <field1>, <field2> FROM <table>
	$stmt->execute();
	/* if result execute not empty */
	if ($stmt->rowCount() > 0) {
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$dataTrue = array(
			'status' => 'berjaya',
			'data' => $results
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
}	

