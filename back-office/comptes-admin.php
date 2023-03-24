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
  if(session_id()!==$_SESSION["session"]){
  header('Location : https://manager.vivide.leanguyen.fr');
  }
?>
    <header>
        <nav>

            <img src="assets/images/logo_vivide.png" alt="">

            <div class="menulien projets">
                <span class="iconify" data-icon="ci:list-plus" data-width="18" data-height="18"></span>

                <a href="projets.php?order=0&by=id_project">Projets</a>
            </div>

            <div class="menulien videos ">
                <span class="iconify" data-icon="bxs:videos" data-width="18" data-height="18"></span>
                <a href="videos.php?order=0&by=id_video">Vidéos</a>
            </div>


            <div class="menulien articles">
                <span class="iconify" data-icon="ic:outline-article" data-width="18" data-height="18"></span>

                <a href="articles.php?order=0&by=id_article">Articles</a>
            </div>

            <div class="menulien comptes ">
                <span class="iconify" data-icon="ic:baseline-account-circle" data-width="18" data-height="18"></span>

                <a href="comptes.php?order=0&by=id_user">Comptes</a>
            </div>



            <?php
            if ($_SESSION["sadmin"] === 1) {
                echo "
                <div class='menulien comptesadmin active'>
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

                <a href="ajouter/ajouter-admin.php?">Ajouter</a>
            </div>
        </div>
        <h1>Gestion des comptes admin</h1>
        <table>
            <tr>
                <?php
                $th = array("Prénom" => "name_admin", "Pseudo" => "pseudo_admin", "Super admin" => "super_admin", "Rédacteur" => "writer", "Professeur" => "professor");
                foreach ($th as $key => $value) {
                    if ($value === $_GET["by"]) {
                        $order = $_GET["order"] ? 0 : 1;
                        echo "<th><a href='comptes-admin.php?order=$order&by=$value'>" . ucfirst($key) . "</a></th>";
                    } else {
                        echo "<th><a href='comptes-admin.php?order=0&by=$value'>" . ucfirst($key) . "</a></th>";
                    }
                }
                ?>
                <td></td>
            </tr>
            <?php
			require '../../private/connect.php';
            $request = "SELECT * FROM `admin` ORDER BY {$_GET["by"]} DESC";
            if ($_GET["order"] === 1) {
                $request = "SELECT * FROM `admin` ORDER BY {$_GET["by"]} ASC";
            }
            $stmt = $db->query($request);
            while ($admin = $stmt->fetch()) {
            ?>
                <tr>
                    <td><?php echo $admin["name_admin"] ?></td>
                    <td><?php echo $admin["pseudo_admin"] ?></td>
                    <td><?php echo $admin["super_admin"] ?></td>
                    <td><?php echo $admin["writer"] ?></td>
                    <td><?php echo $admin["professor"] ?></td>

            <?php
            	if ($_SESSION["sadmin"] === 1) {
			?>
                    <td><a href="ajouter/modifier-admin.php?id=<?php echo $admin["id_admin"] ?>">
                            <span class="iconify" data-icon="ri:delete-bin-6-fill" data-width="20" data-height="20"></span></a></td>
                
				  <?php }else{ ?>
				  <td></td>
				  <?php } ?>
		  		</tr>
            <?php
            }
            ?>
        </table>
    </main>
</body>
<script src="https://code.iconify.design/2/2.2.0/iconify.min.js"></script>

</html>