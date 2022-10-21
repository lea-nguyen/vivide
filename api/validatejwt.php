<?php
	use ReallySimpleJWT\Token;
	require('../../private/secret.php');
	require '../../vendor/autoload.php';

    require('header.php');

	$data = json_decode(file_get_contents("php://input"), true);
	$token = $data["token"];

	$validate = Token::validate($token, $secret);
	$is_not_expired = Token::validateExpiration($token, $secret);

	$payload = Token::getPayload($token, $secret);

	if($validate){
	  if(!$is_not_expired){

		$userId = $payload["userid"];
		$username = $payload["username"];
		
		$payload = [
		  'iat' => time(),
		  'userid' => $userId,
		  'username' => $username,
		  'exp' => time() + 3600,
		  'iss' => 'localhost'
	  	];

		$token = Token::customPayload($payload, $secret);
	  }
	  echo json_encode(array("token"=>"$token"));
	}