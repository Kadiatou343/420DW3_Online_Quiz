<?php
declare(strict_types = 1);

namespace Business\Services;

use Business\Domain\Quiz;
use DataAccess\DAOs\QuizDAO;
use Exception;
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
    public function __construct(){
        $this->quizDAO = new QuizDAO();
    }

    /**
     * @param string $title
     * @param string $description
     * @return Quiz
     * Création d'un quiz
     */
    public function createQuiz(string $title, string $description) : Quiz
    {
        $quiz = new Quiz($title, $description);
        return $this->quizDAO->create($quiz);
    }

    /**
     * @param int $id
     * @return Quiz
     * Obtenir un quiz par son identifiant
     */
    public function getQuizById(int $id) : Quiz
    {
        return $this->quizDAO->getById($id);
    }

    /**
     * @return ListQuiz
     * Obtenir tous les quiz
     */
    public function getAllQuiz() : ListQuiz
    {
        return $this->quizDAO->getAll();
    }

    /**
     * @param Quiz $quiz
     * @return Quiz
     * @throws Exception
     * Mettre à jour un quiz
     */
    public function updateQuiz(Quiz $quiz) : Quiz
    {
        return $this->quizDAO->update($quiz);
    }

    /**
     * @param Quiz $quiz
     * @return void
     * @throws Exception
     * Supprimer un utilisateur
     */
    public function deleteQuiz(Quiz $quiz) : void
    {
        $this->quizDAO->delete($quiz);
    }

    /**
     * Desctructeur du service
     */
    public function __destruct()
    {
        $this->quizDAO = null;
    }
}