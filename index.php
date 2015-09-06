<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание №3, п.2</title>
</head>
<body>
<?php
require_once 'connect.php';
$req = "SHOW TABLES";
$result = $connection->query($req);
$tables = $result->fetch_all(MYSQLI_NUM);
$connection->close();
?>

    <form action="makefile.php" method="post">
        Таблица, из которой будут выгружены данные:
        <select name="table">
            <?php
                foreach ($tables as $table) {
                    echo '<option>'.$table[0].'</option>';
                }
            ?>
        </select>
        Формат выгружаемых данных:
        <select name="format">
            <option>csv</option>
            <option>json</option>
            <option>xml</option>
        </select>
        <p><input type="submit" value="Выгрузить"></p>
    </form>

</body>
</html>
