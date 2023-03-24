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


	$getIds = "SELECT * FROM `projects` WHERE `projects`.project_url=:proj";
	$stmt = $db -> prepare($getIds);
    $stmt->bindParam(':proj',$data["project"],PDO::PARAM_STR);
    $stmt -> execute();
	$ids = $stmt ->fetch(PDO::FETCH_ASSOC);

	$request_r = "SELECT * FROM `rel_playlist` WHERE ext_user=:user AND ext_proj=:proj AND ext_playlist=4";
    $stmt_r = $db -> prepare($request_r);
	$stmt_r->bindParam(':user',$userid,PDO::PARAM_INT);
	$stmt_r->bindParam(':proj',$ids["id_project"],PDO::PARAM_INT);
    $stmt_r -> execute();

	if($stmt_r -> rowcount() === 0){
	  if($data["do"]){
		$request1 = "INSERT INTO `rel_playlist` (`ext_user`, `ext_proj`,`ext_playlist`) VALUES (:user,:project,'4');";
		$stmt1 = $db -> prepare($request1);
		$stmt1->bindParam(':user',$userid,PDO::PARAM_INT);
		$stmt1->bindParam(':project',$ids["id_project"],PDO::PARAM_INT);
		$stmt1 -> execute();
	  }
	  echo json_encode(1);
	}else{
	  if($data["do"]){
	 	$request0 = "DELETE FROM `rel_playlist` WHERE ext_user=:user AND ext_playlist=4";
    	$stmt0= $db -> prepare($request0);
		$stmt0->bindParam(':user',$userid,PDO::PARAM_INT);
    	$stmt0 -> execute();
	  }
	  echo json_encode(0);
	}