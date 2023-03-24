<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="../table.css">
</head>

<body>
<?php
  session_start();
  if(session_id()!=$_SESSION["session"]){
  header('Location : https://managervivide.leanguyen.fr');
  }
?>
    <header>
        <nav>
            <a href="projets.php?order=0&by=id_project">Projets</a>
            <a href="videos.php?order=0&by=id_video">Vidéos</a>
            <a href="articles.php?order=0&by=id_article">Articles</a>
            <a href="comptes.php?order=0&by=id_user">Comptes</a>
<?php
    if($_SESSION["sadmin"]===1){
        echo "<a href='comptes-admin.php?order=0&by=id_admin'>Les comptes admin</a>";
    }
?>
        </nav>
        <a href="index.php">Se déconnecter</a>
    </header>
<?php
		require '../../../private/connect.php';
        $placeholder = "SELECT * FROM `articles` WHERE `articles`.id_article=:id_article";
        $stmt2 = $db->prepare($placeholder);
        $stmt2 -> bindParam(':id_article',$_GET["id"],PDO::PARAM_INT);
        $stmt2 -> execute();
        $placeholder=$stmt2->fetch(PDO::FETCH_ASSOC);

?>
    <a href="../articles.php?order=0&by=id_article">Retour</a>
<?php
    echo "<p>Vous souhaitez <a href='../actions/modifier-article.php?id={$placeholder["id_article"]}' >supprimer l'article</a>, cette action supprimera les vidéos associées au projet</p>";
?>

</body>

</html>