<?php
declare(strict_types=1);

namespace Business\Services;

use Business\Domain\Quiz;
use Business\Domain\Result;
use Business\Domain\User;
use DataAccess\DAOs\ResultDAO;
use Exception;
use ProjectUtilities\ListResult;

/**
 * Classe représentant le controller d'un résultat
 */
class ResultService
{
    /**
     * @var ?ResultDAO
     * Le DAO du résultat
     */
    private ?ResultDAO $resultDAO;

    /**
     * Le constructeur initialise le DAO
     */
    public function __construct()
    {
        $this->resultDAO = new ResultDAO();
    }

    /**
     * @param int $score
     * @param User $user
     * @param Quiz $quiz
     * @return Result
     * Créer un résultat
     */
    public function createResult(int $score, User $user, Quiz $quiz) : Result
    {
        $result = new Result($score, $quiz, $user);
        return $this->resultDAO->create($result);
    }

    /**
     * @param int $id
     * @return Result
     * Obtenir un résultat par son identifiant
     */
    public function getResultById(int $id) : Result
    {
        return $this->resultDAO->getById($id);
    }

    /**
     * @return ListResult
     * Obtenir tous les résultats
     */
    public function getAllResults() : ListResult
    {
        return $this->resultDAO->getAll();
    }

    /**
     * @param Result $result
     * @return Result
     * @throws Exception
     * Mettre à jour un résultat
     */
    public function updateResult(Result $result) : Result
    {
        return $this->resultDAO->update($result);
    }

    /**
     * @param Result $result
     * @return void
     * @throws Exception
     * Supprimer un résultat
     */
    public function deleteResult(Result $result) : void
    {
        $this->resultDAO->delete($result);
    }

    /**
     * @param int $quizId
     * @return ListResult
     * Retourne les resultats à partir de l'id d'un quiz
     */
    public function filterResultsByQuizId(int $quizId) : ListResult
    {
        $quiz = $this->resultDAO->getQuizDAO()->getById($quizId);
        return $this->resultDAO->filterByQuiz($quiz);
    }

    /**
     * @param int $userId
     * @return ListResult
     * Retourne les résultats à partir de l'id d'un utilisateur
     */
    public function filterResultsByUserId(int $userId) : ListResult
    {
        $user = $this->resultDAO->getUserDAO()->getById($userId);
        return $this->resultDAO->filterByUser($user);
    }

    /**
     * Desctructeur du service
     */
    public function __destruct()
    {
        $this->resultDAO = null;
    }


}