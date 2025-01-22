<?php
require_once('../connect.php');
$mysqli = new mysqli($host, $username, $password, $dbname);

$new_order = $_POST['idList'];
$count = 1;

// Prepare and execute the SQL update statement for each bookmark
foreach ($new_order as $id) {
    $stmt = $mysqli->prepare("UPDATE bookmarks SET priority = ? WHERE id = ?");
    $stmt->bind_param('ii', $count, $id);
    $stmt->execute();
    $count++;
}
// Check for errors in the statement execution
if ($stmt->errno) {
    die('MySQLの更新に失敗しました: ' . $stmt->error);
}

$stmt->close();
$mysqli->close();

echo "並び順がMySQLへ更新されました！";

?>