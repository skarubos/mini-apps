<?php
function delete_file($file_path) {
    if (!unlink($file_path)) {
        echo "<br>画像ファイル" . $file_path . "の削除に失敗しました";
    }
}

function delete_recipe($id) {
    require_once('../../connect.php');
    getParams('recipe');
    // 画像・Full画像・テーブルの名前を取得する
    $sql = "SELECT img_name, img_full, table_name FROM $tablename WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "<br>MySQLエラー: " . mysqli_error($conn);
    }
    $row = mysqli_fetch_assoc($result);
    $data = array(
        "img_name" => $row["img_name"],
        "img_full" => $row["img_full"],
        "table_name" => $row["table_name"]
    );

    // 画像の削除
    if (!($data["img_name"] == "noimg.png")) {
        delete_file($dirImage . $data["img_name"]);
    }
    if (!empty($data['img_full'])) {
        delete_file($dirImageFull . $data["img_full"]);
    }
    // テーブルの削除（Allin）
    if (!empty($data['table_name'])) {
        $sql = 'DROP TABLE IF EXISTS ' . $data["table_name"];
        if (!mysqli_query($conn, $sql)) {
            echo "<br>テーブル（" . $data["table_name"] . "）削除エラー: " . mysqli_error($conn);
        }
    }
    // レコードを削除
    $sql = "DELETE FROM $tablename WHERE id='$id'";
    if (!mysqli_query($conn, $sql)) {
        echo "<br>レコード(ID=" . $id . ")削除エラー: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST);
    $items = $_POST['delete'];
    var_dump($items);
    if (count($items) === 1) {
        delete_recipe($items[0]);
    } else {
        foreach ($items as $item) {
            delete_recipe($item);
        }
    }
}

header("Location: ../index.php");
exit;