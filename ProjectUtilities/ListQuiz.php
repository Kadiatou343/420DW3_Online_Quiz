<?php
declare(strict_types=1);

namespace ProjectUtilities;

use Business\Domain\Quiz;

/**
 * Classe représentant une liste (array) de quiz
 */
class ListQuiz
{
    /**
     * @var Quiz[]
     * L'array qui contient des objets de Quiz
     */
    private array $listQuizzes = [];

    /**
     * @return Quiz[]
     * Le getter de l'array de quizzes
     */
    public function getListQuizzes(): array
    {
        return $this->listQuizzes;
    }

    /**
     * @param Quiz $quiz
     * @return void
     * La méthode pour ajouter un élément à l'array de quizzes
     */
    public function addQuiz(Quiz $quiz): void
    {
        $this->listQuizzes[] = $quiz;
    }


}