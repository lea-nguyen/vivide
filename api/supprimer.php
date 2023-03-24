<?php
	use ReallySimpleJWT\Token;
	require '../../private/secret.php';
	require '../../vendor/autoload.php';
	require '../../private/connect.php';

	header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');
    header("Access-Control-Allow-Origin: https://vivide.leanguyen.fr");
    

	$data = json_decode(file_get_contents("php://input"), true);
	$token = $data["token"];

	$validate = Token::validate($token, $secret);
	$is_not_expired = Token::validateExpiration($token, $secret);

	$payload = Token::getPayload($token, $secret);

	if($validate){
	  $id=$payload["userid"];
	  $delete = "DELETE FROM `users` WHERE `users`.id_user = $id";
  	  $db->query($delete);
	  
	  $delete = "DELETE FROM `rel_playlist` WHERE `rel_playlist`.ext_user = $id";
  	  $db->query($delete);
	}