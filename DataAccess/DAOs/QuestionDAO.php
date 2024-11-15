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
     * Le contructeur initialise la connection avec la classe fournisseur
     */
    public function __construct()
    {
        $this->connection = DbConnectionProvider::getConnection();
        $this->quizDAO = new QuizDAO();
    }

    public function getQuizDAO(): QuizDAO
    {
        return $this->quizDAO;
    }

    public function setQuizDAO(QuizDAO $quizDAO): void
    {
        $this->quizDAO = $quizDAO;
    }

    /**
     * @param int $id
     * @return Question|null
     * La méthode pour obtenir une question par son identifiant
     * Elle retourne null si l'identifiant passé en paramètre n'existe pas dans la table
     */
    public function getById(int $id): ?Question
    {
        $query = "SELECT * FROM $this->tableName WHERE Id = :id ;";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result){
            $quiz = $this->quizDAO->getById((int)$result[0]['QuizId']); // ?? new Quiz("",""); Double Check
            return new Question(
                $result['QuestionText'],
                $result['CorrectAnswer'],
                $result['WrongAnswer1'],
                $result['WrongAnswer2'],
                $result['WrongAnswer3'],
                $quiz,
                $result['ImageUrl'],
                (int)$result['Id']);
        }

        return null;
    }

    /**
     * @return ListQuestion
     * La méthode qui retourne tous les tuples de la table 'questions'
     */
    public function getAll(): ListQuestion
    {
        $query = "SELECT * FROM $this->tableName ;";
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
                $question['ImageUrl'],
                (int)$question['Id'],
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
        $query = "INSERT INTO $this->tableName (QuestionText, CorrectAnswer, WrongAnswer1, " .
            "WrongAnswer2, WrongAnswer3, QuizId, ImageUrl) VALUES " .
            "(:questionText, :correctAnswer, :wrongAnswer1, :wrongAnswer2, :wrongAnswer3, :quizId, :imageUrl) ;";

        $statement = $this->connection->prepare($query);
        $statement->bindValue(":questionText", $question->getQuestionText());
        $statement->bindValue(":correctAnswer", $question->getCorrectAnswer());
        $statement->bindValue(":wrongAnswer1", $question->getWrongAnswer1());
        $statement->bindValue(":wrongAnswer2", $question->getWrongAnswer2());
        $statement->bindValue(":wrongAnswer3", $question->getWrongAnswer3());
        $statement->bindValue(":quizId", $question->getQuiz()->getId());
        $statement->bindValue(":imageUrl", $question->getImageUrl());

        $statement->execute();

        $createdId = (int)$this->connection->lastInsertId();
        return $this->getById($createdId);
    }

    /**
     * @param Question $question
     * @return Question
     * @throws Exception
     * La méthode pour mettre à une question
     */
    public function update(Question $question): Question
    {
        $query = "UPDATE $this->tableName SET QuestionText = :questionText, " .
        "CorrectAnswer = :correctAnswer, WrongAnswer1 = :wrongAnswer1, " .
        "WrongAnswer2 = :wrongAnswer2, WrongAnswer3 = :wrongAnswer3, " .
        "QuizId = :quizId, ImageUrl = :imageUrl WHERE Id = :id ;";

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
        $query = "DELETE FROM $this->tableName WHERE Id = :id ;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":id", $question->getId());
        $statement->execute();

        if ($statement->rowCount()=== 0) {
            throw new Exception("Unable to delete question with id {$question->getId()}. No rows deleted !");
        }
    }

    /**
     * @param Quiz $quiz
     * @return ListQuestion
     * La méthode qui retourne les questions en fonction d'un quiz
     */
    public function filterByQuiz(Quiz $quiz): ListQuestion
    {
        $query = "SELECT * FROM $this->tableName WHERE QuizId = :quizId ;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":quizId", $quiz->getId());
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $id => $question) {
            $quiz->getQuestions()->addQuestion(
                new Question(
                    $question['QuestionText'],
                    $question['CorrectAnswer'],
                    $question['WrongAnswer1'],
                    $question['WrongAnswer2'],
                    $question['WrongAnswer3'],
                    $quiz,
                    $question['ImageUrl'],
                    (int)$question['Id'],
                )
            );
        }
        return $quiz->getQuestions();
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