<?php
  session_start();
  if(session_id()!=$_SESSION["session"]){
  header('Location : https://managervivide.leanguyen.fr');
  }
  require '../../../private/connect.php';
  $delete = "DELETE FROM `projects` WHERE `projects`.id_project = {$_GET["id"]}";
  $db->query($delete);
  header('Location: ../projets.php?order=0&by=id_project');