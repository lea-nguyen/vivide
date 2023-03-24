<?php
	session_start();
	if(session_id()!==$_SESSION["session"]){
	    header('Location : https://manager.vivide.leanguyen.fr');
	}

    $folder_name = $_POST["name"];
    $baseDirectory = "../../../web/uploads/projects/";
    $uploadDirectory = $baseDirectory.$folder_name.'/';

    $errors = [];

    $fileExtensionsAllowedPhotos = ['jpg', 'jpeg', 'png'];

    if (! $_FILES["thumbnail"]["size"]===0) {

        $fileName = $_FILES["thumbnail"]["name"];
        $fileSize = $_FILES["thumbnail"]["size"];
        $fileTmpName = $_FILES["thumbnail"]["tmp_name"];
        $fileType = $_FILES["thumbnail"]["type"];
        $tmp = explode('.', $fileName);
        $fileExtension = end($tmp);
        $uploadPath = $uploadDirectory.basename($fileName);

        if (!in_array($fileExtension, $fileExtensionsAllowedPhotos)) {
            header('Location: ../ajouter/ajouter-projet.php?comment=extension de la miniature');
        }

        if ($fileSize > 125000) {
            header('Location: ../ajouter/ajouter-projet.php?comment=poids de la miniature');
        }

        if (empty($errors)) {
            if (!file_exists($uploadPath)) {
                mkdir($uploadDirectory, 0777);
                echo "Folder Created";
            }
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                require '../../../private/connect.php';
                $projDirectory="https://vivide.leanguyen.fr/uploads/projects/".$folder_name.'/'.$fileName;
                
			  $request="INSERT INTO `projects` (`name_project`, `project_url`, `tag`, `description`, `ext_admin`,`thumbnail_proj`) VALUES (:nom, :slug, :tag, :description_proj, :ext_admin, :thumbnail);";
                $stmt=$db->prepare($request);
                $stmt->bindParam(':nom',$_POST["name"],PDO::PARAM_STR);
                $stmt->bindParam(':slug', $_POST["url"], PDO::PARAM_STR);
                $stmt->bindParam(':tag',$_POST["tag"],PDO::PARAM_INT);
                $stmt->bindParam(':description_proj',$_POST["description"],PDO::PARAM_STR);
                $stmt->bindParam(':ext_admin',$_POST["professor"],PDO::PARAM_INT);
                $stmt->bindParam(':thumbnail',$projDirectory,PDO::PARAM_STR);
                $stmt->execute();
                header('Location: ../ajouter/ajouter-projet.php?comment=success');
            } else {
                header('Location: ../ajouter/ajouter-projet.php?comment=erreur');
            }
        } 
    }