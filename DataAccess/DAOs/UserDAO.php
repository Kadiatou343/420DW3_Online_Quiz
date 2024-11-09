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

    public function __construct()
    {
        $this->connection = DbConnectionProvider::getConnection();
    }

    /**
     * @param int $id
     * @return User|null
     * La méthode pour obtenir un utilisateur par son identifiant
     * Elle retourne null si l'identifiant passé en paramètre n'existe pas dans la table 'users'
     */
    public function getById(int $id): ?User
    {
        $query = "SELECT Id, LastName, FirstName, Email, Role, RegistrationDate FROM $this->tableName WHERE id = :id ;";
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
                $user[$id]['LastName'],
                $user[$id]['FirstName'],
                $user[$id]['Email'],
                $user[$id]['Role'],
                (int)$user[$id]['Id'],
                DateTimeFromString::createDateTimeFromString($user[$id]['RegistrationDate'])));
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
        $query = "INSERT INTO $this->tableName (LastName, FirstName, Email, Role) " .
            "VALUES (:lastName, :firstName, :email, :role) ;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":lastName", $user->getLastName());
        $statement->bindValue(":firstName", $user->getFirstName());
        $statement->bindValue(":email", $user->getEmail());
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

        $rowsModified = $statement->rowCount();
        if ($rowsModified < 0) {
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
        $query = "DELETE FROM $this->tableName WHERE Id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":id", $user->getId());
        $statement->execute();
        $rowsDeleted = $statement->rowCount();

        if ($rowsDeleted < 0) {
            throw new Exception("Unable to delete user with id {$user->getId()}. No rows deleted !");
        }
    }
}