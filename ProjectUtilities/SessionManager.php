<?php
declare(strict_types=1);

namespace ProjectUtilities;

/**
 * Classe représente le gestionnaire de la connexion utilisateur avec les sessions
 */
class SessionManager
{
    /**
     * @param $userSessionValue
     * @param $userRoleValue
     * @return void
     * La méthode pour créer une session d'utilisateur.
     * Les variables de session user et role vont representer la session utilisateur.
     * user pour stocker l'email, role pour stocker le role de l'utilisateur
     */
    public static function createUserSession(string $userSessionValue, string $userRoleValue): void
    {
        $_SESSION["user"] = $userSessionValue;
        $_SESSION["role"] = $userRoleValue;
    }

    /**
     * @return bool
     * La méthode pour verifier si session utilisateur existe déjà
     */
    public static function doesUserSessionExit(): bool
    {
        if (isset($_SESSION["user"], $_SESSION["role"])) {
            return true;
        }
        return false;
    }

}