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
     * @param int $userId
     * @return void
     * La méthode pour créer le cookie utilisateur
     */
    public static function createUserCookie(string $userCookieValue, string $userRole, int $userId = 0): void
    {
        setcookie("user", $userCookieValue, time() + self::COOKIE_LIFETIME, "/");
        setcookie("role", $userRole, time() + self::COOKIE_LIFETIME, "/");
        setcookie("userId", (string) $userId, time() + self::COOKIE_LIFETIME, "/");
    }

    /**
     * @return bool
     * La méthode pour verifier si le cookie utilisateur existe
     */
    public static function doesUserCookieExist(): bool
    {
        if (isset($_COOKIE["user"], $_COOKIE["role"], $_COOKIE["userId"])) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * Determiner le role du cookie utilisateur
     */
    public static function IsUserRoleAdmin(): bool
    {
        if ($_COOKIE["role"] === UserRole::ADMIN->value) {
            return true;
        }
        return false;
    }
}