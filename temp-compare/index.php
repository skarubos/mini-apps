<?PHP
    // 最新の日時を取得
    $newestDate = "データなし";
    $condition = false;

    require_once('mySQL.php');

    // テーブルが存在するかどうかをチェック
    $sql = "SHOW TABLES LIKE '$tablename'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $sql = "SELECT date FROM $tablename ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $newestDate = $row["date"];
            }
            $condition = true;
        }
    }
    $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TempCompare</title>
    <link rel="stylesheet" type="text/css" href="css/common.css">

    <!-- 最新のjQueryを読み込む（下記2つに必須） -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

    <!-- 日付選択用カレンダーDateRangePickerのために以下3つを読み込み -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    
    <!-- グラフ表示Chart.jsのために以下1つを読み込み -->
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div id="newest-date"><?= $newestDate ?></div>
    <div class="container">
        <div class="panel-wrapper">
            <div class="date-wrapper">
                <div class="date-caption-wrapper">
                    <p class="date-caption"><span id="theY"></span>年 <span id="theM"></span>月 <span id="theD"></span>日</p>
                </div>
                <div class="control-wrapper">
                    <button id="prev-button" class='next-prev-button control-element hover-ani' type="button">?</button>
                    <input type="text" name="dateSelector" id="dateSelector" class='control-element hover-ani'>
                    <button id="next-button" class='next-prev-button control-element hover-ani' type="button">?</button>
                </div>
            </div>
            <div class="upload-wrapper">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <button id="file-upload-button" class="upload-element hover-ani">
                        <img src="images/folder-120.png" alt="Folder">
                    </button>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </form>
            </div>
        </div>
        <canvas id="mainChart"></canvas>
    </div>
    
    <script>
        // カスタムのファイル選択ボタンとデフォルトボタンを紐づけ
        document.getElementById("file-upload-button").addEventListener("click", function() {
            event.preventDefault();
            document.getElementById("fileToUpload").click();
        });
    </script>
    <script src="csv_uploader.js"></script>
    <?php
        if ($condition) {
            echo '<script type="module" src="ini.js"></script>';
        }
    ?>
</body>
</html>