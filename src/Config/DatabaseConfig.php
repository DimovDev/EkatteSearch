<?php

namespace EkatteSearch\Config;

use PDO;
use PDOException;

class DatabaseConfig
{
    protected string $host = "localhost";
    protected string $user = 'root';
    protected string $pass = 'password';
    protected string $db_name = 'ekatte_search';
    protected string $charset = 'utf8mb4';
    protected string $port = "3306";

    /**
     * Connects to the MySQL database and returns a PDO object.
     *
     * @return PDO The PDO object representing the connection to the database.
     * @throws PDOException If the connection fails.
     */
    public function connect(): PDO
    {
        $dsn = "mysql:host={$this->host};charset={$this->charset};port={$this->port}";
        $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, $this->user, $this->pass, $options);

            if (!$pdo->query("CREATE DATABASE IF NOT EXISTS `{$this->db_name}`")->errorCode() === '00000') {
                throw new PDOException('Failed to create database.');
            }

            if (!$pdo->query("USE `{$this->db_name}`")->errorCode() === '00000') {
                throw new PDOException('Failed to select database.');
            }

            return $pdo;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
