<?php

use Business\Domain\User;
use Business\Services\UserService;
use ProjectUtilities\ArgumentOutOfRangeException;
use ProjectUtilities\UserRole;

require_once "../../psr4_autoloader.php";

/**
 * Le service de l'utilisateur utilisé pour effectuer les divers oprérations
 */
$userService = new UserService();

/**
 * Recupération de tous les utilisateurs du système
 */
$usersList = $userService->getAllUsers();

/**
 * Traitement des données si envoi confirmé par post
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * Actions à faire si c'est le bouton ajouter qui est cliqué
     */
    if (isset($_POST["btn"]) && $_POST["btn"] == "add") {
        $lastName = $_POST["lastName"];
        $firstName = $_POST["firstName"];
        $password = $_POST["password"];
        $email = $_POST["email"];

        try {
            $user = new User('','','','');
            $user->setLastName($lastName);
            $user->setFirstName($firstName);
            $user->setRole(UserRole::ADMIN->value);
            $user->setEmail($email);
            $user->setPasswordHash(password_hash($password, PASSWORD_DEFAULT));

            $newUser = $userService->addUserAdmin($user);
            
            /**
             * Refresh de la liste des utilisateurs
             */
            $usersList = $userService->getAllUsers();

        } catch (ArgumentOutOfRangeException $e) {
            $error = $e->getMessage();
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../StyleSheets/adminStyles.css">
    <title>Panel - Utilisateurs</title>
</head>
<body>
    <div class="main-container">
        <div class="list-user">
            <div class="filter">
                <input type="text" name="filter" id="filter" placeholder="Recherche un utilisateur">
                <button name="search" class="bttn">Recherche</button>
            </div>
            <div class="table-content">
                <div class="table-title">
                    <h3>Liste des utilisateurs</h3>
                    <a href="#" class="bttn">Ajouter Admin</a>
                </div>
                <table class="table table-stripped">
                    <thead>
                        <th scope="col">Id</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Registration</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                        <?php if (!empty($usersList->getListUsers())) {
                            foreach ($usersList->getListUsers() as $user) : ?>
                        <tr>
                            <th scope="row"> <?php echo $user->getId(); ?> </th>
                            <td> <?php echo $user->getFirstName(); ?> </td>
                            <td> <?php echo $user->getLastName(); ?> </td>
                            <td> <?php echo $user->getEmail(); ?> </td>
                            <td> <?php echo $user->getRole(); ?> </td>
                            <td> <?php echo $user->getRegistrationDate()->format('Y-m-d'); ?> </td>
                            <td>
                                <a href="?action=edit&userId=<?php echo $user->getId(); ?>"><i class="bi bi-pencil"></i></a>&nbsp;
                                <a href="?action=remove&userId=<?php echo $user->getId(); ?>"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; }?>
                    </tbody>
                </table>
                <div class="table-footer">
                    <a href="#" class="bttn">Filtrer par Admin</a>
                    <a href="#" class="bttn">Filtrer par Gamer</a>
                </div>
            </div>
        </div>
        <div class="add-admin">
            <div class="admin">
                <form action="#" method="post">
                    <div class="form-gr">
                        <div class="input-gr">
                            <label for="userId">Id</label>
                            <input type="text" name="userId" id="userId" readonly>
                        </div>

                        <div class="input-gr">
                            <label for="firstName">Prénom</label>
                            <input type="text" name="firstName" id="lastName" required>
                        </div>

                        <div class="input-gr">
                            <label for="lastName">Nom&nbsp;de&nbsp;famille</label>
                            <input type="text" name="lastName" id="lastName" required>
                        </div>

                        <div class="input-gr">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" required>
                        </div>

                        <div class="input-gr">
                            <label for="password">Mot&nbsp;de&nbsp;passe&nbsp;par&nbsp;defaut</label>
                            <input type="text" name="password" id="password" readonly value="0000">
                        </div>

                        <div class="input-gr">
                            <label for="date">Date&nbsp;d'enregistrement</label>
                            <input type="text" name="date" id="date" readonly>
                        </div>
                    </div>
                    <p class="error">
                        <?php if (isset($error)) { echo $error; } ?>
                    </p>
                    <div class="sbm">
                        <div><button type="submit" class="bttn" name="btn" value="add">Ajouter&nbsp;Admin</button></div>
                        <div><button type="submit" class="bttn" name="btn" value="update">MAJ&nbsp;Admin</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
