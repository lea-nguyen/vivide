<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-office</title>
    <link rel="stylesheet" href="assets/styles/style.css">
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

            <img src="assets/images/logo_vivide.png" alt="">

            <div class="menulien projets">
                <span class="iconify" data-icon="ci:list-plus" data-width="18" data-height="18"></span>

                <a href="projets.php?order=0&by=id_project">Projets</a>
            </div>

            <div class="menulien videos">
                <span class="iconify" data-icon="bxs:videos" data-width="18" data-height="18"></span>
                <a href="videos.php?order=0&by=id_video">Vidéos</a>
            </div>


            <div class="menulien articles active">
                <span class="iconify" data-icon="ic:outline-article" data-width="18" data-height="18"></span>

                <a href="articles.php?order=0&by=id_article">Articles</a>
            </div>

            <div class="menulien comptes">
                <span class="iconify" data-icon="ic:baseline-account-circle" data-width="18" data-height="18"></span>

                <a href="comptes.php?order=0&by=id_user">Comptes</a>
            </div>



            <?php
            if ($_SESSION["sadmin"] === 1) {
                echo "
                <div class='menulien comptesadmin'>
                <span class='iconify' data-icon='healthicons:ui-secure' data-width='18' data-height='18'></span>
                <a href='comptes-admin.php?order=0&by=id_admin'>Les comptes admin</a>
            </div> ";
            }
            ?>
        </nav>
    </header>





    <main>
        <div class="haut">
            <div class="btn2">
                <a href="index.php">Se déconnecter</a>
            </div>

            <div class="btn2">
                <span class="iconify" data-icon="akar-icons:plus" data-width="15" data-height="15"></span>

                <a href="ajouter/ajouter-article.php">Ajouter</a>
            </div>
        </div>
        <h1>Gestion des articles</h1>
        <table>
            <tr>

                <?php
                $th = array("titre" => "name_article", "auteur/e" => "name_admin", "date" => "date_article", "domaine" => "tag");
                foreach ($th as $key => $value) {
                    if ($value === $_GET["by"]) {
                        $order = $_GET["order"] ? 0 : 1;
                        echo "<th><a href='articles.php?order=$order&by=$value'>" . ucfirst($key) . "</a></th>";
                    } else {
                        echo "<th><a href='articles.php?order=0&by=$value'>" . ucfirst($key) . "</a></th>";
                    }
                }
                ?>
                <th></th>
            </tr>
            <?php
			require '../../private/connect.php';
            $request = "SELECT * FROM `articles`,`admin` WHERE `articles`.ext_admin=`admin`.id_admin ORDER BY {$_GET["by"]} DESC";
            if ($_GET["order"] === 1) {
                $request = "SELECT * FROM `articles`,`admin` WHERE `articles`.ext_admin=`admin`.id_admin ORDER BY {$_GET["by"]} ASC";
            }
            $stmt = $db->query($request);

            while ($article = $stmt->fetch()) {

?>
            <tr>
                <td><?php echo $article["name_article"] ?></td>
                <td><?php echo $article["name_admin"] ?></td>
                <td><?php echo $article["date_article"] ?></td>
                <td><?php echo $article["tag"] ?></td>
                
                    <td><a href="ajouter/modifier-articles.php?id=<?php echo $article["id_article"] ?>">
                            <span class="iconify" data-icon="ri:delete-bin-6-fill" data-width="20" data-height="20"></span></a></td>
                
            </tr>
<?php
            }
?>
        </table>
    </main>

    <script src="https://code.iconify.design/2/2.2.0/iconify.min.js"></script>
</body>

</html>