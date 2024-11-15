<?php
declare(strict_types=1);

namespace DataAccess\DAOs;

use Business\Domain\Quiz;
use DataAccess\DbConnectionProvider;
use Exception;
use PDO;
use ProjectUtilities\DateTimeFromString;
use ProjectUtilities\ListQuiz;

/**
 * Classe représentant les interactions entre l'entité 'Quiz' et la table 'quizzes' dans la base de données
 */
class QuizDAO
{
    /**
     * @var PDO
     * La connexion qui va êttre utilisée par le DAO
     */
    private PDO $connection;
    /**
     * @var string
     * Le nom de la table dans la base de données que le DAO va utiliser
     */
    private string $tableName = 'quizzes';

    /**
     * Le contructeur initiale la connection avec la classe fournisseur
     */
    public function __construct()
    {
        $this->connection = DbConnectionProvider::getConnection();
    }

    /**
     * @param int $id
     * @return Quiz|null
     * La méthode pour obtenir un quiz par son identifiant
     * Elle retourne null si l'identifiant passé en paramètre n'existe pas dans la table
     */
    public function getById(int $id): ?Quiz
    {
        $query = "SELECT * FROM $this->tableName WHERE Id = :id ;";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Quiz(
                $result['Title'],
                $result['Description'],
                $result['Id'],
                DateTimeFromString::createDateTimeFromString($result['DateCreated'])
            );
        }
        return null;
    }

    /**
     * @return ListQuiz
     * La méthode qui retourne tous les tuples de la table 'quizzes'
     */
    public function getAll(): ListQuiz
    {
        $query = "SELECT * FROM $this->tableName ;";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $quizzes = new ListQuiz();
        foreach ($results as $id => $quiz) {
            $quizzes->addQuiz(new Quiz(
                $quiz['Title'],
                $quiz['Description'],
                (int)$quiz['Id'],
                DateTimeFromString::createDateTimeFromString($quiz['DateCreated'])));
        }
        return $quizzes;
    }

    /**
     * @param Quiz $quiz
     * @return Quiz
     * La méthode pour inséser un nouveau quiz
     */
    public function create(Quiz $quiz): Quiz
    {
        $query = "INSERT INTO $this->tableName (Title, Description) VALUES (:title, :description) ;)";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":title", $quiz->getTitle());
        $statement->bindValue(":description", $quiz->getDescription());
        $statement->execute();
        $createdId = (int)$this->connection->lastInsertId();

        return $this->getById($createdId);
    }

    /**
     * @param Quiz $quiz
     * @return Quiz
     * @throws Exception
     * La méthode pour mettre à jour un quiz
     */
    public function update(Quiz $quiz): Quiz
    {
        $query = "UPDATE $this->tableName SET Title = :title, Description = :description WHERE Id = :id ;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":title", $quiz->getTitle());
        $statement->bindValue(":description", $quiz->getDescription());
        $statement->bindValue(":id", $quiz->getId());
        $statement->execute();

        if ($statement->rowCount() === 0) {
            throw new Exception("Unable to update quiz with id {$quiz->getId()}. No rows modified !");
        }
        return $this->getById($quiz->getId());
    }

    /**
     * @param Quiz $quiz
     * @return void
     * @throws Exception
     * La méthode pour supprimer un quiz
     */
    public function delete(Quiz $quiz): void
    {
        $query = "DELETE FROM $this->tableName WHERE Id = :id ;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":id", $quiz->getId());
        $statement->execute();

        if ($statement->rowCount() === 0) {
            throw new Exception("Unable to delete quiz with id {$quiz->getId()}. No row deleted !");
        }
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return ListQuiz
     * Obtenir les tuples de quiz selon une limite et le point de départ
     */
    public function getQuizzesByLimitAndOffset(int $limit, int $offset): ListQuiz
    {
        $query = "SELECT * FROM $this->tableName LIMIT :limit OFFSET :offset ;";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(":limit", $limit);
        $statement->bindParam(":offset", $offset);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $quizzes = new ListQuiz();

        foreach ($results as $id => $quiz) {
            $quizzes->addQuiz(new Quiz(
                $quiz['Title'],
                $quiz['Description'],
                (int)$quiz['Id'],
                DateTimeFromString::createDateTimeFromString($quiz['DateCreated'])
            ));
        }
        return $quizzes;
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