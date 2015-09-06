<?php
$connection = new mysqli('localhost', 'root', '', 'hometask2');
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}
$connection->query("SET NAMES 'UTF-8'");
/*
//прямой запрос
$bd = "SELECT * FROM $tablename";
$result = $connection->query($bd);
$records = $result->fetch_all(MYSQLi_ASSOC);

//подготовленный запрос

$bd = "SELECT * FROM ?";
$stmt = $connection->prepare($bd);
$tablename = $_POST[0];//например
$stmt->bind_param('s', $tablename);
$stmt->execute();
$stmt->bind_result($name);/
while ($stmt->fetch()) {
    echo $name.'<br />';
}
$stmt->close();
$connection->close();
*/