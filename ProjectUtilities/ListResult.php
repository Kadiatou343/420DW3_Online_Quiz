<?php
declare(strict_types=1);

namespace ProjectUtilities;

use Business\Domain\Result;

/**
 * Classe représentant une liste (array) de résultats
 */
class ListResult
{
    /**
     * @var Result[]
     * L'array qui contient des objets Result
     */
    private array $listResults = [];

    /**
     * @return Result[]
     * Le getter pour l'array de Result
     */
    public function getListResults(): array
    {
        return $this->listResults;
    }

    /**
     * @param Result $result
     * @return void
     * La méthode pour ajouter un element à l'array de la ListResult
     */
    public function addResult(Result $result): void{
        $this->listResults[] = $result;
    }
}