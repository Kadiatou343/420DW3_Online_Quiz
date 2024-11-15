<?php
require_once "../../psr4_autoloader.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../StyleSheets/style.css">
    <title>Login - Panel</title>

</head>
<body>

    <div class="container">
    <div class="login-form">
        <h2>Connexion</h2>
        <form action="#" method="post">
            <input type="email" name="email" id="email" required placeholder="Email">
            <input type="password" name="password" id="password" required placeholder="Mot de passe">
            
            <div class="section-captcha">
                <img src="../../../img_two.png" alt="captcha">
                <input type="text" name="captcha" id="captcha" required placeholder="Entrez le texte de l'image">
            </div> <br>
            <span>Vous n'avez pas de compte ?&nbsp;<a href="./register.php">Inscrivez-vous ici</a></span>
            <button type="submit">Se connecter</button>
        </form>
    </div>
    </div>
    
</body>
</html>
