<?php
declare(strict_types=1);

namespace DataAccess;

use PDO;

class DbConnectionProvider
{
    private static ?PDO $connection;
    private static string $connection_string = "mysql:host=localhost;dbname=online_quiz_db";
    private static string $username = "root";
    private static string $password = "";

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            self::$connection = new PDO(self::$connection_string, self::$username, self::$password);
        }
        return self::$connection;
    }
}