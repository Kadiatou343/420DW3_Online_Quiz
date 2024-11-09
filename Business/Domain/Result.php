<?php
declare(strict_types=1);

namespace Business\Domain;

use DateTime;

/**
 * Classe représentant un résultat
 */
class Result
{
    /**
     * @var int
     * L'identifiant du résulat
     */
    private int $id;
    /**
     * @var int
     * Le score du résultat
     */
    private int $score;
    /**
     * @var DateTime
     * La date à laquelle le résultat a été produit
     */
    private DateTime $dateCreated;
    /**
     * @var Quiz
     * Le quiz auquel lequel le résultat appartient
     */
    private Quiz $quiz;
    /**
     * @var User
     * L'utilisateur auquel le résultat appartient
     */
    private User $user;

    /**
     * Constructeur orienté coté code (celui qui ne prend pas en compte les paramètres optionnels)
     * Constructeur orienté coté base de données (celui qui prend en compte tous les paramètres)
     * @param int $score
     * @param Quiz $quiz
     * @param User $user
     * @param int|null $id
     * @param DateTime|null $dateCreated
     */
    public function __construct(int $score, Quiz $quiz, User $user, int $id = null, ?DateTime $dateCreated = null)
    {
        $this->score = $score;
        $this->quiz = $quiz;
        $this->user = $user;
        $this->id = $id ?? 0;
        $this->dateCreated = $dateCreated ?? new DateTime();
    }

    /**
     * Les accesseurs et mutateurs
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(Quiz $quiz): void
    {
        $this->quiz = $quiz;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     * Override de __toString pour afficher les informations du résulat
     */
    public function __toString(): string
    {
        return "Id : $this->id - Score : $this->score";
    }


}