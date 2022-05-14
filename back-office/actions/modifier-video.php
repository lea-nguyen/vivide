<?php

  session_start();
  if(session_id()!=$_SESSION["session"]){
  header('Location : https://manager.vivide.app');
  }
  require '../../../private/connect.php';
  $delete = "DELETE FROM `videos` WHERE `videos`.`id_video` = {$_GET["id"]}";
  $db->query($delete);
  header('Location: ../videos.php?order=0&by=id_video');