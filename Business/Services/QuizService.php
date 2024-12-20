<?php
declare(strict_types=1);

namespace Business\Services;

use Business\Domain\Quiz;
use DataAccess\DAOs\QuizDAO;
use Exception;
use InvalidArgumentException;
use ProjectUtilities\ListQuiz;

/**
 * Classe représentant le controller du quiz
 */
class QuizService
{
    /**
     * @var ?QuizDAO
     * Le DAO du quiz
     */
    private ?QuizDAO $quizDAO;

    /**
     * Le constructeur initialise le DAO
     */
    public function __construct()
    {
        $this->quizDAO = new QuizDAO();
    }

    /**
     * @param Quiz $quiz
     * @return Quiz
     * Création d'un quiz
     */
    public function createQuiz(Quiz $quiz): Quiz
    {
        return $this->quizDAO->create($quiz);
    }

    /**
     * @param int $id
     * @return Quiz
     * @throws InvalidArgumentException
     * Obtenir un quiz par son identifiant
     */
    public function getQuizById(int $id): Quiz
    {
        $quiz = $this->quizDAO->getById($id);
        try {
            if ($quiz == null) {
                throw new InvalidArgumentException("Quiz with Id {$id} not found");
            }
        } catch (InvalidArgumentException $e) {
            $error = $e->getMessage();
        }
        return $quiz;
    }

    /**
     * @return ListQuiz
     * Obtenir tous les quiz
     */
    public function getAllQuizzes(): ListQuiz
    {
        return $this->quizDAO->getAll();
    }

    /**
     * @param Quiz $quiz
     * @return Quiz
     * @throws Exception
     * Mettre à jour un quiz
     */
    public function updateQuiz(Quiz $quiz): Quiz
    {
        return $this->quizDAO->update($quiz);
    }

    /**
     * @param Quiz $quiz
     * @return void
     * @throws Exception
     * Supprimer un utilisateur
     */
    public function deleteQuiz(Quiz $quiz): void
    {
        $this->quizDAO->delete($quiz);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return ListQuiz
     * Obtenir les enregistrements de quiz selon une limite et un point de départ
     */
    public function getQuizzesByLimitAndOffset(int $limit, int $offset): ListQuiz
    {
        return $this->quizDAO->getByLimitAndOffset($limit, $offset);
    }

    /**
     * @return int
     * Obtenir le nombre d'enregistrement de la table De Quiz
     */
    public function getQuizzesCount(): int
    {
        return $this->quizDAO->getCount();
    }

    /**
     * @param string $string
     * @return ListQuiz
     * Rechercher des quiz à partir d'une chaine de caractères
     */
    public function searchQuizByString(string $string): ListQuiz
    {
        return $this->quizDAO->searchByString($string);
    }

    /**
     * Desctructeur du service
     */
    public function __destruct()
    {
        $this->quizDAO = null;
    }
}