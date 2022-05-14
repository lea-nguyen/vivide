<?php
    require('../../privatephp/connect.php');
	use ReallySimpleJWT\Token;
	require('../../private/secret.php');
	require '../../vendor/autoload.php';

    $user_id=$_GET["u"];
    $user_token=$_GET["k"];

    // get token and validate
	$validate = Token::validate($user_id, $secret);
	$is_not_expired = Token::validateExpiration($user_id, $secret);

    if($validate && $is_not_expired){
	    $payload = Token::getPayload($token, $secret);
	  
        $request="UPDATE `users` SET `email` = {$payload["usermail"]} WHERE `users`.id_user = {$payload["userid"]}";
        $stmt=$db->prepare($request);
        $stmt->execute();

        $request2="UPDATE `change_request` SET `token_reset` = '' WHERE token_reset=$user_token";
        $stmt2=$db->prepare($request2);
        $stmt2->execute();
    }