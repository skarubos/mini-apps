<?php
require_once('../connect.php');

$bookmarkId = $_POST['bookmarkId'];

//画像ファイルを削除
$sql = "SELECT img_name FROM bookmarks WHERE id = $bookmarkId";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("MySQLでエラーが発生しました: " . mysqli_error($conn));
}
if (mysqli_num_rows($result) == 0) {
    die("MySQLに値がありません。");
}
$row = mysqli_fetch_assoc($result);
$img_name = $row['img_name'];
$file_path = 'images/'. $img_name;
if (file_exists($file_path)) {
    unlink($file_path);
}

//データベースを削除
$sql = "DELETE FROM bookmarks WHERE id = $bookmarkId";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

mysqli_close($conn);

echo "MySQLから削除されました！";

?>