<?php
	session_start();
	if(session_id()!=$_SESSION["session"]){
	header('Location : https://manager.vivide.app');
	}

    $folder_name = $_POST["name"];
    $baseDirectory = "../../../web/uploads/articles/";
    $uploadDirectory = $baseDirectory.$folder_name.'/';

    $errors = [];

    $fileExtensionsAllowedContent = ['html'];
    $fileExtensionsAllowedPhotos = ['jpg', 'jpeg', 'png'];

    if (!$_FILES["content"]["size"]==0) {
        $fileName = $_FILES["content"]["name"];
        $fileSize = $_FILES["content"]["size"];
        $fileTmpName = $_FILES["content"]["tmp_name"];
        $fileType = $_FILES["content"]["type"];
        $tmp = explode('.', $fileName);
        $fileExtension = end($tmp);
        $uploadPath = $uploadDirectory.basename($fileName);

        if (!in_array($fileExtension, $fileExtensionsAllowedContent)) {
            header('Location: ../ajouter/ajouter-article.php?comment=extension de l\'article'); 
        }

        if ($fileSize > 120000) {
            header('Location: ../ajouter/ajouter-article.php?comment=poids de l\'article'); 
        }

        if (empty($errors)) {
            if (!file_exists($uploadPath)) {
                mkdir($uploadDirectory, 0777);
            }
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                if (! $_FILES["photos"]["size"][0]==0) {
                    $didUpload;
                    foreach($_FILES["photos"]["tmp_name"] as $key => $value) {
                        $fileName = $_FILES["photos"]["name"][$key];
                        $fileSize = $_FILES["photos"]["size"][$key];
                        $fileTmpName = $_FILES["photos"]["tmp_name"][$key];
                        $fileType = $_FILES["photos"]["type"][$key];
                        $tmp = explode('.', $fileName);
                        $fileExtension = end($tmp);
                        $uploadPath = $uploadDirectory.basename($fileName);
            
                        if (!in_array($fileExtension, $fileExtensionsAllowedPhotos)) {
                            header('Location: ../ajouter/ajouter-article.php?comment=extension des images'); 
                        }
                
                        if ($fileSize > 200000) {
                            header('Location: ../ajouter/ajouter-article.php?comment=poids des images'); 
                        }
                
                        if (empty($errors)) {
                            
                            if (!file_exists($uploadPath)) {
                                mkdir($uploadDirectory, 0777);
                                echo "Folder Created";
                            }
                            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
                        }
                    }
                    if (!$didUpload) {
                        header('Location: ../ajouter/ajouter-article.php?comment=erreur avec les images');
                    }
                }
                if (! $_FILES["thumbnail"]["size"]==0) {
                
                    $fileExtensionsAllowedPhoto = ['jpeg','jpg','png'];
                    $fileName = $_FILES["thumbnail"]["name"];
                    $fileSize = $_FILES["thumbnail"]["size"];
                    $fileTmpName = $_FILES["thumbnail"]["tmp_name"];
                    $fileType = $_FILES["thumbnail"]["type"];
                    $tmp = explode('.', $fileName);
                    $fileExtension = end($tmp);
                    $uploadPath = $uploadDirectory.basename($fileName);
                
                    if (!in_array($fileExtension, $fileExtensionsAllowedPhoto)) {
                        header('Location: ../ajouter/ajouter-article.php?comment=extension de la miniature'); 
                    }
                
                    if ($fileSize > 200000) {
                        header('Location: ../ajouter/ajouter-article.php?comment=poid de la miniature'); 
                    }
                
                    if (empty($errors)) {
                    
                        if (!file_exists($uploadPath)) {
                            mkdir($uploadDirectory, 0777);
                            echo "Folder Created";
                        }
                        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
                
                        if (!$didUpload) {
                            header('Location: ../ajouter/ajouter-article.php?comment=erreur'); 
                        }else{
                            require '../../../private/connect.php';
                            $articleDirectory='/home/clients/b63949c09209f576c307b6ad65feaf36/web/uploads/articles/'.$folder_name.'/'. $_FILES["content"]["name"];
                            $articleThumb ='https://vivide.app/uploads/articles/'.$folder_name.'/'.$fileName;
                            
						  $request="INSERT INTO `articles` (`name_article`, `article_url`, `description_article`, `ext_admin`, `tag`, `link`, `date_article`,`thumbnail_article`) VALUES (:name_art , :slug_art, :desc_art, :admin_art, :tag_art, :link, :date_art, :thumbnail);";
                            $stmt = $db->prepare($request);
                            $stmt->bindParam(':name_art', $_POST["name"],PDO::PARAM_STR);
                        	$stmt->bindParam(':slug_art', $_POST["url"], PDO::PARAM_STR);
                            $stmt->bindParam(':desc_art', $_POST["desc_art"],PDO::PARAM_STR);
                            $stmt->bindParam(':admin_art', $_POST["author"],PDO::PARAM_INT);
                            $stmt->bindParam(':tag_art', $_POST["tag"],PDO::PARAM_INT);
                            $stmt->bindParam(':link', $articleDirectory,PDO::PARAM_STR);
                            $stmt->bindParam(':date_art', $_POST["date"], PDO::PARAM_STR);
                            $stmt->bindParam(':thumbnail', $articleThumb, PDO::PARAM_STR);
						  	$stmt->execute();
            				header('Location: ../ajouter/ajouter-article.php?comment=success'); 
                        }
                    }
                }
			}else {
				header('Location: ../ajouter/ajouter-article.php?comment=erreur upload article'); 
			}
        }
    }