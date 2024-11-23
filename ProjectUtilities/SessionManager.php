<?php
declare(strict_types=1);

namespace ProjectUtilities;
session_start();

/**
 * Classe représente le gestionnaire de la connexion utilisateur avec les sessions
 */
class SessionManager
{
    /**
     * @param string $userSessionValue
     * @param string $userRoleValue
     * @param int $userId
     * @return void
     * La méthode pour créer une session d'utilisateur.
     * Les variables de session user et role vont representer la session utilisateur.
     * user pour stocker le prénom, role pour stocker le role de l'utilisateur, userId pour l'identifiant
     */
    public static function createUserSession(string $userSessionValue, string $userRoleValue, int $userId): void
    {
        $_SESSION["user"] = $userSessionValue;
        $_SESSION["role"] = $userRoleValue;
        $_SESSION["userId"] = $userId;
    }

    /**
     * @return bool
     * La méthode pour verifier si session utilisateur existe déjà
     */
    public static function doesUserSessionExit(): bool
    {
        if (isset($_SESSION["user"], $_SESSION["role"], $_SESSION["userId"])) {
            return true;
        }
        return false;
    }

}