<?php
declare(strict_types=1);

namespace Business\Services;

use Business\Domain\Question;
use Business\Domain\Quiz;
use DataAccess\DAOs\QuestionDAO;
use Exception;
use InvalidArgumentException;
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
    private QuizService $quizService;

    /**
     * Le constructeur initialise le DAO
     */
    public function __construct()
    {
        $this->questionDAO = new QuestionDAO();
        $this->quizService = new QuizService();
    }

    public function getQuizService(): QuizService
    {
        return $this->quizService;
    }

    public function setQuizService(QuizService $quizService): void
    {
        $this->quizService = $quizService;
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
     */
    public function getQuestionById(int $id): Question
    {
        $question = $this->questionDAO->getById($id);

        if ($question === null) {
            throw new InvalidArgumentException("Question with Id {$id} not found");
        }
        return $question;
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
        $quiz = $this->quizService->getQuizById($quizId);

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