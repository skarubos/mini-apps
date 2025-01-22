<?php
require_once('../connect.php');
require_once('class.php');

// Query the database for the bookmarks table
$sql = "SELECT id, name, link_url, img_name FROM bookmarks ORDER BY priority";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("MySQLでエラーが発生しました: " . mysqli_error($conn));
}
if (mysqli_num_rows($result) == 0) {
    die("MySQLに値がありません。");
}


// Create an array to hold the Bookmark objects
$bookmarks = array();

// Iterate over the rows and create Bookmark objects
while ($row = mysqli_fetch_assoc($result)) {
    $bookmark = new Bookmark($row['id'], $row['name'], $row['link_url'], $row['img_name']);
    $bookmarks[] = $bookmark;
}

