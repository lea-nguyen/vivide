<?php

    // Autoriser n'importe quel site web à récupérer en Javascript des données de cette API :

	require('header.php');

	require('../../private/connect.php');

	$data = json_decode(file_get_contents("php://input"), true);

	$name = htmlspecialchars($data["article_url"]);

	$request = "SELECT * FROM `articles`,`admin` WHERE `articles`.article_url=:name AND `articles`.ext_admin = `admin`.id_admin  ORDER BY `articles`.id_article DESC";
    $stmt = $db -> prepare($request);
	$stmt->bindParam(':name',$name,PDO::PARAM_STR);
    $stmt -> execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
	$link = $result["link"];
	$text=file_get_contents($link);

	echo json_encode([$text,$result]);