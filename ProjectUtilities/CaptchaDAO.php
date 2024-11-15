<?php
declare(strict_types=1);

namespace ProjectUtilities;
use DataAccess\DbConnectionProvider;
use PDO;

/**
 * Classe représentant le DAO du captcha
 */
class CaptchaDAO
{
    /**
     * @var PDO
     * La connexion que le DAO va utiliser
     */
    private PDO $connection;
    /**
     * @var string
     * Le nom de la table dans la base de données
     */
    private string $tableName = "captcha";

    public function __construct()
    {
        $this->connection = DbConnectionProvider::getConnection();
    }

    /**
     * @param int $id
     * @return Captcha|null
     * Obtenir un captcha par son identifiant
     * La méthode retourne null si l'identifiant n'existe pas
     */
    public function getById(int $id) : ?Captcha
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id ;";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result){
            return new Captcha((int)$result[0]['Id'], $result[0]['Code'], $result[0]['Image']);
        }

        return null;
    }

    /**
     * @return int
     * La méthode pour obtenir le nombre d'enregistrements dans la table
     */
    public function getNumberOfTuples() : int
    {
        $query = "SELECT COUNT(*) FROM $this->tableName ;";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return (int)$result[0]['COUNT(*)'];
    }

    /**
     * Destructeur
     * La méthode pour fermer la connexion
     */
    public function __destruct()
    {
        unset($this->connection);
    }
}