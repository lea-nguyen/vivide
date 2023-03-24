<?php
  session_start();
  if(session_id()!==$_SESSION["session"]){
  header('Location : https://manager.vivide.leanguyen.fr');
  }
  require '../../../private/connect.php';
  $delete = "DELETE FROM `articles` WHERE `articles`.id_article = {$_GET["id"]}";
  $db->query($delete);
  header('Location: ../articles.php?order=0&by=id_article');