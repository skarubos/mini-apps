<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../connect.php');
    if (!empty($_POST['newName'])) {

        //「新規作成」の処理

        $item_name = $_POST['newName'];
        $item_date = getToday();
        
        $query = "INSERT INTO shopping (name, date, priority) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $item_name, $item_date, $_SERVER['REQUEST_TIME']);

    } elseif (!empty($_POST['updateName'])) {

        //「更新」の処理

        $item_id = $_POST['updateId'];
        $item_name = $_POST['updateName'];
        $item_date = getToday();
        
        $query = "UPDATE shopping SET name=?, date=?, priority=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssii", $item_name, $item_date, $_SERVER['REQUEST_TIME'], $item_id);
        
    } else {
        die("更新に失敗しました。");
    }

    // エラー処理・SQL終了処理・元ページへ遷移
    if (!mysqli_stmt_execute($stmt)) {
        die('MySQLの更新に失敗しました: ' . mysqli_error($conn));
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header('Location: index.php');
}

function getToday() {
    $today = getdate();
    $weeks = array('日', '月', '火', '水', '木', '金', '土');
    $item_date = $today['mon'] . "月" . $today['mday'] . "日（". $weeks[$today['wday']] . "）";
    return $item_date;
}