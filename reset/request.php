<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier son mot de passe</title>
</head>
<body>

    <main>
        <form action="reset.php">
            <label for="email">Votre email svp</label>
            <input type="text" name="email">
            <input type="submit" value="Réinitialiser mot de passe">*1
        </form>
    </main>

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
