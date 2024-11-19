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
     * @var ?QuestionDAO
     * Le DAO de la question
     */
    private ?QuestionDAO $questionDAO;

    /**
     * Le constructeur initialise le DAO
     */
    public function __construct()
    {
        $this->questionDAO = new QuestionDAO();
    }

    public function getQuestionDAO(): ?QuestionDAO
    {
        return $this->questionDAO;
    }

    public function setQuestionDAO(?QuestionDAO $questionDAO): void
    {
        $this->questionDAO = $questionDAO;
    }

    /**
     * @param Question $question
     * @return Question
     * Créer une question
     */
    public function createQuestion(Question $question): Question
    {
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
        if ($quiz === null) {
            return new ListQuestion();
        }
        return $this->questionDAO->filterByQuiz($quiz);
    }

    /**
     * Desctructeur du service
     */
    public function __destruct()
    {
        $this->questionDAO = null;
    }
}