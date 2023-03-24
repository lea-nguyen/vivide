<?php
  require '../../../private/connect.php';
    session_start();
    $verify="SELECT * FROM `admin` WHERE `admin`.`id_admin` = {$_SESSION["id_admin"]};";
    $stmt = $db->prepare($verify);
    $verify = $stmt->fetch(PDO::FETCH_ASSOC);
    if(password_verify($_POST["pswd"],$verify["password_admin"])!==1){
        $pswd = password_hash($_POST["pswd"],PASSWORD_DEFAULT);
        $mod="UPDATE `admin` SET `tmp_pswd` = '1', `password_admin`='$pswd' WHERE `admin`.`id_admin` = {$_SESSION["id_admin"]};";
        $db->query($mod);
        header('Location: ../projets.php?order=0&by=id_project');
    }else{
        header('Location: ../ajouter.php?mdp');
    }