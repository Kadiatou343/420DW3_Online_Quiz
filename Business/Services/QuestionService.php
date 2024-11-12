<?php
declare(strict_types=1);

namespace Business\Services;

use Business\Domain\Question;
use Business\Domain\Quiz;
use DataAccess\DAOs\QuestionDAO;
use Exception;
use ProjectUtilities\ListQuestion;

/**
 * Classe représentant le controller de la question
 */
class QuestionService
{
    /**
     * @var QuestionDAO
     * Le DAO de la question
     */
    private QuestionDAO $questionDAO;

    /**
     * Le constructeur initialise le DAO
     */
    public function __construct()
    {
        $this->questionDAO = new QuestionDAO();
    }

    /**
     * @param string $questionText
     * @param string $correctAnswer
     * @param string $wrongAnswer1
     * @param string $wrongAnswer2
     * @param string $wrongAnswer3
     * @param Quiz $quiz
     * @param string|null $imageUrl
     * @return Question
     * Créer une question
     */
    public function createQuestion(string $questionText,
                                   string $correctAnswer,
                                   string $wrongAnswer1,
                                   string $wrongAnswer2,
                                   string $wrongAnswer3,
                                   Quiz $quiz,
                                   ?string $imageUrl = null): Question
    {
        $question = new Question($questionText, $correctAnswer, $wrongAnswer1,
            $wrongAnswer2, $wrongAnswer3, $quiz, $imageUrl ?? 'No image');

        return $this->questionDAO->create($question);
    }

    /**
     * @param int $id
     * @return Question
     * Obtenir une question par son identifiant
     */
    public function getQuestionById(int $id): Question
    {
        return $this->questionDAO->getById($id);
    }

    /**
     * @return ListQuestion
     * Obtenir toutes les questions
     */
    public function getAllQuestions(): ListQuestion
    {
        return $this->questionDAO->getAll();
    }

    /**
     * @param Question $question
     * @return Question
     * @throws Exception
     * Mettre à jour une question
     */
    public function updateQuestion(Question $question): Question
    {
        return $this->questionDAO->update($question);
    }

    /**
     * @param Question $question
     * @return void
     * @throws Exception
     * Supprimer une question
     */
    public function deleteQuestion(Question $question): void
    {
        $this->questionDAO->delete($question);
    }

    /**
     * @param int $quizId
     * @return ListQuestion
     * Retourne les questions en fonction de l'identifiant d'un quiz
     */
    public function filterQuestionsByQuizId(int $quizId): ListQuestion
    {
        $quiz = $this->questionDAO->getQuizDAO()->getById($quizId);
        return $this->questionDAO->filterByQuiz($quiz);
    }
}