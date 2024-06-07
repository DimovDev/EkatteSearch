<?php

namespace EkatteSearch;

use EkatteSearch\Config\DatabaseConfig;

class Search
{
    private \PDO $pdo;
    const LIMIT = 10;

    public function __construct() {
        $connection = new DatabaseConfig();
        $this->pdo = $connection->connect();
    }

    /**
     * Retrieves a set of results from the database based on pagination parameters.
     *
     * @return array Returns an array containing the results, current page number, and total number of pages.
     */
    public function getPaginatedResults(): array
    {
        $limit = self::LIMIT;
        $page = $this->getPageNumber();
        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM ekatte_all ORDER BY ekatte ASC LIMIT :offset, :limit";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $totalResults = $this->getTotalResults();
        $totalPages = (int) ceil($totalResults / $limit);

        return [
                'results' => $results,
                'page' => $page,
                'totalPages' => $totalPages
        ];
    }

    /**
     * Retrieves the page number from the $_GET superglobal or defaults to 1.
     *
     * @return int Returns the page number.
     */
    private function getPageNumber(): int
    {
        return isset($_GET['page']) ? (int) $_GET['page'] : 1;
    }

    /**
     * Retrieves the total number of rows in the 'ekatte_all' table.
     *
     * @return int The total number of rows.
     */
    private function getTotalResults(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM ekatte_all");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'];
    }
    /**
     * Retrieves paginated results based on the provided search keyword and column.
     *
     * @param mixed $search_keyword The search keyword to filter the results.
     * @param string $column The column to filter the results on.
     * @return int The total number of rows.
     */
    private function getTotalResultsFiltered(mixed $search_keyword, string $column)
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM ekatte_all WHERE $column LIKE '%{$search_keyword}%'");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'];
    }
    /**
     * Retrieves paginated results based on the provided search keyword and column.
     *
     * @param mixed $search_keyword The search keyword to filter the results.
     * @param string $column The column to filter the results on.
     * @return array Returns an array containing the results, current page number, and total number of pages.
     */
    public function getPaginatedResultsFiltered(mixed $search_keyword, string $column): array
    {
        $page = 1;
        $limit = self::LIMIT;
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM ekatte_all WHERE $column LIKE ('%{$search_keyword}%') LIMIT $offset, $limit";
        $results = $this->pdo->query($sql)->fetchAll();
        $totalResults = $this->getTotalResultsFiltered($search_keyword, $column);
        $totalPages = (int) ceil($totalResults / $limit);

        return [
                'results' => $results,
                'page' => $page,
                'totalPages' => $totalPages
        ];
    }
}
