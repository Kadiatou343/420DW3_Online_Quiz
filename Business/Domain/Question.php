<?php
declare(strict_types=1);

namespace Business\Domain;

use ProjectUtilities\ArgumentOutOfRangeException;

/**
 * Classe représentant une question
 */
class Question
{
    public const QUESTION_CORRECT_ANSWER_MAX_LENGTH = 256;
    public const QUESTION_WRONG_ANSWER_MAX_LENGTH = 256;
    public const QUESTION_IMAGE_URL_MAX_LENGTH = 256;
    /**
     * @var int
     * L'identifiant de la question
     */
    private int $id;
    /**
     * @var string
     * Le texte qui représente la question elle-meme
     */
    private string $questionText;
    /**
     * @var string
     * La bonne reponse de la question
     */
    private string $correctAnswer;
    /**
     * @var string
     * La première mauvaise réponse de la question
     */
    private string $wrongAnswer1;
    /**
     * @var string
     * La deuxième mauvaise réponse de la question
     */
    private string $wrongAnswer2;
    /**
     * @var string
     * La troisième mauvaise réponse de la question
     */
    private string $wrongAnswer3;
    /**
     * @var Quiz
     * Le quiz auquel appartient la question
     */
    private Quiz $quiz;
    /**
     * @var string
     * L'url de l'image de la question
     */
    private string $imageUrl;

    /**
     * Constructeur orienté coté code (celui qui ne prend pas en compte les paramètres optionnels)
     * Constructeur orienté coté base de données (celui qui prend en compte tous les paramètres)
     * @param string $questionText
     * @param string $correctAnswer
     * @param string $wrongAnswer1
     * @param string $wrongAnswer2
     * @param string $wrongAnswer3
     * @param Quiz $quiz
     * @param int|null $id
     * @param string|null $imageUrl
     */
    public function __construct(string $questionText, string $correctAnswer, string $wrongAnswer1, string $wrongAnswer2, string $wrongAnswer3, Quiz $quiz, ?int $id = null, ?string $imageUrl = null)
    {
        $this->questionText = $questionText;
        $this->correctAnswer = $correctAnswer;
        $this->wrongAnswer1 = $wrongAnswer1;
        $this->wrongAnswer2 = $wrongAnswer2;
        $this->wrongAnswer3 = $wrongAnswer3;
        $this->quiz = $quiz;
        $this->id = $id ?? 0;
        $this->imageUrl = $imageUrl ?? '';
    }

    /**
     * Les accesseurs et les mutateurs
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getQuestionText(): string
    {
        return $this->questionText;
    }

    public function setQuestionText(string $questionText): void
    {
        $this->questionText = $questionText;
    }

    public function getCorrectAnswer(): string
    {
        return $this->correctAnswer;
    }

    /**
     * @throws ArgumentOutOfRangeException
     */
    public function setCorrectAnswer(string $correctAnswer): void
    {
        if (!$this->validateCorrectAnswer($correctAnswer)) {
            throw new ArgumentOutOfRangeException("La taille de la bonne réponse devrait être inférieure à " . self::QUESTION_CORRECT_ANSWER_MAX_LENGTH . " !");
        }
        $this->correctAnswer = $correctAnswer;
    }

    public function getWrongAnswer1(): string
    {
        return $this->wrongAnswer1;
    }

    /**
     * @throws ArgumentOutOfRangeException
     */
    public function setWrongAnswer1(string $wrongAnswer1): void
    {
        if (!$this->validateWrongAnswer($wrongAnswer1)) {
            throw new ArgumentOutOfRangeException("La taille des mauvaises réponse devrait être inférieure à " . self::QUESTION_WRONG_ANSWER_MAX_LENGTH . " !");
        }
        $this->wrongAnswer1 = $wrongAnswer1;
    }

    public function getWrongAnswer2(): string
    {
        return $this->wrongAnswer2;
    }

    /**
     * @throws ArgumentOutOfRangeException
     */
    public function setWrongAnswer2(string $wrongAnswer2): void
    {
        if (!$this->validateWrongAnswer($wrongAnswer2)) {
            throw new ArgumentOutOfRangeException("La taille des mauvaises réponse devrait être inférieure à " . self::QUESTION_WRONG_ANSWER_MAX_LENGTH . " !");
        }
        $this->wrongAnswer2 = $wrongAnswer2;
    }

    public function getWrongAnswer3(): string
    {
        return $this->wrongAnswer3;
    }

    /**
     * @throws ArgumentOutOfRangeException
     */
    public function setWrongAnswer3(string $wrongAnswer3): void
    {
        if (!$this->validateWrongAnswer($wrongAnswer3)) {
            throw new ArgumentOutOfRangeException("La taille des mauvaises réponse devrait être inférieure à " . self::QUESTION_WRONG_ANSWER_MAX_LENGTH . " !");
        }
        $this->wrongAnswer3 = $wrongAnswer3;
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(Quiz $quiz): void
    {
        $this->quiz = $quiz;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @throws ArgumentOutOfRangeException
     */
    public function setImageUrl(string $imageUrl): void
    {
        if (!$this->validateImageUrl($imageUrl)) {
            throw new ArgumentOutOfRangeException("La taille de l'url devrait être inférieure à " . self::QUESTION_IMAGE_URL_MAX_LENGTH . " !");
        }
        $this->imageUrl = $imageUrl;
    }

    /**
     * @param $correctAnswer
     * @return bool
     * La méthode pour valider la taille de la bonne réponse
     */
    public function validateCorrectAnswer($correctAnswer): bool
    {
        return mb_strlen($correctAnswer, "UTF-8") <= self::QUESTION_CORRECT_ANSWER_MAX_LENGTH;
    }

    /**
     * @param $wrongAnswer
     * @return bool
     * La méthode pour valider la taille des mauvaises réponses
     */
    public function validateWrongAnswer($wrongAnswer): bool{
        return mb_strlen($wrongAnswer, "UTF-8") <= self::QUESTION_WRONG_ANSWER_MAX_LENGTH;
    }

    /**
     * @param string $imageUrl
     * @return bool
     * La méthode pour valider la taille de l'url de l'image
     */
    public function validateImageUrl(string $imageUrl): bool
    {
        return mb_strlen($imageUrl, "UTF-8") <= self::QUESTION_IMAGE_URL_MAX_LENGTH;
    }

    /**
     * @return string
     * Override de __toString pour afficher les informations de la question
     */
    public function __toString(): string
    {
        return "Question: $this->questionText - Bonne reponse : $this->correctAnswer - " .
        "Mauvaises réponses : $this->wrongAnswer1, $this->wrongAnswer2, $this->wrongAnswer3";
    }


}