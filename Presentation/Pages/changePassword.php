<?php
session_start();

use Business\Domain\User;
use Business\Services\UserService;
use ProjectUtilities\ArgumentOutOfRangeException;
use ProjectUtilities\SessionManager;

require_once "../../psr4_autoloader.php";

/**
 * Le service de l'utilisateur qui sera utilisé
 */
$userService = new UserService();

if (SessionManager::doesUserSessionExit()) {
    $userId = (int)$_SESSION['userId'];

    $user = $userService->getUserById($userId);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $password = htmlspecialchars($_POST["password"]);
            $confirmPassword = htmlspecialchars($_POST["confirmPassword"]);

            if (!User::confirmPassword($password, $confirmPassword)) {
                throw new Exception("Les mot de passe ne correspondent pas");
            }

            $user->setPasswordHash(password_hash($password, PASSWORD_DEFAULT));

            $userPasswordUpdated = $userService->updateUser($user);

            $success = "Votre mot de passe a été changé avec succès !";

        } catch (ArgumentOutOfRangeException|Exception $e) {
            $message = $e->getMessage();
        }
    }

} else {
    $message = "Le système n'arrive pas à reconnaitre l'utilisateur actuellement. Veuillez réessayer plus tard !";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans&display=swap" rel="stylesheet">
    <title>Document</title>
    <style>
        .main-container {
            position: absolute;
            right: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background: #f1f1f1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .fr-tb {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 100px;
        }

        .message {
            text-align: center;
        }

        .bttn {
            background: #023459;
            color: white;
            padding: 5px 10px;
            text-align: center;
            border-radius: 5px;
        }

        .bttn:hover {
            background: white;
            color: #023459;
            padding: 3px 8px;
            border: 2px solid;
        }

        td input[type=password] {
            width: 200px;
        }

        .sbm {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
<div class="main-container">
    <div class="update">
        <form action="#" method="post">
            <div class="fr-tb">
                <table>
                    <tr>
                        <td><label for="password">Nouveau&nbsp;mot&nbsp;de&nbsp;passe</label></td>
                        <td><input type="password" name="password" id="password" required></td>
                    </tr>
                    <tr>
                        <td><label for="confirmPassword">Confirmer&nbsp;Mot&nbsp;de&nbsp;passe</label></td>
                        <td><input type="password" name="confirmPassword" id="confirmPassword" required></td>
                    </tr>
                </table>
            </div>
            <div class="sbm">
                <button type="submit" class="bttn" name="changePassword">Changer&nbsp;Mot&nbsp;de&nbsp;passe</button>
            </div>
        </form>
        <p class="message">
            <?php echo $success ?? $message ?? ''; ?>
        </p>
    </div>
</div>
</body>
</html>
