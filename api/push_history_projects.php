<?php

	use ReallySimpleJWT\Token;
	require('../../private/secret.php');
	require '../../vendor/autoload.php';
	require('../../private/connect.php');

	header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');
    header('Access-Control-Allow-Origin: https://vivide.app');
    header('Content-Type: application/json , text/plain,charset=UTF-8');

	$data = json_decode(file_get_contents("php://input"), true);
	$token = $data["token"];
	$payload = Token::getPayload($token, $secret);
	$userid = (int) $payload["userid"];

	$getId = "SELECT * FROM `projects` WHERE project_url=:project";
	$stmt = $db -> prepare($getId);
	$stmt -> bindValue(':project',$data["project"],PDO::PARAM_STR);
    $stmt -> execute();
	$proj = $stmt ->fetchAll(PDO::FETCH_ASSOC);

	$verify = "SELECT * FROM `rel_playlist` WHERE ext_playlist=2 AND ext_user=:user ORDER BY `id_rel_play` DESC LIMIT 1";
	$stmt2 = $db -> prepare($verify);
	$stmt2->bindParam(':user',$userid,PDO::PARAM_INT);
    $stmt2 -> execute();
	$result = $stmt2 ->fetchAll(PDO::FETCH_ASSOC);

	if($result[0]["ext_proj"]!=$proj[0]["id_project"] || $result[0]["ext_proj"]=""){
		$request = "INSERT INTO `rel_playlist` (`ext_user`, `ext_proj`,`ext_playlist`) VALUES (:user, :project,'2');";
	  	$stmt3 = $db -> prepare($request);
		$stmt3->bindParam(':user',$userid,PDO::PARAM_INT);
		$stmt3->bindParam(':project',$proj[0]["id_project"],PDO::PARAM_INT);
		$stmt3 -> execute();
	}