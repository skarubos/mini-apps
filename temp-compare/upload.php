<?php
require_once('mySQL.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];

        $csvFile = fopen($fileTmpPath, 'r');
        fgetcsv($csvFile); // ヘッダー行をスキップ

        $saveData = array();

        while (($line = fgetcsv($csvFile)) !== FALSE) {
            // 時間の末尾が0である行のみを保存
            if (substr($line[0], -1) === "0") {
                $saveData[] = array('date' => $line[0], 'temp_A' => $line[1], 'hum_A' => $line[2]);
            }
        }

        fclose($csvFile);

        // テーブルが存在しない場合
        if ($conn->query("SHOW TABLES LIKE '$tablename'")->num_rows == 0) {
            $conn->query("CREATE TABLE $tablename(id INT AUTO_INCREMENT, date TEXT, temp_A FLOAT, hum_A INT, PRIMARY KEY (id)) DEFAULT CHARSET=utf8");
            
            $stmt = $conn->prepare("INSERT INTO $tablename (date, temp_A, hum_A) VALUES (?, ?, ?)");
        
            foreach ($saveData as $data) {
                $stmt->bind_param("sdd", $data['date'], $data['temp_A'], $data['hum_A']);
                $stmt->execute();
            }
        } else {
            // テーブルから最新の日付を取得
            $result = $conn->query("SELECT date FROM $tablename ORDER BY id DESC LIMIT 1");
            $lastDate = $result->fetch_assoc()['date'];
        
            $stmt = $conn->prepare("INSERT INTO $tablename (date, temp_A, hum_A) VALUES (?, ?, ?)");
        
            foreach ($saveData as $data) {
                if ($data['date'] > $lastDate) {
                    $stmt->bind_param("sdd", $data['date'], $data['temp_A'], $data['hum_A']);
                    $stmt->execute();
                }
            }
        }
        echo 'completed';
        $stmt->close();
    } else {
        echo 'failed';
    }
}

$conn->close();
exit;
?>