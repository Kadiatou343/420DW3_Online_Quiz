<?php
declare(strict_types=1);

namespace Business\Domain;

use DateTime;
use ProjectUtilities\ListResult;
use ProjectUtilities\UserRole;

/**
 * Classe représentant un utilisateur
 */
class User
{
    /**
     * @var int
     * L'identifiant de l'utilisateur
     */
    private int $id;
    /**
     * @var string
     * Le nom de famille de l'utilisateur
     */
    private string $lastName;
    /**
     * @var string
     * Le prénom de l'utilisateur
     */
    private string $firstName;
    /**
     * @var string
     * L'email de l'utilisateur
     */
    private string $email;
    /**
     * @var string
     * Le hash du mot de passe de l'utilisateur
     */
    private string $passwordHash;
    /**
     * @var UserRole
     * Le role de l'utilisateur
     */
    private UserRole $role;
    /**
     * @var DateTime
     * La date de création de l'utilisateur
     */
    private DateTime $registrationDate;
    /**
     * @var ListResult
     * Les résultats associés à l'utilisateur
     */
    private ListResult $results;

    /**
     * Constructeur orienté coté code (celui qui ne prend pas en compte les paramètres optionnels)
     * Constructeur orienté coté base de données (celui qui prend en compte tous les paramètres)
     * @param string $lastName
     * @param string $firstName
     * @param string $email
     * @param UserRole $role
     * @param int|null $id
     * @param DateTime|null $registrationDate
     */
    public function __construct(string $lastName, string $firstName, string $email, UserRole $role, ?int $id = null, ?DateTime $registrationDate = null)
    {
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->role = $role;
        $this->id = $id ?? 0;
        $this->registrationDate = $registrationDate ?? new DateTime();
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

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }

    public function setRole(UserRole $role): void
    {
        $this->role = $role;
    }

    public function getRegistrationDate(): DateTime
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * @return string
     * Override de __toString pour afficher les informations d'un utilisateur
     */
    public function __toString(): string
    {
        return "Id : $this->id - Nom : $this->lastName - Prenom : $this->firstName - Email : $this->email";
    }


}