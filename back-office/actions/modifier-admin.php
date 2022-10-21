<?php
  session_start();
  if(session_id()!=$_SESSION["session"]){
  header('Location : https://managervivide.leanguyen.fr');
  }
  require '../../../private/connect.php';
$delete = "UPDATE `admin` SET `admin`.password_admin = '' WHERE `admin`.id_admin={$_GET["id"]}";
  $db->query($delete);
  header('Location: ../comptes-admin.php?order=0&by=id_admin');