<?php
declare(strict_types=1);

namespace Business\Domain;

use DateTime;
use ProjectUtilities\ArgumentOutOfRange;
use ProjectUtilities\ListResult;
use ProjectUtilities\UserRole;

/**
 * Classe représentant un utilisateur
 */
class User
{
    /**
     * La longueur maximale du nom de famille de l'utilisateur
     */
    public const USER_LASTNAME_MAX_LENGTH = 100;
    /**
     * La longueur maximale du prénom de l'utilisateur
     */
    public const USER_FIRSTNAME_MAX_LENGTH = 100;
    /**
     * La longueur maximale du hash du mot de passe de l'utilisateur
     */
    public const USER_PASSWORD_HASH_MAX_LENGTH = 128;
    /**
     * La longueur maximale de l'email de l'utilisateur
     */
    public const USER_EMAIL_MAX_LENGTH = 128;

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

    /**
     * @throws ArgumentOutOfRange
     */
    public function setLastName(string $lastName): void
    {
        if (!$this->validateLastName($lastName)) {
            throw new ArgumentOutOfRange("La taille du nom de famille devrait être inférieure à " . self::USER_LASTNAME_MAX_LENGTH . " !");
        }
        $this->lastName = $lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @throws ArgumentOutOfRange
     */
    public function setFirstName(string $firstName): void
    {
        if (!$this->validateFirstName($firstName)) {
            throw new ArgumentOutOfRange("La taille du prénom devrait être inférieure à " . self::USER_FIRSTNAME_MAX_LENGTH . " !");
        }
        $this->firstName = $firstName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @throws ArgumentOutOfRange
     */
    public function setEmail(string $email): void
    {
        if (!$this->validateEmail($email)) {
            throw new ArgumentOutOfRange("La taille de l'email devrait être inférieure à " . self::USER_EMAIL_MAX_LENGTH . " !");
        }
        elseif (!$this->validateEmailFormat($email)) {
            throw new \InvalidArgumentException("Le format de l'email n'est pas valide !");
        }
        $this->email = $email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @throws ArgumentOutOfRange
     */
    public function setPasswordHash(string $passwordHash): void
    {
        if (!$this->validatePasswordHash($passwordHash)) {
            throw new ArgumentOutOfRange("La taille du hash du mot de passe devrait être inférieure a " . self::USER_PASSWORD_HASH_MAX_LENGTH . " !");
        }
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
     * @param string $lastName
     * @return bool
     * La méthode pour valider la taille du nom de famille
     */
    public function validateLastName(string $lastName): bool
    {
        return strlen($lastName) <= self::USER_LASTNAME_MAX_LENGTH;
    }

    /**
     * @param string $firstName
     * @return bool
     * La méthode pour valider la taille du prénom
     */
    public function validateFirstName(string $firstName): bool {
        return strlen($firstName) <= self::USER_FIRSTNAME_MAX_LENGTH;
    }

    /**
     * @param string $passwordHash
     * @return bool
     * La méthode pour valider la taille le hash du mot de passe
     */
    public function validatePasswordHash(string $passwordHash): bool {
        return strlen($passwordHash) <= self::USER_PASSWORD_HASH_MAX_LENGTH;
    }

    /**
     * @param string $email
     * @return bool
     * La méthode pour valider le format de l'email
     */
    public function validateEmailFormat(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param string $email
     * @return bool
     * La méthode pour valider la taille de l'email
     */
    public function validateEmail(string $email): bool {
        return $email <= self::USER_EMAIL_MAX_LENGTH;
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