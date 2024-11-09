<?php

namespace ProjectUtilities;
use Exception;

/**
 * Classe représentant l'exception pour les membres qui depassent leur taille maximale
 */
class ArgumentOutOfRange extends Exception
{
    public function __construct(string $message){
        parent::__construct($message);
    }
}