<?php
declare(strict_types=1);

namespace ProjectUtilities;

use Business\Domain\Question;

/**
 * Classe représentant une liste (array) de Question
 */
class ListQuestion
{
    /**
     * @var Question[]
     * L'array qui contient des objets de Question
     */
    private array $listQuestions = [];

    /**
     * @return Question[]
     * Le getter de l'array de questions
     */
    public function getListQuestions(): array
    {
        return $this->listQuestions;
    }

    /**
     * @param Question $question
     * @return void
     * La méthode pour ajouter un élément à l'array de questions
     */
    public function addQuestion(Question $question): void
    {
        $this->listQuestions[] = $question;
    }
}