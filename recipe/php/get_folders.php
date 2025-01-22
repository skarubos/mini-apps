<?php
$sql = "SELECT id, name FROM folders";
$result = mysqli_query($conn, $sql);

// 結果セットからデータを取得し、配列に格納
$folders = array();
while ($row = mysqli_fetch_assoc($result)) {
$folders[] = array(
    "id" => $row["id"],
    "name" => $row["name"],
);
}
mysqli_free_result($result);