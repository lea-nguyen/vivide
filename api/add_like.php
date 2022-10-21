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


	$getIds = "SELECT * FROM `projects`,`videos` WHERE `videos`.ext_project=`projects`.id_project AND `videos`.video_url=:vid";
	$stmt = $db -> prepare($getIds);
    $stmt->bindParam(':vid',$data["video"],PDO::PARAM_STR);
    $stmt -> execute();
	$ids = $stmt ->fetch(PDO::FETCH_ASSOC);

	$request1 = "SELECT * FROM `rel_playlist` WHERE ext_user=:user AND ext_vid=:vid AND ext_playlist=1";
    $stmt_r = $db -> prepare($request1);
	$stmt_r->bindParam(':user',$userid,PDO::PARAM_INT);
	$stmt_r->bindParam(':vid',$ids["id_video"],PDO::PARAM_INT);
    $stmt_r -> execute();


	if($stmt_r -> rowcount() == 0){
	  if($data["do"]){
		$request1 = "INSERT INTO `rel_playlist` (`ext_user`, `ext_vid`, `ext_proj`,`ext_playlist`) VALUES (:user,:vid,:project,'1');";
		$stmt1 = $db -> prepare($request1);
		$stmt1->bindParam(':user',$userid,PDO::PARAM_INT);
		$stmt1->bindParam(':vid',$ids["id_video"],PDO::PARAM_INT);
		$stmt1->bindParam(':project',$ids["id_project"],PDO::PARAM_INT);
		$stmt1 -> execute();
	  }
	  echo json_encode(1);
	}else{
	  if($data["do"]){
	 	$request0 = "DELETE FROM `rel_playlist` WHERE ext_user=:user AND ext_vid=:vid AND ext_playlist=1";
    	$stmt0= $db -> prepare($request0);
		$stmt0->bindParam(':user',$userid,PDO::PARAM_INT);
		$stmt0->bindParam(':vid',$ids["id_video"],PDO::PARAM_INT);
    	$stmt0 -> execute();
	  }
	  echo json_encode(0);
	}