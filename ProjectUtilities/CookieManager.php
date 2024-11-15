<?php
declare(strict_types=1);

namespace ProjectUtilities;

/**
 * Classe représente le gestionnaire de la connexion utilisateur avec les cookies
 */
class CookieManager
{
    /**
     * La durée de vie du cookie utilisateur
     */
    private const COOKIE_LIFETIME = 86400 * 4;

    /**
     * @param string $userCookieValue
     * @param string $userRole
     * @return void
     * La méthode pour créer le cookie utilisation
     */
    public static function createUserCookie(string $userCookieValue, string $userRole): void
    {
        setcookie("user", $userCookieValue, time() + self::COOKIE_LIFETIME, "/");
        setcookie("role", $userRole, time() + self::COOKIE_LIFETIME, "/");
    }

    /**
     * @return bool
     * La méthode pour verifier si le cookie utilisateur existe
     */
    public static function doesUserCookieExist(): bool
    {
        if (isset($_COOKIE["user"], $_COOKIE["role"])) {
            return true;
        }
        return false;
    }
}