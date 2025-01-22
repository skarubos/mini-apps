<?php
require_once('class.php');

$sql = "SELECT id, name, date FROM shopping ORDER BY priority DESC";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("MySQLでエラーが発生しました: " . mysqli_error($conn));
}
/*
if (mysqli_num_rows($result) == 0) {
    die("MySQLに値がありません。");
}
*/
$shoppings = array();
while ($row = mysqli_fetch_assoc($result)) {
    $shopping = new shopping($row['id'], $row['name'], $row['date']);
    $shoppings[] = $shopping;
}

mysqli_close($conn);