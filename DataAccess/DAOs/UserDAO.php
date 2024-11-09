<?php
declare(strict_types=1);

namespace DataAccess\DAOs;

use Business\Domain\User;
use DataAccess\DbConnectionProvider;
use PDO;

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
    private string $tableName = "Users";

    public function __construct(){
        $this->connection = DbConnectionProvider::getConnection();
    }

    public function getById(int $id) : ?User
    {
        $query = "SELECT * FROM $this->tableName WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return null;
    }
}