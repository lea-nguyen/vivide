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
  header('Location : https://managervivide.leanguyen.fr');
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


            <div class="menulien articles active">
                <span class="iconify" data-icon="ic:outline-article" data-width="18" data-height="18"></span>

                <a href="../articles.php?order=0&by=id_article">Articles</a>
            </div>

            <div class="menulien comptes">
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
    $request = "SELECT * FROM `tag`;";
    $stmt = $db->query($request);
    $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>



    <main>
        <div class="haut">
            <div class="btn2">
                <a href="index.php">Se déconnecter</a>
            </div>
        </div>


        <h1>Ajouter un super admin</h1>

        <form action="../actions/ajouter-admin.php" method="post">


            <div class="form-haut">

                <div class="form-gauche">

                    <p class="input_label">
                        <label for="name_admin">Prénom</label>
                        <input type="text" name="name_admin" required>
                    </p>

                    <p class="input_label">
                        <label for="pseudo_admin">Pseudo</label>
                        <input type="text" name="pseudo_admin" required>
                    </p>

                    <p class="input_label">
                        <label for="password_admin">Mot de passe temporaire</label>
                        <input type="text" name="password_admin" value="JeDeviens1Admin!" readonly='readonly '>
                    </p>

                </div>


                <div class="form-droite">
                    <p>
                        <input type="checkbox" name="writer">
                        <label for="writer">Rédacteur/e</label>

                    </p>
                    <p>
                        <input type="checkbox" name="professor">
                        <label for="professor">Professeur/e</label>

                    </p>

                    <p>
                        <input type="checkbox" name="super_admin">
                        <label for="super_admin">Super-admin</label>

                    </p>
                </div>
            </div>
            <div class="form-bas">
                <input type="submit" value="Terminer">
            </div>
        </form>
    </main>

</body>

</html>