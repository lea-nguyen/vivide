<?php
	use ReallySimpleJWT\Token;
	require('../../private/secret.php');
	require '../../vendor/autoload.php';
	require('../../private/connect.php');

	header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');
    header("Access-Control-Allow-Origin: https://vivide.leanguyen.fr");
    

	$data = json_decode(file_get_contents("php://input"), true);
	$token = $data["token"];
	$payload = Token::getPayload($token, $secret);
	$userid = (int) $payload["userid"];

    $array = [];


	$request = "SELECT * FROM `rel_playlist`,`projects`,`admin` WHERE `rel_playlist`.ext_user=:user AND `rel_playlist`.ext_proj = `projects`.id_project AND `rel_playlist`.ext_playlist=2 AND `projects`.ext_admin=`admin`.id_admin  ORDER BY `rel_playlist`.id_rel_play DESC LIMIT :limit";
    $stmt = $db -> prepare($request);
	$stmt->bindParam(':user',$userid,PDO::PARAM_INT);
	$stmt->bindParam(':limit',$data["number"],PDO::PARAM_INT);
    $stmt -> execute();
    // $result=$stmt->fetch(PDO::FETCH_ASSOC);
    while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
        array_push( $array, $result);
    };
	echo json_encode($array);    