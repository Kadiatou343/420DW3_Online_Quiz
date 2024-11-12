<?php
declare(strict_types=1);

namespace DataAccess\DAOs;

use Business\Domain\User;
use DataAccess\DbConnectionProvider;
use Exception;
use PDO;
use ProjectUtilities\DateTimeFromString;
use ProjectUtilities\ListUser;

/**
 * Classe représentant les interactions entre l'entité 'User' et la table 'users' dans la base de données
 */
class UserDAO
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
    private string $tableName = "users";

    /**
     * Le contructeur initiale la connection avec la classe fournisseur
     */
    public function __construct()
    {
        $this->connection = DbConnectionProvider::getConnection();
    }

    /**
     * @param int $id
     * @return User|null
     * La méthode pour obtenir un utilisateur par son identifiant.
     * Elle retourne null si l'identifiant passé en paramètre n'existe pas dans la table 'users'
     */
    public function getById(int $id): ?User
    {
        $query = "SELECT * FROM $this->tableName WHERE Id = :id ;";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new User(
                $result[0]['LastName'],
                $result[0]['FirstName'],
                $result[0]['Email'],
                $result[0]['Role'],
                $result[0]['PasswordHash'],
                (int)$result[0]['Id'],
                DateTimeFromString::createDateTimeFromString($result[0]['RegistrationDate']));
        }
        return null;
    }

    /**
     * @return ListUser
     * La méthode qui retourne tous les tuples de la table 'users'
     */
    public function getAll(): ListUser
    {
        $query = "SELECT * FROM $this->tableName ;";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $users = new ListUser();
        foreach ($results as $id => $user) {
            $users->addUser(new User(
                $user['LastName'],
                $user['FirstName'],
                $user['Email'],
                $user['Role'],
                $user['PasswordHash'],
                (int)$user['Id'],
                DateTimeFromString::createDateTimeFromString($user['RegistrationDate'])));
        }
        return $users;
    }

    /**
     * @param User $user
     * @return User
     * La méthode pour insérer un nouvel utilisateur
     */
    public function create(User $user): User
    {
        $query = "INSERT INTO $this->tableName (LastName, FirstName, Email, PasswordHash, Role) " .
            "VALUES (:lastName, :firstName, :email, :passwordHash, :role) ;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":lastName", $user->getLastName());
        $statement->bindValue(":firstName", $user->getFirstName());
        $statement->bindValue(":email", $user->getEmail());
        $statement->bindValue(":passwordHash", $user->getPasswordHash());
        $statement->bindValue(":role", $user->getRole());
        $statement->execute();
        $createdId = (int)$this->connection->lastInsertId();

        return $this->getById($createdId);
    }

    /**
     * @param User $user
     * @return User
     * @throws Exception
     * La méthode pour mettre à jour un utilisateur
     */
    public function update(User $user): User
    {
        $query = "UPDATE $this->tableName SET " .
            "LastName = :lastName, " .
            "FirstName = :firstName, " .
            "Email = :email, " .
            "Role = :role " .
            "WHERE Id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":lastName", $user->getLastName());
        $statement->bindValue(":firstName", $user->getFirstName());
        $statement->bindValue(":email", $user->getEmail());
        $statement->bindValue(":role", $user->getRole());
        $statement->bindValue(":id", $user->getId());
        $statement->execute();

        if ($statement->rowCount() === 0) {
            throw new Exception("Unable to update user with id {$user->getId()}. No rows modified !");
        }
        return $this->getById($user->getId());
    }

    /**
     * @param User $user
     * @return void
     * @throws Exception
     * La méthode pour supprimer un utilisateur
     */
    public function delete(User $user): void
    {
        $query = "DELETE FROM $this->tableName WHERE Id = :id ;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":id", $user->getId());
        $statement->execute();

        if ($statement->rowCount() === 0) {
            throw new Exception("Unable to delete user with id {$user->getId()}. No rows deleted !");
        }
    }

    /**
     * @param string $email
     * @return User|null
     * La méthode qui retourne un utilisateur par son email.
     * Elle retourne null si l'email passé en paramètre ne correspond à aucun tuple dans la table
     */
    public function getByEmail(string $email): ?User
    {
        $query = "SELECT * FROM $this->tableName WHERE Email = :email ;";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(":email", $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new User(
                $result[0]['LastName'],
                $result[0]['FirstName'],
                $result[0]['Email'],
                $result[0]['Role'],
                $result[0]['PasswordHash'],
                (int)$result[0]['Id'],
                DateTimeFromString::createDateTimeFromString($result[0]['RegistrationDate'])
            );
        }
        return null;
    }

    /**
     * @param string $criteria
     * @return ListUser|null
     * La méthode qui retourne les utilisateurs en fonction d'une chaine de caractères de recherche
     */
    public function searchByString(string $criteria): ?ListUser
    {
        $query = "SELECT * FROM $this->tableName WHERE LastName LIKE :criteria " .
        "OR FirstName LIKE :criteria OR Email LIKE :criteria ;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":criteria", "%$criteria%");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $users = new ListUser();

        if ($result){
            foreach ($result as $user){
                $users->addUser(new User(
                    $user['LastName'],
                    $user['FirstName'],
                    $user['Email'],
                    $user['Role'],
                    $user['PasswordHash'],
                    (int)$user['Id'],
                    DateTimeFromString::createDateTimeFromString($user['RegistrationDate'])
                ));
            }
            return $users;
        }
        return null;
    }
}