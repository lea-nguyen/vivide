<?php
    
    require('header.php');

	foreach($_POST as $key=>$value){
        $data = json_decode($key, true);
    }

	require('../../private/connect.php');
	$tab=[];
	if($data["userid"]!=null){
		$request = "SELECT email, pseudo FROM users WHERE id_user={$data["userid"]}";
		$result = $db->query($request);
		$tab = $result->fetchAll(PDO::FETCH_ASSOC);
    	echo json_encode($tab);
	}
