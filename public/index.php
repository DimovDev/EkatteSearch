<?php
require __DIR__.DIRECTORY_SEPARATOR."../vendor/autoload.php";

use EkatteSearch\Search;

$search = new Search();
$data = $search->getPaginatedResults();

if (isset($_POST["search_keyword"]) && $_POST["search_keyword"] != '') {
    $search_keyword = $_POST["search_keyword"];
    $column = $_POST["column"];
    $data = $search->getPaginatedResultsFiltered($search_keyword, $column);
}
$number = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekatte Search</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<div class="container">
<h1>ЕКАТТЕ</h1>
<form action="" method="post">
    <label for="search_keyword">Ключова дума за търсене:
        <input type="text" name="search_keyword">
    </label>
    <br>

    <label for="column">Филтри за търсене:
        <select name="column">
            <option value="ekatte">ЕКАТТЕ</option>
            <option value="t_v_m">Вид</option>
            <option value="name">Име на населено място</option>
            <option value="name_en">Транслитерация</option>
            <option value="oblast">Код на областта</option>
            <option value="oblast_name">Име на областта</option>
            <option value="obshtina">Код на общината</option>
            <option value="obshtina_name">Име на общината</option>
        </select>
    </label>
    <br>
    <input type="submit" value="Търсене">
</form>

<table class='tbl-qa'>
    <thead>
    <tr>
        <th class='table-header'>№</th>
        <th class='table-header'>ЕКАТТЕ №</th>
        <th class='table-header'>Вид</th>
        <th class='table-header'>Име на населено място</th>
        <th class='table-header'>Транслитерация</th>
        <th class='table-header'>Код на областта</th>
        <th class='table-header'>Име на областта</th>
        <th class='table-header'>Код на общината</th>
        <th class='table-header'>Име на общината</th>
    </tr>
    </thead>

    <?php
    if (count($data['results']) == 0) {
        ?>
        <div>
            <p>Няма намерени резултати по зададените критерии. Моля, променете критериите за търсене.</p>
        </div>
        <?php
    }else
    {
    foreach ($data['results'] as $row) {
    ?>
    <tbody>
    <tr class='table-row>'>
        <td><?= $number ?></td>
        <td><?= $row['ekatte'] ?></td>
        <td><?= $row['t_v_m'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['name_en'] ?></td>
        <td><?= $row['oblast'] ?></td>
        <td><?= $row['oblast_name'] ?></td>
        <td><?= $row['obshtina'] ?></td>
        <td><?= $row['obshtina_name'] ?></td>
    </tr>
    <?php
    $number++;
        }
    }
    ?>
    </tbody>
</table>
<ul class="pagination">
    <li><a href="?page=1">Първа</a></li>

    <?php for ($p = 1; $p <= $data['totalPages']; $p++) { ?>

        <span class="<?= $data['page'] == $p ? 'active' : ''; ?>"><a href="<?= '?page='.$p; ?>"><?= $p; ?></a></span>
    <?php } ?>
    <li><a href="?page=<?= $data['totalPages']; ?>">Последна</a></li>
</ul>
</div>
</body>
</html>

