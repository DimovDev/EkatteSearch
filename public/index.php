<?php

require __DIR__ . DIRECTORY_SEPARATOR . "../vendor/autoload.php";
//require __DIR__ . DIRECTORY_SEPARATOR . "/search.php";
?>
<html>
<body>

<form action="../src/Search.php" method="post">
        Search <input type="text" name="search"><br>

Column: <select name="column">
    <option value="name">Name</option>
    <option value="age">Age</option>
    <option value="gender">Gender</option>
</select><br>
    <input type ="submit">
</form>

</body>
</html>
