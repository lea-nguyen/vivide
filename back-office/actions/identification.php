<?php

    session_start();
  	require '../../../private/connect.php';
    
    //CONNEXION
    $request = "SELECT * FROM `admin` WHERE pseudo_admin=:login";
    $stmt = $db -> prepare($request);
    $stmt -> bindParam(':login', $_POST["id"], PDO::PARAM_STR);
    $stmt -> execute();
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    $mdp_hash = $result["password_admin"];
    $mdp = $_POST["pswd"];
    $verify = password_verify($mdp,$mdp_hash);

    if($stmt -> rowcount()===1 && $verify){
        $_SESSION["sadmin"]=$result["super_admin"];
        $_SESSION["id_admin"]=$result["id_admin"];
        $_SESSION["name_admin"]=$result["name_admin"];
	  	$_SESSION["session"] = session_id();
        header('location: ../projets.php?order=0&by=id_project');
        if($result["tmp_pswd"]!==1){
            header('location: ../ajouter/modifier-mot-de-passe.php?');
        }
    }else{
        header('location: ../index.php?id');
    }
 
?>