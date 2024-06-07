<?php
namespace EkatteSearch\Script;

use EkatteSearch\Config\DatabaseConfig;
use PDOException;

include_once __DIR__ . '/../Config/DatabaseConfig.php';
$connection = new DatabaseConfig();
$pdo = $connection->connect();
try {
    $sql = "CREATE TABLE IF NOT EXISTS ekatte_all (
        `ekatte` VARCHAR(256) NULL,
        `t_v_m` VARCHAR(256) NULL,
        `name` VARCHAR(256) NULL,
        `oblast` VARCHAR(256) NULL,
        `obshtina` VARCHAR(256) NULL,
        `kmetstvo` VARCHAR(256) NULL,
        `kind` INT NULL,
        `category` INT NULL,
        `altitude` INT NULL,
        `document` INT NULL,
        `abc` INT NULL,
        `name_en` VARCHAR(256) NULL,
        `nuts1` VARCHAR(256) NULL,
        `nuts2` VARCHAR(256) NULL,
        `nuts3` VARCHAR(256) NULL,
        `text` VARCHAR(256) NULL,
        `oblast_name` VARCHAR(256) NULL,
        `obshtina_name` VARCHAR(256) NULL
)";
    $pdo->exec($sql);
    echo "Table created successfully".PHP_EOL;
} catch (PDOException $e) {
    $pdo->rollback();
    throw $e;
}

$filename = "ek_atte.json";
$data = file_get_contents($filename,FILE_USE_INCLUDE_PATH);
$decodedData = json_decode($data,true);
if (json_last_error() === JSON_ERROR_NONE) {

    $sql = "USE ekatte_search";
    $pdo->exec($sql);
    $stmt = $pdo->prepare("INSERT INTO ekatte_all (ekatte,t_v_m,`name`,oblast,obshtina,kmetstvo,kind,category,altitude,document,abc,name_en,nuts1,nuts2,nuts3,`text`,oblast_name,obshtina_name)
VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    try {
        $pdo->beginTransaction();
        foreach ($decodedData as $row) {
            $stmt->execute([
                    $row['ekatte'], $row['t_v_m'], $row['name'], $row['oblast'], $row['obshtina'], $row['kmetstvo'],
                    $row['kind'], $row['category'], $row['altitude'], $row['document'], $row['abc'], $row['name_en'],
                    $row['nuts1'], $row['nuts2'], $row['nuts3'], $row['text'], $row['oblast_name'],
                    $row['obshtina_name']
            ]);
        }
        $pdo->commit();
        $pdo->exec($sql);
        echo "Data inserted successfully".PHP_EOL;
    } catch (PDOException $e) {
        $pdo->rollback();
        throw $e;
    }
}
$pdo = null;
