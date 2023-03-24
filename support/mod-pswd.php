<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifiez votre mot de passe</title>
	<link href="assets/styles/style.css" rel="stylesheet">
</head>
<body>
  <div class="container">
	<h1>Tapez votre nouveau mot de passe</h1><br>
<?php
require('../../private/connect.php');
$request="SELECT * FROM `change_request` WHERE `change_request`.ext_user={$_GET["u"]} ORDER BY `change_request`.id_reset DESC LIMIT 1;";
$stmt = $db -> prepare($request);
$stmt -> execute();
$result=$stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET["k"]) && isset($_GET["u"]) && $stmt->rowcount()===1){
?>
    <form class="reset.php" action="change-pswd.php" method="POST">
<?php   echo "<input type='hidden' name='k' value={$_GET["k"]}>";
        echo "<input type='hidden' name='u' value={$_GET["u"]}>"?>
        <label for="pswd1">Nouveau mot de passe</label>
		<p class="identifiant">
		  <input type="text" onchange="handlePswd()" name="pswd1" id="pswd1">
		</p>
		  <label for="pswd2">Retapez le nouveau mot de passe</label>
		<p class="identifiant">
		  <input type="text" onchange="handlePswd()" name="pswd2" id="pswd2">
		</p>
		<div class="form-bas">
		  <input type="submit" id="submit">
		</div>
    </form>
<?php
}else{
  header('Location:request.php?c=error');
}
if(isset($_GET["c"]) && $_GET["c"]==="same"){
  echo "<p>Vous ne pouvez pas réutiliser votre mot de passe actuel</p>";
}
?>
  </div>
</body>
<script>
    document.querySelector("#submit").disabled = true;
    handlePswd=()=>{
        let pswd1 = document.querySelector("#pswd1").value;
        let pswd2 = document.querySelector("#pswd2").value;
        if(pswd1===pswd2){
            document.querySelector("#submit").disabled = false;
            document.querySelector("#submit").style.color="#ff0000";
        }
        console.log(pswd1);
        console.log(pswd2);
    }
</script>
</html>