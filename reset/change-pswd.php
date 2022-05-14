<?php
include('connect.php');
$pswd1=password_hash($_POST["pswd1"], PASSWORD_DEFAULT);
$user_id=$_POST["u"];
$user_token=$_POST["k"];

$verify="SELECT * FROM `users` WHERE `users`.id_user = :userid";
$stmt=$db->prepare($verify);
$stmt->bindParam(':userid',$user_id,PDO::PARAM_INT);
$stmt->execute();
$v_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(password_verify($_POST["pswd1"],$v_data[0]["password"])){
    header("Location:mod-pswd.php?u=$user_id&k=$user_token&c=same");
}else{
    $request="UPDATE `users` SET `password` = '$pswd1' WHERE `users`.id_user = :userid";
    $stmt=$db->prepare($request);
    $stmt->bindParam(':userid',$user_id,PDO::PARAM_STR);
    $stmt->execute();

    $request2="UPDATE `reset_pswd` SET `done` = 1 WHERE token_reset=:user_token";
    $stmt2=$db->prepare($request2);
    $stmt2->bindParam(':user_token',$user_token,PDO::PARAM_STR);
    $stmt2->execute();
}