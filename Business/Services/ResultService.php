<?php
declare(strict_types=1);

namespace Business\Services;

use Business\Domain\Quiz;
use Business\Domain\Result;
use Business\Domain\User;
use DataAccess\DAOs\ResultDAO;
use Exception;
use InvalidArgumentException;
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
    private UserService $userService;
    private QuizService $quizService;

    /**
     * Le constructeur initialise le DAO
     */
    public function __construct()
    {
        $this->resultDAO = new ResultDAO();
        $this->userService = new UserService();
        $this->quizService = new QuizService();
    }

    /**
     * @param Result $result
     * @return Result
     * Créer un résultat
     */
    public function createResult(Result $result): Result
    {
        return $this->resultDAO->create($result);
    }

    /**
     * @param int $id
     * @return Result
     * @throws InvalidArgumentException
     * Obtenir un résultat par son identifiant
     */
    public function getResultById(int $id): Result
    {
        $result = $this->resultDAO->getById($id);

        try {
            if ($result === null) {
                throw new InvalidArgumentException("Result with Id {$id} not found");
            }
        } catch (InvalidArgumentException $e) {
            $error = $e->getMessage();
        }
        return $result;
    }

    /**
     * @return ListResult
     * Obtenir tous les résultats
     */
    public function getAllResults(): ListResult
    {
        return $this->resultDAO->getAll();
    }

    /**
     * @param Result $result
     * @return Result
     * @throws Exception
     * Mettre à jour un résultat
     */
    public function updateResult(Result $result): Result
    {
        return $this->resultDAO->update($result);
    }

    /**
     * @param Result $result
     * @return void
     * @throws Exception
     * Supprimer un résultat
     */
    public function deleteResult(Result $result): void
    {
        $this->resultDAO->delete($result);
    }

    /**
     * @param int $quizId
     * @return ListResult
     * Retourne les resultats à partir de l'id d'un quiz
     */
    public function filterResultsByQuizId(int $quizId): ListResult
    {
        $quiz = $this->quizService->getQuizById($quizId);
        return $this->resultDAO->filterByQuiz($quiz);
    }

    /**
     * @param int $userId
     * @return ListResult
     * Retourne les résultats à partir de l'id d'un utilisateur
     */
    public function filterResultsByUserId(int $userId): ListResult
    {
        $user = $this->userService->getUserById($userId);
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