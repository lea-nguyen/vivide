<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-office</title>
    <link rel="stylesheet" href="assets/styles/style.css">
</head>

<body>

    <div class="container">

        <h1>Back-office</h1>
        <br>

        <form action="actions/identification.php" method="post">
            <p class="identifiant">
                <label for="id">Identifiant</label>
                <br>
                <input type="text" name="id">
            </p>

            <p class="mdp">
                <label for="pswd">Mot de passe</label>
                <br>
                <input type="password" name="pswd">
            </p>

            <p class="btn">
                <input type="submit" value="Se connecter">
            </p>

        </form>

    </div>
    <?php
    if (isset($_GET["id"])) {
        echo "<div class='message' ><p>L'identifiant ou le mot de passe est mauvais.</p></div>";
    }
    session_start();
    if (array_key_exists("id", $_SESSION)) {
        session_unset();
        session_destroy();
    }
    ?>

</body>

</html>