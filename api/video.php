<?php

    // Autoriser n'importe quel site web à récupérer en Javascript des données de cette API :
    header("Access-Control-Allow-Origin: https://vivide.leanguyen.fr");

    // Fournir un résultat en JSON :
    


	require('../../private/connect.php');

	$request = "SELECT * from videos";
    $stmt = $db -> prepare($request);
    $stmt -> execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($result);
                

?>