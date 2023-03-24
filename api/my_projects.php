<?php

	use ReallySimpleJWT\Token;
	require('../../private/secret.php');
	require '../../vendor/autoload.php';
	require('../../private/connect.php');

	require('header.php');


	$data = json_decode(file_get_contents("php://input"), true);
	$token = $data["token"];
	$payload = Token::getPayload($token, $secret);
	$userid = (int) $payload["userid"];

	$request = "SELECT * FROM `rel_playlist`,`projects`,`admin` WHERE `rel_playlist`.ext_user=:user AND `rel_playlist`.ext_playlist = 4 AND `projects`.ext_admin=`admin`.id_admin AND `rel_playlist`.ext_proj=`projects`.id_project ORDER BY `rel_playlist`.id_rel_play DESC";
    $stmt = $db -> prepare($request);
	$stmt->bindParam(':user',$userid,PDO::PARAM_INT);
    $stmt -> execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);    