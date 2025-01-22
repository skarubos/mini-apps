<?php
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');
error_reporting(E_ALL);

// URLを設定
$url = "https://www.data.jma.go.jp/stats/etrn/view/10min_s1.php?prec_no=49&block_no=47638&year="
    . $yyyy . "&month=" . $mm . "&day=" . $dd;

// cURLを使用してデータを取得
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$html = curl_exec($ch);
curl_close($ch);

$dom = new DOMDocument;
@$dom->loadHTML($html);
$xpath = new DOMXPath($dom);

// id="tablefix1"のtableを取得
$tables = $xpath->query('//table[@id="tablefix1"]');

$arr = array();

foreach ($tables as $table) {
    $rows = $table->getElementsByTagName('tr');
    foreach ($rows as $row) {
        $cols = $row->getElementsByTagName('td');
        if ($cols->length > 0) {
            // 'temperature', 'humidity', 'sunlight'の値が数値の文字列の場合は数値に変換、それ以外の場合はnullを格納
            $temperature = is_numeric($cols->item(4)->nodeValue) ? floatval($cols->item(4)->nodeValue) : null;
            $humidity = is_numeric($cols->item(5)->nodeValue) ? floatval($cols->item(5)->nodeValue) : null;
            $sunlight = is_numeric($cols->item(10)->nodeValue) ? intval($cols->item(10)->nodeValue) * 10 : null;
            // 0, 4, 5, 10番目の列のデータを取得
            $arr[] = array(
                'time' => $cols->item(0)->nodeValue,
                'temperature' => $temperature,
                'humidity' => $humidity,
                'sunlight' => $sunlight
            );
        }
    }
}

// テーブル作成のSQL文
$sql = "CREATE TABLE $tablename_ref_10min(time TEXT, temperature FLOAT, humidity INT, sunlight INT) DEFAULT CHARSET=utf8;";

if ($conn->query($sql) === TRUE) {
    // データを挿入
    foreach ($arr as $row) {
        $stmt = $conn->prepare("INSERT INTO {$tablename_ref_10min} (time, temperature, humidity, sunlight) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $row['time'], $row['temperature'], $row['humidity'], $row['sunlight']);
        $stmt->execute();
    }
}

?>
