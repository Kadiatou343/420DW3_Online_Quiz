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
     * Le dossier dans lequel les fichiers seront stockés
     */
    private const TARGET_DIR = "../Uploads/";
    private const ALLOWED_FILE_TYPES = ['image/jpeg', 'image/png'];

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

    /**
     * @param string $fileName
     * @return bool
     * La méthode pour verifier si le fichier existe dans le repertoire de stockage en local
     */
    public static function VerifyIfFileExists(string $fileName) : bool
    {
        if (file_exists(self::TARGET_DIR . $fileName)) {
            return true;
        }
        return false;
    }

    /**
     * @param string $fileServerPath
     * @param $fileName
     * @return bool
     * La méthode pour enregistrer un fichier en local
     */
    public static function moveFileToLocal(string $fileServerPath, $fileName) : bool
    {
        if (move_uploaded_file($fileServerPath, self::TARGET_DIR . $fileName)) {
            return true;
        }
        return false;
    }

    /**
     * @param string $fileServerPath
     * @return bool
     * La méthode pour determiner si un fichier est du type autorisé
     */
    public static function IsFileTypeAllowed(string $fileServerPath) : bool
    {
        $file_type = mime_content_type($fileServerPath);

        return in_array($file_type, self::ALLOWED_FILE_TYPES);
    }
}