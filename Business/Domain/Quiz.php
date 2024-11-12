<?php
declare(strict_types=1);

namespace Business\Domain;

use DateTime;
use ProjectUtilities\ArgumentOutOfRangeException;
use ProjectUtilities\ListQuestion;
use ProjectUtilities\ListResult;

/**
 * Classe représentant un quiz
 */
class Quiz
{
    /**
     * La longueur maximale du titre du quiz
     */
    public const QUIZ_TITLE_MAX_LENGTH = 128;
    /**
     * La longueur maximale de la description du quiz
     */
    public const QUIZ_DESCRIPTION_MAX_LENGTH = 256;

    /**
     * @var int
     * L'identifiant du quiz
     */
    private int $id;
    /**
     * @var string
     * Le titre du quiz
     */
    private string $title;
    /**
     * @var string
     * La description du quiz
     */
    private string $description;
    /**
     * @var DateTime
     * La date de création du quiz
     */
    private DateTime $dateCreated;
    /**
     * @var ListResult
     * Les résultats liés au quiz
     */
    private ListResult $results;
    /**
     * @var ListQuestion
     * Les questions liées au quiz
     */
    private ListQuestion $questions;

    /**
     * Constructeur orienté coté code (celui qui ne prend pas en compte les paramètres optionnels)
     * Constructeur orienté coté base de données (celui qui prend en compte tous les paramètres)
     * @param string $title
     * @param string $description
     * @param int|null $id
     * @param DateTime|null $dateCreated
     */
    public function __construct(string $title, string $description, ?int $id = null, ?DateTime $dateCreated = null)
    {
        $this->title = $title;
        $this->description = $description;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @throws ArgumentOutOfRangeException
     */
    public function setTitle(string $title): void
    {
        if (!$this->validateTitle($title)) {
            throw new ArgumentOutOfRangeException("La taille du titre devrait être inférieure à " . self::QUIZ_TITLE_MAX_LENGTH . " !");
        }
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @throws ArgumentOutOfRangeException
     */
    public function setDescription(string $description): void
    {
        if (!$this->validateDescription($description)) {
            throw new ArgumentOutOfRangeException("La taille de la description devrait être inférieure à " . self::QUIZ_DESCRIPTION_MAX_LENGTH . " !");
        }
        $this->description = $description;
    }

    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    public function getResults(): ListResult
    {
        return $this->results;
    }

    public function setResults(ListResult $results): void
    {
        $this->results = $results;
    }

    public function getQuestions(): ListQuestion
    {
        return $this->questions;
    }

    public function setQuestions(ListQuestion $questions): void
    {
        $this->questions = $questions;
    }

    /**
     * @param string $title
     * @return bool
     * La méthode pour valider la taille du titre
     */
    public function validateTitle(string $title): bool
    {
        return mb_strlen($title, "UTF-8") <= self::QUIZ_TITLE_MAX_LENGTH;
    }

    /**
     * @param string $description
     * @return bool
     * La méthode pour valider la taille de la description
     */
    public function validateDescription(string $description): bool
    {
        return mb_strlen($description, "UTF-8") <= self::QUIZ_DESCRIPTION_MAX_LENGTH;
    }

    /**
     * @return string
     * Override de __toString pour afficher les informations du quiz
     */
    public function __toString(): string
    {
        return "Titre : $this->title, Description : $this->description";
    }


}