<?php
declare(strict_types=1);

use ProjectUtilities\CaptchaDAO;

require_once "../../psr4_autoloader.php";

$captchaDao = new CaptchaDao();

$numberOfTuples = $captchaDao->getNumberOfTuples();

$randomCaptcha = mt_rand(1, $numberOfTuples);

$captcha = $captchaDao->getById($randomCaptcha);

$base64Image = null;
$imageSrc = null;

if ($captcha !== null)
{
    $base64Image = base64_encode($captcha->getImageBlob());

    $imageSrc = "data:image/png;base64," . $base64Image;
}

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
        <h2>Online&nbsp;Quiz&nbsp;-&nbsp;Connexion</h2>
        <form action="#" method="post">
            <input type="email" name="email" id="email" required placeholder="Email">
            <input type="password" name="password" id="password" required placeholder="Mot de passe">
            
            <div class="section-captcha">
                <img src="<?php echo $imageSrc ?? '../../../img_two.png' ?>" alt="captcha">
                <input type="text" name="captcha" id="captcha" required placeholder="Entrez le texte de l'image">
            </div>
            <div class="check">
                <p><span>Se rappeler de moi?</span></p>
                <input type="checkbox" name="remember" id="remember">
            </div>
            <button type="submit">Se connecter</button> <br> 
            <span>Vous n'avez pas de compte ?&nbsp;<a href="./register.php">Inscrivez-vous ici</a></span>
            
        </form>
    </div>
    </div>
    
</body>
</html>
