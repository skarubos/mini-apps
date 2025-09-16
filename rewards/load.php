<?php
require_once('../connect.php'); // DB接続設定を読み込み

// --- テーブル名のホワイトリスト ---
// 許可するテーブル名を配列で定義
$allowedTables = ['keywords', 'keywords_sub', 'keywords_my'];

// URLパラメータ取得（table, loop, wt）
$tableParam = isset($_GET['table']) ? $_GET['table'] : 'keywords';

// ホワイトリスト照合（完全一致）
if (!in_array($tableParam, $allowedTables, true)) {
    http_response_code(400);
    die('不正なテーブル名です。許可されているのは: ' . implode(', ', $allowedTables) . ' です。');
}
$table = $tableParam; // 安全と判断できたので採用

// --- パラメータ検証: loop は 1〜30 の整数 ---
$pickCount = filter_input(
    INPUT_GET,
    'loop',
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1, 'max_range' => 30]]
);
if ($pickCount === false || $pickCount === null) {
    http_response_code(400);
    die('loop は 1 以上 30 以下の整数を指定してください。例: &loop=30');
}

// --- パラメータ検証: wt は 1000〜10000 の整数 ---
$waitingTime = filter_input(
    INPUT_GET,
    'wt',
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1000, 'max_range' => 10000]]
);
if ($waitingTime === false || $waitingTime === null) {
    http_response_code(400);
    die('wt は 100 以上 1000 以下の整数を指定してください。例: &wt=300');
}

// --- 総レコード数の取得 ---
$sqlCount = "SELECT COUNT(*) AS total FROM `{$table}`";
$resultCount = mysqli_query($conn, $sqlCount);
if (!$resultCount) {
    die("レコード数取得エラー: " . mysqli_error($conn));
}
$rowCount = mysqli_fetch_assoc($resultCount);
$totalRecords = (int)$rowCount['total'];

// --- レコード数が不足している場合は処理しない ---
if ($totalRecords < $pickCount) {
    echo "レコード数が {$pickCount} 個未満のため、処理を中止します。";
    mysqli_close($conn);
    exit;
}

// --- ランダムに $pickCount 件取得（重複なし） ---
$sqlRandom = "SELECT `keyword` FROM `{$table}` ORDER BY RAND() LIMIT {$pickCount}";
$resultRandom = mysqli_query($conn, $sqlRandom);
if (!$resultRandom) {
    die("ランダム取得エラー: " . mysqli_error($conn));
}

// --- 配列に格納 ---
$keywords = [];
while ($row = mysqli_fetch_assoc($resultRandom)) {
    $keywords[] = $row['keyword'];
}

// --- 確認用出力（本番では不要） ---
echo "<pre>";
print_r($keywords);
echo "</pre>";
echo "Waiting Time: {$waitingTime}";

// 接続終了
mysqli_close($conn);