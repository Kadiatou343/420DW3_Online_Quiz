<?php
declare(strict_types=1);

namespace ProjectUtilities;

use DateTime;

/**
 * Classe représentant la date à partir d'une chaine de caractères
 */
class DateTimeFromString
{
    /**
     * @param string $dateString
     * @return DateTime
     * La méthode pour obtenir un DateTime à partir d'une chaine de caractères
     * suivant le format 'Y-m-d H:i:s'
     */
    public static function createDateTimeFromString(string $dateString) : DateTime
    {
        return DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
    }
}