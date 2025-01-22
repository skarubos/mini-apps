<?php

require_once('../../connect.php');
getParams('recipe');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $folder_name = $_POST["folder-name"];
    $stmt = mysqli_prepare($conn, "INSERT INTO folders (name) VALUES (?)");
    if (!$stmt) {
        echo "エラー: " . mysqli_error($conn);
    }
    mysqli_stmt_bind_param($stmt, "s", $folder_name);
    if (!mysqli_stmt_execute($stmt)) {
        echo "エラー: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
header("Location: ../folder.php");
exit;