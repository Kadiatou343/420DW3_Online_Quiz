<?php
declare(strict_types=1);

namespace Business\Domain;

/**
 * Classe représentant une question
 */
class Question
{
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
    public function __construct(string $questionText, string $correctAnswer, string $wrongAnswer1, string $wrongAnswer2, string $wrongAnswer3, Quiz $quiz, int $id = null, string $imageUrl = null)
    {
        $this->questionText = $questionText;
        $this->correctAnswer = $correctAnswer;
        $this->wrongAnswer1 = $wrongAnswer1;
        $this->wrongAnswer2 = $wrongAnswer2;
        $this->wrongAnswer3 = $wrongAnswer3;
        $this->quiz = $quiz;
        $this->id = $id;
        $this->imageUrl = $imageUrl;
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

    public function setCorrectAnswer(string $correctAnswer): void
    {
        $this->correctAnswer = $correctAnswer;
    }

    public function getWrongAnswer1(): string
    {
        return $this->wrongAnswer1;
    }

    public function setWrongAnswer1(string $wrongAnswer1): void
    {
        $this->wrongAnswer1 = $wrongAnswer1;
    }

    public function getWrongAnswer2(): string
    {
        return $this->wrongAnswer2;
    }

    public function setWrongAnswer2(string $wrongAnswer2): void
    {
        $this->wrongAnswer2 = $wrongAnswer2;
    }

    public function getWrongAnswer3(): string
    {
        return $this->wrongAnswer3;
    }

    public function setWrongAnswer3(string $wrongAnswer3): void
    {
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

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
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