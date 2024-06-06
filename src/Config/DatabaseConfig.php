<?php

namespace EkatteSearch\Config;

use PDO;
use PDOException;

class DatabaseConfig
{
    public string $host = "localhost";
    public string $user = 'root';
    public string $pass = 'password';
    public string $db_name = 'ekatte_search';
    public string $charset = 'utf8mb4';
    public string $port = "3306";

    /**
     * Connects to the MySQL database using the provided configuration and returns a PDO object.
     *
     * @return PDO The PDO object representing the connection to the database.
     */
    public function connect(): PDO
    {
        try {
            $dsn = "mysql:host=$this->host;charset=$this->charset;port=$this->port";
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$this->db_name`");
            $pdo->exec("USE `$this->db_name`");
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES  ,false,);
            return $pdo;

        } catch (PDOException $e) {
            throw $e;
        }

    }
}
