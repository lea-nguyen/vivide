<?php

    // Autoriser n'importe quel site web à récupérer en Javascript des données de cette API :
    header("Access-Control-Allow-Origin: https://vivide.app");

    // Fournir un résultat en JSON :
    header('content-type:application/json');


	require('../../private/connect.php');
    $array = [];
	$request = "SELECT * from videos,projects WHERE ext_project=id_project";
    $stmt = $db -> prepare($request);
    $stmt -> execute();
    // $result=$stmt->fetch(PDO::FETCH_ASSOC);
    while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
        array_push( $array, $result);
    };
	echo json_encode($array);          