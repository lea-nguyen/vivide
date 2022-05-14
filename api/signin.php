<?php

	header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');
    header('Access-Control-Allow-Origin: https://vivide.app');
    header('Content-Type: application/json , text/plain,charset=UTF-8');

	require '../../private/connect.php';

	$data = json_decode(file_get_contents("php://input"), true);

	$email = $data["email"];
	$password = password_hash($data["password"], PASSWORD_DEFAULT);
	$birth = $data["birth"];
	$request = "INSERT INTO `users` (`pseudo`, `annee_naissance`, `email`, `password`) VALUES (:pseudo, $birth,:email, '$password');";
	$stmt = $db->prepare($request);
	$stmt->bindParam(':pseudo', $data["username"], PDO::PARAM_STR);
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();