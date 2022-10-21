<?php
	session_start();
	if(session_id()!=$_SESSION["session"]){
	header('Location : https://managervivide.leanguyen.fr');
	}
  require '../../../private/connect.php';
  $pseudo_admin = "SELECT pseudo_admin FROM `admin` WHERE pseudo_admin = :pseudo_admin";
  $stmt = $db -> prepare($pseudo_admin);
  $stmt -> bindParam(':pseudo_admin', $_POST["pseudo_admin"], PDO::PARAM_STR);
  $stmt -> execute();
  if ($stmt -> rowcount() == 0) {
	  var_dump($_POST);
	  if(isset($_POST["professor"])){$is_prof=1;}else{$is_prof=0;};
	  if(isset($_POST["writer"])){$is_writer=1;}else{$is_writer=0;};
	  if(isset($_POST["super_admin"])){$is_sadmin=1;}else{$is_sadmin=0;};
	  $passwd = password_hash($_POST["password_admin"],PASSWORD_DEFAULT);
  
	  $request = "INSERT INTO `admin` (`name_admin`, `pseudo_admin`, `password_admin`, `writer`, `super_admin`, `professor`) VALUES (:name_admin, :pseudo_admin, '$passwd', '$is_writer', '$is_sadmin', '$is_prof')";
	  $stmt = $db -> prepare($request);
	  $stmt->bindParam(':name_admin', $_POST["name_admin"], PDO::PARAM_STR);
	  $stmt->bindParam(':pseudo_admin', $_POST["pseudo_admin"], PDO::PARAM_STR);
	  $stmt -> execute();
	  header('Location: ../comptes-admin.php?order=0&by=id_admin');
  } else {
	  header('Location: ../ajouter/ajouter-admin.php?id');
	}