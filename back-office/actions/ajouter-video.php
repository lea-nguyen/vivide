<?php
	session_start();
	if(session_id()!==$_SESSION["session"]){
	header('Location : https://manager.vivide.leanguyen.fr');
	}
    require '../../../private/connect.php';
    require '../../../private/vimeo.php';
	require '../../../vendor/autoload.php';
	use Vimeo\Vimeo;
	header('Access-Control-Allow-Headers: Credentials');
	header('Access-Control-Allow-Credentials: true');

    
    $folder_name = $_POST["name"];
	$baseDirectory = "../../../web/uploads/videos/";
    $uploadDirectory = $baseDirectory.$folder_name.'/';

    $video_title =$_POST["name"];
    $video_description =$_POST["description"];

    $tag = "SELECT tag FROM projects WHERE id_project = :ext_project";
    $stmtTag = $db -> prepare($tag);
    $stmtTag -> bindParam(':ext_project', $_POST["project"], PDO::PARAM_STR);
    $stmtTag -> execute();
    $tag = $stmtTag -> fetch(PDO::FETCH_ASSOC);
	$uri="";

    if (! $_FILES["content"]["size"]===0) {
	  
        $fileExtensionsAllowedVideo = ['mp4'];
        $fileName = $_FILES["content"]["name"];
        $fileSize = $_FILES["content"]["size"];
        $fileTmpName = $_FILES["content"]["tmp_name"];
        $fileType = $_FILES["content"]["type"];
        $tmp = explode('.', $fileName);
        $fileExtension = end($tmp);
	
		if (!in_array($fileExtension, $fileExtensionsAllowedVideo)) {
		  	header('Location: ../ajouter/ajouter-video.php?comment=extension de la vidéo');
    	}

	    if ($fileSize > 2530000000) {
	    	header('Location: ../ajouter/ajouter-video.php?comment=poids de la vidéo');
	    }

		if (empty($errors)) {
	
			$client = new Vimeo($client_id, $client_secret, $access_token);
			
			$uri = $client->upload($fileTmpName, array(
			  "name" => $video_title,
			  "description" => $video_description
			));
			$uriSplit = explode('/',$uri);
		    $uri = end($uriSplit);
		  
            if (! $_FILES["thumbnail"]["size"]===0) {
            
                $fileExtensionsAllowedPhoto = ['jpeg','jpg','png'];
                $fileName = $_FILES["thumbnail"]["name"];
                $fileSize = $_FILES["thumbnail"]["size"];
                $fileTmpName = $_FILES["thumbnail"]["tmp_name"];
                $fileType = $_FILES["thumbnail"]["type"];
                $tmp = explode('.', $fileName);
                $fileExtension = end($tmp);
                $uploadPath = $uploadDirectory.basename($fileName);
            
            
                if (!in_array($fileExtension, $fileExtensionsAllowedPhoto)) {
                    header('Location: ../ajouter/ajouter-video.php?comment=extension de la miniature');
                }
            
                if ($fileSize > 100000) {
                    header('Location: ../ajouter/ajouter-video.php?comment=poids de la miniature');
                }
            
                if (empty($errors)) {
                
                    if (!file_exists($uploadPath)) {
                        mkdir($baseDirectory.$folder_name, 0777);
                    }
                    $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            
                    if ($didUpload) {
                        require '../../../private/connect.php';
                        $vidDirectory='https://vivide.leanguyen.fr/uploads/videos/'.$folder_name.'/'.$fileName;
                        $request = "INSERT INTO `videos` (`name_video`,`video_url`, `uri`, `description_vid`, `exercice`, `duration`, `tag`, `ext_project`, `position`,`thumbnail_vid`) VALUES (:nom, :slug, :link, :description_vid, :exercice, '{$_POST["duration"]}', :tag, :ext_project, :position,:thumbnail);";
                        $stmt = $db -> prepare($request);
                        $stmt -> bindParam(':ext_project', $_POST["project"], PDO::PARAM_INT);
                        $stmt -> bindParam(':nom', $video_title, PDO::PARAM_STR);
                        $stmt -> bindParam(':slug', $_POST["url"], PDO::PARAM_STR);
                        $stmt -> bindParam(':link', $uri, PDO::PARAM_STR);
                        $stmt -> bindParam(':description_vid', $video_description, PDO::PARAM_STR);
                        $stmt -> bindParam(':exercice', $_POST["exercice"], PDO::PARAM_STR);
                        $stmt -> bindParam(':position', $_POST["position"], PDO::PARAM_INT);
                        $stmt -> bindParam(':tag', $tag["tag"], PDO::PARAM_INT);
                        $stmt -> bindParam(':thumbnail', $vidDirectory, PDO::PARAM_STR);
                        $stmt -> execute();
                        header('Location: ../ajouter/ajouter-video.php?comment=success');
                    } else {
                        header('Location: ../ajouter/ajouter-video.php?comment=erreur miniature');
                    }
                }
            }    
	
		} else {
			header('Location: ../ajouter/ajouter-video.php?comment=erreur');
		}
    }