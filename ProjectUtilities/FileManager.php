<?php
declare(strict_types=1);

namespace ProjectUtilities;

/**
 * Classe représentant le gestionnaire des fichiers à gérer dans l'application
 */
class FileManager
{
    /**
     * La taille maximale d'une image acceptable
     */
    private const IMAGE_FILE_MAX_SIZE = 5000000;

    /**
     * @param int $imageSize
     * @return bool
     * La méthode qui verifie si la taille de l'image passée en paramètre est bien conforme
     */
    public static function verifyImageSize(int $imageSize) : bool
    {
        if ($imageSize > self::IMAGE_FILE_MAX_SIZE) {
            return false;
        }
        return true;
    }
}