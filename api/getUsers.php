<?php
    
    require('header.php');

	require('../../private/connect.php');

    $request = "SELECT email, pseudo FROM users";
    $result = $db->query($request);
    $tab = [];
    $tab = $result->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tab);
    