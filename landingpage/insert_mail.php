<?php

require("../private/connect.php");

        
    //Insertion du mail dans la BDD
    $requete = "INSERT INTO email VALUES (NULL, :email)";
    $stmt = $db ->prepare($requete);

    $stmt->bindValue(':email',htmlspecialchars($_POST["email"]) , PDO::PARAM_STR);
    $stmt->execute();
    header('Location: index.php');
    
?>