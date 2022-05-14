<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
</head>

<body>
<?php
  session_start();
  if(session_id()!=$_SESSION["session"]){
  header('Location : https://manager.vivide.app');
  }
?>
    <header>
        <nav>

            <img src="../assets/images/logo_vivide.png" alt="">

            <div class="menulien projets">
                <span class="iconify" data-icon="ci:list-plus" data-width="18" data-height="18"></span>

                <a href="../projets.php?order=0&by=id_project">Projets</a>
            </div>

            <div class="menulien videos">
                <span class="iconify" data-icon="bxs:videos" data-width="18" data-height="18"></span>
                <a href="../videos.php?order=0&by=id_video">Vidéos</a>
            </div>


            <div class="menulien articles">
                <span class="iconify" data-icon="ic:outline-article" data-width="18" data-height="18"></span>

                <a href="../articles.php?order=0&by=id_article">Articles</a>
            </div>

            <div class="menulien comptes active">
                <span class="iconify" data-icon="ic:baseline-account-circle" data-width="18" data-height="18"></span>

                <a href="../comptes.php?order=0&by=id_user">Comptes</a>
            </div>



            <?php
            if ($_SESSION["sadmin"] == 1) {
                echo "

                <div class='menulien comptesadmin'>
                <span class='iconify' data-icon='healthicons:ui-secure' data-width='18' data-height='18'></span>


                <a href='../comptes-admin.php?order=0&by=id_admin'>Les comptes admin</a>
            </div>
                
                
                
                
               ";
            }
            ?>
        </nav>
    </header>
    <?php
	require '../../../private/connect.php';
    $placeholder = "SELECT * FROM `users` WHERE id_user=:id_user";
    $stmt2 = $db->prepare($placeholder);
    $stmt2->bindParam(':id_user', $_GET["id"], PDO::PARAM_INT);
    $stmt2->execute();
    $placeholder = $stmt2->fetch(PDO::FETCH_ASSOC);

    ?>

    <main>
        <a class="retour" href="../comptes.php?order=0&by=id_user">Retour</a>
        <?php
        echo "<p>Vous souhaitez <a class='btn3' href='../actions/modifier-user.php?id={$placeholder["id_user"]}' >supprimer le projet</a>, cette action supprimera les vidéos associées au projet</p>";
        ?>

    </main>
</body>

</html>