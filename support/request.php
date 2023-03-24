<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Modifier son mot de passe</title>
	<link href="assets/styles/style.css" rel="stylesheet">
</head>

<body>

	<div class="container">

		<h1>Mot de passe oublié ?</h1>
		<p>Nous allons vous envoyer les instructions</p>
		<br>
		<form action="reset.php">

			<label for="email">Email*</label>
			<p class="identifiant">
				<input type="text" name="email" placeholder="ameliesmith@gmail.com">
			</p>


			<div class="form-bas">
				<input type="submit" value="Envoyer">
			</div>
		</form>
	</div>
	


<?php
	if(isset($_GET["c"])){
		if($_GET["c"]==="error"){
			echo "<p>Il y a eu une erreur. Veuillez recommencer.</p>";
		}else if($_GET["c"]==="success"){
			echo "<p>Un mail a été envoyé. Surveillez vos spams.</p>";
		}
	}
?>

</body>

</html>