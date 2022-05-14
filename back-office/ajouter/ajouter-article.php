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
    $request = "SELECT * FROM `admin` WHERE `admin`.writer=1";
    $stmt = $db->query($request);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tags = "SELECT * FROM `tag`;";
    $stmt = $db->query($tags);
    $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>


    <main>
        <div class="haut">
            <div class="btn2">
                <a href="index.php">Se déconnecter</a>
            </div>
        </div>


        <h1>Ajouter un article</h1>
        <form action="../actions/ajouter-articles.php" method="post" enctype="multipart/form-data">

            <div class="form-haut">
                <div class="form-gauche">

                    <p class="input_label">
                        <label for="photos[]">Photos</label>
                        <input type="file" name="photos[]" multiple>
                    </p>

                    <p class="input_label">
                        <label for="name">Titre</label>
                        <input type="text" name="name">
                    </p>

                    <p class="input_label">
                        <label for="description">Auteur/e</label>

                        <?php
                        echo "<input type='hidden' name='author' value={$_SESSION["id_admin"]}> ";
                        echo "<input type='text'  value={$_SESSION["name_admin"]} readonly='readonly'>  </p>";
                        ?>

                    <p class="input_label">
                        <label for="date">Date</label>
                        <input type="date" name="date">
                    </p>
                    <p class="input_label">
                        <label for="thumbnail">Miniature</label>
                        <input type="file" name="thumbnail">
                    </p>

                </div>

                <div class="form-droite">
					<p class="input_label">
					  <label for="url">Nom dans l'URL</label>
					  <input type="text" name="url" required placeholder="Reprendre le titre, remplacer les espaces par des - et éviter les accents">
					</p>
                    <p class="input_label description">
                        <label for="text">Contenu</label>
                        <input type="file" name="content" id="fileToUpload">
                    </p>
                    <p class="input_label">
                        <label for="desc_art">Description</label>
                        <input type="text" name="desc_art">
                    </p>

                    <p class="input_label">
                        <label for="tag">Domaine</label>
                        <select name="tag">
                            <?php
                            foreach ($tags as $tag) {
                                echo "<option value={$tag["id_tag"]}>{$tag["name_tag"]}</option>";
                            }
                            ?>
                        </select>
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