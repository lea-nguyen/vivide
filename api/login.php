<?php
	use ReallySimpleJWT\Token;
	require('../../private/secret.php');
	require('../../vendor/autoload.php');

	require('header.php');
	header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

	require('../../private/connect.php');

	$data = json_decode(file_get_contents("php://input"), true);

	$email = $data["email"];
    $password = $data["password"];

    $verify_email = "SELECT * FROM `users` WHERE `users`.email=:email OR `users`.pseudo=:email";
    $stmt = $db->prepare($verify_email);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt -> fetch(PDO::FETCH_ASSOC);
	if($stmt->rowcount()==1 && password_verify($password,$user["password"])){
		$userId = $user["id_user"];
		$username = $user["pseudo"];
		$userMail = $user["email"];
		$payload = [
		  'iat' => time(),
		  'userid' => $userId,
		  'username' => $username,
		  'usermail' => $userMail,
		  'exp' => time() + 3600,
		  'iss' => 'localhost'
	  	];

		$token = Token::customPayload($payload, $secret);
	  	echo json_encode(array("token"=>$token));
	 
	}