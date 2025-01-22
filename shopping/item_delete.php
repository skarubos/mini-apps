<?php 
require_once('../connect.php');

$itemID = $_POST['itemID'];

$sql = "DELETE FROM shopping WHERE id = $itemID";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("MySQLでエラーが発生しました: " . mysqli_error($conn));
}

mysqli_close($conn);