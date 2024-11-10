<?php
declare(strict_types=1);

namespace DataAccess\DAOs;

use Business\Domain\Question;
use Business\Domain\Quiz;
use DataAccess\DbConnectionProvider;
use Exception;
use PDO;
use ProjectUtilities\ListQuestion;

/**
 * Classe représentant les interactions entre l'entité 'Question' et la table 'questions' dans la base de données
 */
class QuestionDAO
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
    private string $tableName = "questions";
    /**
     * @var QuizDAO
     * Le DAO du quiz qui va permettre de chercher le quiz auquel la question est liée
     */
    private QuizDAO $quizDAO;

    /**
     * Le contructeur initiale la connection avec la classe fournisseur
     */
    public function __construct()
    {
        $this->connection = DbConnectionProvider::getConnection();
        $this->quizDAO = new QuizDAO();
    }

    /**
     * @param int $id
     * @return Question|null
     * La méthode pour obtenir une question par son identifiant
     * Elle retourne null si l'identifiant passé en paramètre n'existe pas dans la table
     */
    public function getById(int $id): ?Question
    {
        $query = "SELECT * FROM {$this->tableName} WHERE Id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result){
            $quiz = $this->quizDAO->getById((int)$result[0]['QuizId']); // ?? new Quiz("",""); Double Check
            return new Question(
                $result[0]['QuestionText'],
                $result[0]['CorrectAnswer'],
                $result[0]['WrongAnswer1'],
                $result[0]['WrongAnswer2'],
                $result[0]['WrongAnswer3'],
                $quiz,
                $result[0]['Id'],
                $result[0]['ImageUrl']);
        }

        return null;
    }

    /**
     * @return ListQuestion
     * La méthode qui retourne tous les tuples de la table 'questions'
     */
    public function getAll(): ListQuestion
    {
        $query = "SELECT * FROM {$this->tableName};";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $questions = new ListQuestion();

        foreach ($results as $id => $question) {
            $quiz = $this->quizDAO->getById((int)$question['QuizId']);
            $questions->addQuestion(new Question(
                $question['QuestionText'],
                $question['CorrectAnswer'],
                $question['WrongAnswer1'],
                $question['WrongAnswer2'],
                $question['WrongAnswer3'],
                $quiz,
                (int)$question['Id'],
                $question['ImageUrl'],
            ));
        }
        return $questions;
    }

    /**
     * @param Question $question
     * @return Question
     * La méthode pour insérer une nouvelle question
     */
    public function create(Question $question): Question
    {
        $query = "INSERT INTO {$this->tableName} (QuestionText, CorrectAnswer, WrongAnswer1, " .
            "WrongAnswer2, WrongAnswer3, QuizId, ImageUrl) VALUES " .
            "(:questionText, :correctAnswer, :wrongAnswer1, :wrongAnswer2, :wrongAnswer3, :quizId, :imageUrl);";

        $statement = $this->connection->prepare($query);
        $statement->bindValue(":questionText", $question->getQuestionText());
        $statement->bindValue(":correctAnswer", $question->getCorrectAnswer());
        $statement->bindValue(":wrongAnswer1", $question->getWrongAnswer1());
        $statement->bindValue(":wrongAnswer2", $question->getWrongAnswer2());
        $statement->bindValue(":wrongAnswer3", $question->getWrongAnswer3());
        $statement->bindValue(":quizId", $question->getQuiz()->getId());
        $statement->bindValue(":imageUrl", $question->getImageUrl());

        $statement->execute();

        $questionId = (int)$this->connection->lastInsertId();
        return $this->getById($questionId);
    }

    /**
     * @param Question $question
     * @return Question
     * @throws Exception
     * La méthode pour mettre à une question
     */
    public function update(Question $question): Question
    {
        $query = "UPDATE {$this->tableName} SET QuestionText = :questionText, " .
        "CorrectAnswer = :correctAnswer, WrongAnswer1 = :wrongAnswer1, " .
        "WrongAnswer2 = :wrongAnswer2, WrongAnswer3 = :wrongAnswer3, " .
        "QuizId = :quizId, ImageUrl = :imageUrl WHERE Id = :id;";

        $statement = $this->connection->prepare($query);
        $statement->bindValue(":questionText", $question->getQuestionText());
        $statement->bindValue(":correctAnswer", $question->getCorrectAnswer());
        $statement->bindValue(":wrongAnswer1", $question->getWrongAnswer1());
        $statement->bindValue(":wrongAnswer2", $question->getWrongAnswer2());
        $statement->bindValue(":wrongAnswer3", $question->getWrongAnswer3());
        $statement->bindValue(":quizId", $question->getQuiz()->getId());
        $statement->bindValue(":imageUrl", $question->getImageUrl());
        $statement->bindValue(":id", $question->getId());
        $statement->execute();

        if ($statement->rowCount()=== 0) {
            throw new Exception("Unable to update question with id {$question->getId()}. No rows modified !");
        }

        return $this->getById($question->getId());
    }

    /**
     * @param Question $question
     * @return void
     * @throws Exception
     * La méthode pour supprimer une question
     */
    public function delete(Question $question): void
    {
        $query = "DELETE FROM {$this->tableName} WHERE Id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":id", $question->getId());
        $statement->execute();

        if ($statement->rowCount()=== 0) {
            throw new Exception("Unable to delete question with id {$question->getId()}. No rows deleted !");
        }
    }
}