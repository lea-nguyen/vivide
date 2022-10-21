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

	$project_name = $data["project"];
	$video_name = $data["video"];

	$getIds = "SELECT * FROM `projects`,`videos` WHERE `projects`.project_url='$project_name' AND `videos`.video_url='$video_name'";
	$stmt = $db -> prepare($getIds);
    $stmt -> execute();
	$ids = $stmt ->fetchAll(PDO::FETCH_ASSOC);

	$verify = "SELECT * FROM `rel_playlist` WHERE playlist=3 AND ext_user=:user ORDER BY `id_rel_play` DESC LIMIT 1";
	$stmt = $db -> prepare($verify);
	$stmt->bindParam(':user',$userid,PDO::PARAM_INT);
    $stmt -> execute();
	$result = $stmt ->fetchAll(PDO::FETCH_ASSOC);

	if($result[0]["ext_vid"]!=$ids[0]["id_video"]){
		$request = "INSERT INTO `rel_playlist` (`id_rel_play`, `ext_user`, `ext_vid`, `ext_proj`,`playlist`) VALUES (NULL, :user, :video, :project,'3');";
		$stmt = $db -> prepare($request);
		$stmt->bindParam(':user',$userid,PDO::PARAM_INT);
		$stmt->bindParam(':project',$ids[0]["id_project"],PDO::PARAM_INT);
		$stmt->bindParam(':video',$ids[0]["id_video"],PDO::PARAM_INT);
		$stmt -> execute();
	}