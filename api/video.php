<?php

	require('header.php');
	require('../../private/connect.php');

	$request = "SELECT * from videos";
    $stmt = $db -> prepare($request);
    $stmt -> execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($result);
                

?>