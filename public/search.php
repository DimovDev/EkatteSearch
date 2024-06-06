<?php


use EkatteSearch\Search;

include_once __DIR__ . '/../src/Search.php';
$search = new Search();
$data = $search->index();
if(isset($_POST["search"]) && $_POST["search"]!='' ) {
    $input = $_POST["search"];
    $column = $_POST["column"];
    $data = $search->search($input, $column);
var_dump($data); die();
}
//$sql = "SELECT * FROM ekatte_all";
//$stmt = $pdo->query($sql);
//$input = $_POST["search"];
//var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Client</h1>
<form action="search.php" method="post">
    Search <input type="text" name="search"><br>

    Column: <select name="column">
        <option value="ekatte">ЕКАТТЕ</option>
        <option value="t_v_m">Вид</option>
        <option value="name">Име на населено място</option>
        <option value="name_en">Транслитерация</option>
    </select><br>
    <input type ="submit">
</form>

<table>
    <tr>
        <th>ЕКАТТЕ</th>
        <th>Вид</th>
        <th>Име на населено място </th>
        <th>Транслитерация</th>
    </tr>

    <?php
    foreach($data as $row){
        ?>

        <tr>
            <td><?= $row['ekatte']?></td>
            <td><?= $row['t_v_m']?></td>
            <td><?= $row['name']?></td>
            <td><?= $row['name_en']?></td>
        </tr>
        <?php
    }
    ?>
</table>

</body>
</html>

