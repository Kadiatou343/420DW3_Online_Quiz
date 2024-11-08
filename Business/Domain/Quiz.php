<?php
declare(strict_types=1);

namespace Business\Domain;

use DateTime;

/**
 * Classe représentant un quiz
 */
class Quiz
{
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
     * Constructeur orienté coté code (celui qui ne prend pas en compte les paramètres optionnels)
     * Constructeur orienté coté base de données (celui qui prend en compte tous les paramètres)
     * @param string $title
     * @param string $description
     * @param int|null $id
     * @param DateTime|null $dateCreated
     */
    public function __construct(string $title, string $description, int $id = null, DateTime $dateCreated = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->id = $id;
        $this->dateCreated = $dateCreated;
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

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
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

    /**
     * @return string
     * Override de __toString pour afficher les informations du quiz
     */
    public function __toString(): string
    {
        return "Titre : $this->title, Description : $this->description, Date Created : $this->dateCreated";
    }


}