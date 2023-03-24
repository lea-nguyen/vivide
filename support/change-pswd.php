<?php
	use ReallySimpleJWT\Token;
	require('../../private/secret.php');
	require '../../vendor/autoload.php';
	require '../../private/connect.php';

	$pswd1=password_hash($_POST["pswd1"], PASSWORD_DEFAULT);
	$user_id=$_POST["u"];
	$user_token=$_POST["k"];

	// get token and validate
	$is_valid = Token::validate($user_token, $secret);
	$is_not_expired = Token::validateExpiration($user_token,$secret);
	if($is_valid && $is_not_expired){
	//   verify it's a new pswd
	  $verify="SELECT * FROM `users` WHERE `users`.id_user = :userid";
	  $stmt=$db->prepare($verify);
	  $stmt->bindParam(':userid',$user_id,PDO::PARAM_INT);
	  $stmt->execute();
	  $v_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	  
	  if(password_verify($_POST["pswd1"],$v_data[0]["password"])){
		  header("Location:mod-pswd.php?u=$user_id&k=$user_token&c=same");
	  }else{
			// use token to update
		  $payload = Token::getPayload($user_token, $secret);
		  $request="UPDATE `users` SET `password` = '$pswd1' WHERE `users`.id_user = {$payload["userid"]}";
		  $stmt=$db->prepare($request);
		  $stmt->execute();
	  
		  $request2="UPDATE `change_request` SET `ext_user` = 0 WHERE ext_user=:user_id";
		  $stmt2=$db->prepare($request2);
		  $stmt2->bindParam(':user_id',$user_id,PDO::PARAM_INT);
		  $stmt2->execute();
	  	  header('Location: https://vivide.leanguyen.fr/identification/connexion');
	  }
	}
	header('Location: https://vivide.leanguyen.fr/identification/connexion?c=error');