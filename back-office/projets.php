<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-office</title>
    <link rel="stylesheet" href="table.css">
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

            <div class="menulien projets active">
                <span class="iconify" data-icon="ci:list-plus" data-width="18" data-height="18"></span>

                <a href="projets.php?order=0&by=id_project">Projets</a>
            </div>

            <div class="menulien videos">
                <span class="iconify" data-icon="bxs:videos" data-width="18" data-height="18"></span>
                <a href="videos.php?order=0&by=id_video">Vidéos</a>
            </div>


            <div class="menulien articles">
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
            </div>
                
                
                
                
               ";
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

                <a href="ajouter/ajouter-projet.php?">Ajouter</a>
            </div>
        </div>


        <h1>Gestion des projets</h1>
        <table>
            <tr>
                <?php
                $th = array("projets" => "name_project", "auteur" => "professor", "durée" => "duration", "date" => "date_projet");
                foreach ($th as $key => $value) {
                    if ($key === "durée") {
                        echo "<th>" . ucfirst($key) . "</th>";
                    } else if ($value === $_GET["by"]) {
                        $order = $_GET["order"] ? 0 : 1;
                        echo "<th><a href='projets.php?order=$order&by=$value'>" . ucfirst($key) . "</a></th>";
                    } else {
                        echo "<th><a href='projets.php?order=0&by=$value'>" . ucfirst($key) . "</a></th>";
                    }
                }
                ?>
            </tr>
            <?php
			require '../../private/connect.php';
            $request = "SELECT * FROM `projects`,`admin` WHERE `projects`.ext_admin=`admin`.id_admin ORDER BY {$_GET["by"]} DESC";
            if ($_GET["order"] === 1) {
                $request = "SELECT * FROM `projects`,`admin` WHERE `projects`.ext_admin=`admin`.id_admin ORDER BY {$_GET["by"]} ASC";
            }
            $stmt = $db->query($request);
            $project = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($project as $data) {
                $time = "SELECT SUM(cast(left(right(cast(`videos`.duration as VARCHAR(9)),5),2) as INTEGER)) as total FROM `videos` WHERE `videos`.ext_project={$data["id_project"]}";
                $stmt2 = $db->query($time);
                $time=$stmt2->fetch(PDO::FETCH_ASSOC);
            ?>
                <tr>
                    <td><?php echo $data["name_project"] ?></td>
                    <td><?php echo $data["name_admin"] ?></td>
				  <td><?php if($time["total"]===0){echo "0";}else{echo $time["total"];}?>'</td>
                    <td><?php echo $data["date_projet"] ?></td>
                    <td><a href="ajouter/modifier-projet.php?id=<?php echo $data["id_project"] ?>"><span class="iconify" data-icon="ri:delete-bin-6-fill" data-width="20" data-height="20"></span>
                        </a></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </main>

    <script src="https://code.iconify.design/2/2.2.0/iconify.min.js"></script>

</body>


</html>