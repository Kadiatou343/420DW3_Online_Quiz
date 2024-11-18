<?php
declare(strict_types=1);

session_start();

use Business\Services\UserService;
use ProjectUtilities\CaptchaDAO;
use ProjectUtilities\CookieManager;
use ProjectUtilities\SessionManager;
use ProjectUtilities\UserRole;

/**
 * Inclusion du script d'autoload pour charger les classes
 */
require_once "../../psr4_autoloader.php";

/**
 * Verification d'une connexion pre-existante
 * Redirection vers page d'accueil si c'est le cas
 */

if (CookieManager::doesUserCookieExist()) {
    if (CookieManager::IsUserRoleAdmin()) {
        header("location: adminQuiz.php");
    } else {
        header("location: gamerHome.php");
    }
    exit();
}

/**
 * Recupération du captcha dans la base de données
 * Recupération du nombre de captcha existant
 * Génération aléatoire d'un id entre 1 et le nombre total de captcha
 * Recupération du captcha avec l'id géréré
 * Et affichage de l'image du captcha sur la page de login
 */
$captchaDao = new CaptchaDao();
$userService = new UserService();

$numberOfTuples = $captchaDao->getNumberOfTuples();

$randomCaptcha = mt_rand(1, $numberOfTuples);

$captcha = $captchaDao->getById($randomCaptcha);

$base64Image = null;
$imageSrc = null;

if ($captcha !== null) {
    $base64Image = base64_encode($captcha->getImageBlob());

    $imageSrc = "data:image/png;base64," . $base64Image;
}

/**
 * Verification des informations de connexion
 * Redirection, si utilisateur reconnu, vers la bonne page d'acceuil en fontion de son role
 */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $captchaUser = htmlspecialchars($_POST["captcha"]);

    try {
        // Appel de la méthode du service en charge de la connexion d'un utilisateur
        $user = $userService->logInUser($email, $password);
        if ($user === false) {
            throw new Exception("Mot de passe incorrect!");
        }

        if ($captchaUser !== $captcha->getCode()) {
            throw new Exception("Captcha incorrect! La validation robot n'a pas marché !");
        }

        if (isset($_POST['remember']) && $_POST["remember"] === "accepted") {
            CookieManager::createUserCookie($user->getEmail(), $user->getRole());
            SessionManager::createUserSession($user->getEmail(), $user->getRole());
        }

        if ($user !== false) {
            if ($user->getRole() === UserRole::GAMER->value) {
                header("Location: gamerHome.php");
            } else {
                header("Location: adminQuiz.php");
            }
            exit();
        }

    } catch (InvalidArgumentException|Exception $e) {
        $error = $e->getMessage();
    }

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
                <input type="checkbox" name="remember" id="remember" value="accepted">
            </div>
            <?php if (isset($error)) {
                echo "<p class='error'>" . $error . "</p>";
            } ?>
            <button type="submit">Se connecter</button>
            <br>
            <span>Vous n'avez pas de compte ?&nbsp;<a href="./register.php">Inscrivez-vous ici</a></span>

        </form>
    </div>
</div>

</body>
</html>
