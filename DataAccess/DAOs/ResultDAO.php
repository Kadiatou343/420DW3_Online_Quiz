<?php
declare(strict_types=1);

namespace DataAccess\DAOs;

use Business\Domain\Quiz;
use Business\Domain\Result;
use Business\Domain\User;
use Business\Services\QuizService;
use Business\Services\UserService;
use DataAccess\DbConnectionProvider;
use Exception;
use PDO;
use ProjectUtilities\DateTimeFromString;
use ProjectUtilities\ListResult;

/**
 * Classe représentant les interactions entre l'entité 'Result' et la table 'results' dans la base de données
 */
class ResultDAO
{
    /**
     * @var PDO
     * La connexion qui va être utilisé par le DAO
     */
    private PDO $connection;
    /**
     * @var string
     * Le nom de la table dans la base de données que le DAO va utiliser
     */
    private string $tableName = 'results';
    /**
     * @var QuizService
     * Le DAO du quiz qui va permettre de chercher le quiz auquel le résultat est liée
     */
    private QuizService $quizService;
    /**
     * @var UserService
     * Le DAO du l'utilisateur qui va permettre de chercher l'utilisateur auquel le résultat est liée
     */
    private UserService $userService;

    /**
     * Le contructeur initiale la connection avec la classe fournisseur
     * Il initialise les DAOs dont il aura besoin
     */
    public function __construct()
    {
        $this->connection = DbConnectionProvider::getConnection();
        $this->quizService = new QuizService();
        $this->userService = new UserService();
    }


    /**
     * @param int $id
     * @return Result|null
     * La méthode pour obtenir un utilisateur par son identifiant
     * Elle retourne null si l'identifiant passé en paramètre n'existe pas dans la table
     */
    public function getById(int $id): ?Result
    {
        $query = "SELECT * FROM $this->tableName WHERE id = :id ;";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        if ($result) {
            $quiz = $this->quizService->getQuizById((int)$result['QuizId']);
            $user = $this->userService->getUserById((int)$result['UserId']);
            return new Result(
                $result['Score'],
                $quiz,
                $user,
                (int)$result['Id'],
                DateTimeFromString::createDateTimeFromString($result['Date'])
            );
        }

        return null;
    }

    /**
     * @return ListResult
     * La méthode qui retourne tous les tuples de la table 'results'
     */
    public function getAll(): ListResult
    {
        $query = "SELECT * FROM $this->tableName ;";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $queryResults = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $results = new ListResult();

        foreach ($queryResults as $id => $result) {
            $quiz = $this->quizService->getQuizById((int)$result['QuizId']);
            $user = $this->userService->getUserById((int)$result['UserId']);
            $results->addResult(new Result(
                $result['Score'],
                $quiz,
                $user,
                (int)$result['Id'],
                DateTimeFromString::createDateTimeFromString($result['Date'])
            ));
        }

        return $results;
    }

    /**
     * @param Result $result
     * @return Result
     * La méthode pour insérer un nouveau résultat
     */
    public function create(Result $result): Result
    {
        $query = "INSERT INTO $this->tableName (UserId, QuizId, Score) VALUES (:userId, :quizId, :score) ;";
        $statement = $this->connection->prepare($query);

        $statement->bindValue(":userId", $result->getUser()->getId());
        $statement->bindValue(":quizId", $result->getQuiz()->getId());
        $statement->bindValue(":score", $result->getScore());
        $statement->execute();
        $statement->closeCursor();

        $createdId = (int)$this->connection->lastInsertId();
        return $this->getById($createdId);
    }

    /**
     * @param Result $result
     * @return Result
     * @throws Exception
     * La méthode pour mettre à jour un résultat
     */
    public function update(Result $result): Result
    {
        $query = "UPDATE $this->tableName SET UserId = :userId, QuizId = :quizId, Score = :score WHERE Id = :id ;";
        $statement = $this->connection->prepare($query);

        $statement->bindValue(":userId", $result->getUser()->getId());
        $statement->bindValue(":quizId", $result->getQuiz()->getId());
        $statement->bindValue(":score", $result->getScore());
        $statement->bindValue(":id", $result->getId());
        $statement->execute();

        if ($statement->rowCount() === 0) {
            throw new Exception("Unable to update result with id {$result->getId()}. No rows modified !");
        }
        $statement->closeCursor();
        return $this->getById($result->getId());
    }

    /**
     * @param Result $result
     * @return void
     * @throws Exception
     * La méthode pour supprimer un résultat
     */
    public function delete(Result $result): void
    {
        $query = "DELETE FROM $this->tableName WHERE Id = :id ;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":id", $result->getId());
        $statement->execute();

        if ($statement->rowCount() === 0) {
            throw new Exception("Unable to delete result with id {$result->getId()}. No rows deleted !");
        }
        $statement->closeCursor();
    }

    /**
     * @param Quiz $quiz
     * @return ListResult
     * La méthode qui retourne les résultats en fonction d'un quiz
     */
    public function filterByQuiz(Quiz $quiz): ListResult
    {
        $query = "SELECT * FROM $this->tableName WHERE QuizId = :quizId ;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":quizId", $quiz->getId());
        $statement->execute();
        $queryResults = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        foreach ($queryResults as $id => $result) {
            $quiz->getResults()->addResult(
                new Result(
                    $result['Score'],
                    $quiz,
                    $this->userService->getUserById((int)$result['UserId']),
                    (int)$result['Id'],
                    DateTimeFromString::createDateTimeFromString($result['Date'])
                )
            );
        }

        return $quiz->getResults();
    }

    /**
     * @param User $user
     * @return ListResult
     * La méthode qui retourne les résultats en fonction d'un utilisateur
     */
    public function filterByUser(User $user): ListResult
    {
        $query = "SELECT * FROM $this->tableName WHERE UserId = :userId ;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":userId", $user->getId());
        $statement->execute();
        $queryResults = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        foreach ($queryResults as $id => $result) {
            $user->getResults()->addResult(
                new Result(
                    $result['Score'],
                    $this->quizService->getQuizById((int)$result['QuizId']),
                    $user,
                    (int)$result['Id'],
                    DateTimeFromString::createDateTimeFromString($result['Date'])
                )
            );
        }

        return $user->getResults();
    }

    /**
     * Desctructeur du DAO.
     * La méthode ferme la connexion
     */
    public function __destruct()
    {
        unset($this->connection);
    }
}