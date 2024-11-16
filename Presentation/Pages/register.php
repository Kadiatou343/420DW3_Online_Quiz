<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../StyleSheets/style.css">
    <title>Document</title>
</head>
<body>

    <div class="container">
    <div class="register-form">
        <h2>Online&nbsp;Quiz&nbsp;-&nbsp;Inscription</h2>
        <form action="#" method="post">
            <input type="text" name="first_name" id="first_name" required placeholder="Prénom">
            <input type="text" name="last_name" id="last_name" required placeholder="Nom de Famille">
            <input type="email" name="email" id="email" required placeholder="Email">
            <input type="password" name="password" id="password" required placeholder="Mot de passe">
            <input type="password" name="conf_password" id="conf_password" required placeholder="Confirmer Mot de passe">
            
            <button type="submit">S'inscrire</button>
            
            <div class="question">
                <span>Vous avez un compte ?&nbsp;<a href="./login.php">Connectez-vous ici</a></span>
            </div>
            
        </form>
    </div>
    </div>
    
</body>
</html>