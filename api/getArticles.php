<?php
    
    // Autoriser n'importe quel site web à récupérer en Javascript des données de cette API :
    header("Access-Control-Allow-Origin: https://vivide.app");

    // Fournir un résultat en JSON :
    header('content-type:application/json');

	require('../../private/connect.php');

    $request = "SELECT * FROM `articles`,`admin` WHERE `articles`.ext_admin=`admin`.id_admin";
    $result = $db->query($request);
    $tab = [];
    $tab = $result->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tab);