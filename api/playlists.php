<?php

    // Autoriser n'importe quel site web à récupérer en Javascript des données de cette API :
    header("Access-Control-Allow-Origin: https://vivide.leanguyen.fr");

    // Fournir un résultat en JSON :
    

	require('../../private/connect.php');
    $array = [];

	$request = "SELECT * from `projects`,`admin` WHERE `projects`.ext_admin=`admin`.id_admin";
	$stmt = $db -> prepare($request);
	$stmt -> execute();
	while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
        $time = "SELECT SUM(cast(left(right(cast(`videos`.duration as VARCHAR(9)),5),2) as INTEGER)) as total FROM `videos` WHERE `videos`.ext_project={$result["id_project"]}";
        $stmt2 = $db->query($time);
        $time=$stmt2->fetch(PDO::FETCH_ASSOC);
	  	$total = 0;
		if($time["total"]!==""){
		  $total = $time["total"];
		}
	  
		array_push( $result, $total);
	  
        $videos = "SELECT COUNT(*) as total FROM `videos` WHERE `videos`.ext_project={$result["id_project"]}";
        $stmt3 = $db->query($videos);
        $videos=$stmt3->fetch(PDO::FETCH_ASSOC);
	  
	  	$nb_video = 0;
		if($videos["total"]!==""){
		  $nb_video = $videos["total"];
		}	  
		array_push( $result, $nb_video);
		array_push( $array, $result);
	};
	
  
    echo json_encode($array);          
?>