<?php
declare(strict_types=1);

require_once "../../psr4_autoloader.php";

use Business\Domain\User;
use Business\Services\UserService;
use ProjectUtilities\ArgumentOutOfRangeException;
use ProjectUtilities\UserRole;

/**
 * L'objet service user pour faire l'operation d'enregistrement dans la base de données
 */
$userService = new UserService();

/**
 * Verifier que la méthode d'envoie du server est bien post
 * Recupération des données du formulaire dans des variables locales
 * Certaines validations sont gérés du côté HTML (required, min)
 * Gestion des exceptions possibles d'être levées
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastName = htmlspecialchars($_POST["lastName"]);
    $firstName = htmlspecialchars($_POST["firstName"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirmPassword = htmlspecialchars($_POST["confirmPassword"]);

    try {
        $user = new User('', '', '', '');
        $user->setLastName($lastName);
        $user->setFirstName($firstName);
        $user->setEmail($email);
        $user->setRole(UserRole::GAMER->value);

        if (!User::confirmPassword($password, $confirmPassword)) {
            throw new Exception("Les mot de passes ne correspondent pas");
        }

        $user->setPasswordHash(password_hash($password, PASSWORD_DEFAULT));

        $newUser = $userService->registerUserGamer($user);

        header("Location: login.php");
        exit;

//        if ($newUser !== null) {
//
//        }

    } catch (ArgumentOutOfRangeException|InvalidArgumentException|Exception $e) {
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../StyleSheets/style.css">
    <title>Document</title>
</head>
<body>

<div class="container">
    <div class="register-form">
        <h2>Quizzy&nbsp;Dev&nbsp;-&nbsp;Inscription</h2>
        <form action="#" method="post">
            <input type="text" name="firstName" id="firstName" required placeholder="Prénom" min="2" value="<?php echo isset($user) ? $user->getFirstName(): '';?>">
            <input type="text" name="lastName" id="lastName" required placeholder="Nom de Famille" min="5" value="<?php echo isset($user) ? $user->getLastName(): '';?>">
            <input type="email" name="email" id="email" required placeholder="Email" value="<?php echo isset($user) ? $user->getEmail(): '';?>">
            <input type="password" name="password" id="password" required placeholder="Mot de passe" min="8">
            <input type="password" name="confirmPassword" id="confirmPassword" required
                   placeholder="Confirmer Mot de passe">
            <?php if (isset($error)) {
                echo "<p class='error'>" . $error . "</p>";
            } ?>
            <button type="submit">S'inscrire</button>

            <div class="question">
                <span>Vous avez un compte ?&nbsp;<a href="./login.php">Connectez-vous ici</a></span>
            </div>

        </form>
    </div>
</div>

</body>
</html>