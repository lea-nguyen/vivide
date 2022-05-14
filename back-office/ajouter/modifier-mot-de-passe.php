<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe</title>
</head>
<body>
    <p>Pour votre première connexion, veuillez modifier votre mot de passe temporaire.</p>
    <form action="../actions/modifier-mdp.php" method="post">
        <label for="pswd">Nouveau mot de passe</label>
        <input type="text" onchange="verify()" name="pswd" id="pswd">
        <label for="pswd2">Verifiez le mot de passe</label>
        <input type="text" onchange="verify()" name="pswd2" id="pswd2">
        <input type="submit" id="button">
    </form>
</body>
<script>
    const button = document.querySelector('#button');
    button.disabled=true;
    verify=()=>{
        let pswd = document.querySelector('#pswd').value;
        let pswd2 = document.querySelector('#pswd2').value;
        if(pswd==pswd2){
            button.disabled=false;
        }
    }
</script>
</html>