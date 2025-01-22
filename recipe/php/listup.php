<?php

require_once('../../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['type'])) {
        $type = $_POST['type'];
        $sql = "SELECT id, name, img_name, mat1, mat2, mat3, mat4, mat5, mat6, type, url, img_full, table_name FROM main WHERE type='$type' ORDER BY priority DESC, id DESC";
    } elseif (!empty($_POST['folder-id'])) {
        $folder = $_POST['folder-id'];
        $sql = "SELECT id, name, img_name, mat1, mat2, mat3, mat4, mat5, mat6, type, url, img_full, table_name FROM main WHERE folder='$folder' ORDER BY priority DESC, id DESC";
    } else {
        $sql = "SELECT id, name, img_name, mat1, mat2, mat3, mat4, mat5, mat6, type, url, img_full, table_name FROM main ORDER BY priority DESC, id DESC";
    }
} else {
    $sql = "SELECT id, name, img_name, mat1, mat2, mat3, mat4, mat5, mat6, type, url, img_full, table_name FROM main ORDER BY priority DESC, id DESC";
}

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("MySQLでエラーが発生しました: " . mysqli_error($conn));
}

require_once('make_instance.php');

?>