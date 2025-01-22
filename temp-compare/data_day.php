<?php
$yyyy = $_GET['year'];
$mm = $_GET['month'];
$dd = $_GET['date'];

require_once('mySQL.php');

// 【気象庁のデータを取得】
$data = array();
// 指定日のデータが存在するかテーブル名を検索
$tablename_ref_10min = "ref_10min_" . $yyyy . $mm . $dd;
$sql = "SHOW TABLES LIKE '$tablename_ref_10min'";
$result = $conn->query($sql);

// 指定された日付のデータが存在しない場合、'get_ref.php'を実行して気象庁から取得＆テーブル作成
if ($result->num_rows == 0) {
  require_once('get_ref.php');
}

// テーブルからデータ取得
$sql = "SELECT time, temperature, humidity, sunlight FROM $tablename_ref_10min";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    array_push($data, $row);
  }
}

// 【switchbotのデータを取得】
$data_sb = array();
$date_start = $yyyy."-".$mm."-".$dd." 00:10";

$sql = "SELECT temp_A, hum_A FROM sb_test WHERE date >= '$date_start' LIMIT 144";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    array_push($data_sb, $row);
  }
}

$conn->close();

$data_all = array(
  "ref" => $data,
  "sb" => $data_sb
);

header('Content-type: application/json; charset=utf-8');
echo json_encode($data_all);

?>