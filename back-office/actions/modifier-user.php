<?php
  session_start();
  if(session_id()!=$_SESSION["session"]){
  header('Location : https://managervivide.leanguyen.fr');
  }
  require '../../../private/connect.php';
  $delete = "DELETE FROM `users` WHERE `users`.`id_user` = {$_GET["id"]}";
  $db->query($delete);
  header('Location: ../comptes.php?order=0&by=id_user');