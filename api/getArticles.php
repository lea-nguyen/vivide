<?php
    
    require('header.php');

	require('../../private/connect.php');

    $request = "SELECT * FROM `articles`,`admin` WHERE `articles`.ext_admin=`admin`.id_admin";
    $result = $db->query($request);
    $tab = [];
    $tab = $result->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tab);