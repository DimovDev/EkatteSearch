<?php

namespace EkatteSearch;

use EkatteSearch\Config\DatabaseConfig;

include_once __DIR__ . '/Config/DatabaseConfig.php';
class Search
{
    private \PDO $pdo;

    public function __construct() {
        $connection = new DatabaseConfig();
        $this->pdo = $connection->connect();
    }

    public function index()
    {
        $sql = "SELECT * FROM ekatte_all";
        $stmt = $this->pdo->query($sql);
        return $stmt;

}

    public function search(mixed $input, mixed $column)
    {
        $sql = "SELECT * FROM ekatte_all WHERE   name  '%{$input}%'";
        $stmt = $this->pdo->query($sql);
        return $stmt;
    }
}
