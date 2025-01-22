<?php
// 許可された画像ファイル形式
$allowedExt = array("jpg", "jpeg", "png");

require_once('../../connect.php');
getParams('recipe');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームデータを取得
    $data = getForm($dirImage, $dirImageFull, $allowedExt, $conn);
    // var_dump($data);
    if ($_POST['submit'] == 'add') {
        // 新規登録の場合の命令文を用意
        $stmt = mysqli_prepare($conn, "INSERT INTO main (type, name, img_name, mat1, mat2, mat3, mat4, mat5, mat6, url, img_full, priority, folder) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_bind_param($stmt, "sssssssssssss", $data['type'], $data['name'], $data['img_name'], $data['mat1'], $data['mat2'], $data['mat3'], $data['mat4'], $data['mat5'], $data['mat6'], $data['url'], $data['img_full'], $data['priority'], $data['folder']);
    } elseif ($_POST['submit'] == 'edit') {
        // 修正の場合の命令文を用意
        $stmt = mysqli_prepare($conn, "UPDATE main SET type=?, name=?, img_name=?, mat1=?, mat2=?, mat3=?, mat4=?, mat5=?, mat6=?, url=?, img_full=?, priority=?, folder=? WHERE id=?");
        if (!$stmt) {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_bind_param($stmt, "sssssssssssssi", $data['type'], $data['name'], $data['img_name'], $data['mat1'], $data['mat2'], $data['mat3'], $data['mat4'], $data['mat5'], $data['mat6'], $data['url'], $data['img_full'], $data['priority'], $data['folder'], $data['id']);
    } else {
        echo "送信ボタンの種別が不正です";
    }
    // 命令文を実行
    if (!mysqli_stmt_execute($stmt)) {
        echo "エラー: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);

    // Allinの処理
    if ($data['type'] == "allin") {
        // 配列に「材料・分量・作り方」を格納
        $materials = array();
        $amounts = array();
        $steps = array();
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'step') === 0) {
                $steps[] = $value;
            } elseif (strpos($key, 'dmat') === 0) {
                $materials[] = $value;
            } elseif (strpos($key, 'damo') === 0) {
                $amounts[] = $value;
            }
        }
        // 作成されたレコードのIDを取得し、テーブル名を決定（'r'+id）
        if ($data['id'] == null) {
            $data['id'] = mysqli_insert_id($conn);
        }
        $link = "r" . $data['id'];
        // まだレシピの詳細を保存するテーブルがない場合
        if (!($data['pre'] == "allin")) {
            // テーブル名を書き込み
            $stmt = mysqli_prepare($conn, "UPDATE $tablename SET table_name=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "si", $link, $data["id"]);
            if (mysqli_stmt_execute($stmt)) {
                // 詳細テーブルを作成
                $sql = "CREATE TABLE $link (id INT AUTO_INCREMENT, material TEXT, amount TEXT, step TEXT, servings TEXT, memo TEXT, PRIMARY KEY (id)) DEFAULT CHARSET=utf8";
                if(!mysqli_query($conn, $sql)) {
                    echo "テーブルの作成に失敗しました: " . mysqli_error($conn);
                }
            }
        }
        // 詳細テーブルへの書き込み
        // 配列のうち最大の要素数$max_countを取得
        $materials_count = count($materials);
        $amounts_count = count($amounts);
        $steps_count = count($steps);
        $max_count = max($materials_count, $amounts_count, $steps_count);
        // INSERT命令文を準備
        $stmt = mysqli_prepare($conn, "INSERT INTO $link (material, amount, step) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $material, $amount, $step);
        for ($i = 0; $i < $max_count; $i++) {
            // 配列の要素が存在しない場合はNULLを代入する
            if (isset($materials[$i])) {
                $material = $materials[$i];
            } else {
                $material = NULL;
            }
            if (isset($amounts[$i])) {
                $amount = $amounts[$i];
            } else {
                $amount = NULL;
            }
            if (isset($steps[$i])) {
                $step = $steps[$i];
            } else {
                $step = NULL;
            }
            // 同じ行に挿入する
            if(!mysqli_stmt_execute($stmt)) {
                echo "詳細テーブルの書き込みに失敗しました（材料・分量）: " . mysqli_stmt_error($stmt);
            }
        }
        mysqli_stmt_close($stmt);
        // 人数とメモの書き込み
        $stmt = mysqli_prepare($conn, "UPDATE $link SET servings=?, memo=? WHERE id=1");
        mysqli_stmt_bind_param($stmt, "ss", $data["servings"], $data["memo"]);
        if(!mysqli_stmt_execute($stmt)) {
            echo "詳細テーブルの書き込みに失敗しました（人数・メモ）: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } elseif ($data['pre'] == "allin") {
        // 詳細テーブルを削除（Allin⇒Image,URL）
        $table_allin = "r" . $data["id"];
        $sql = "DROP TABLE IF EXISTS $table_allin";
        if (!mysqli_query($conn, $sql)) {
            echo "テーブルの削除に失敗しました: " . mysqli_error($conn);
        }
    }
} else {
    echo "フォームデータが取得できませんでした。";
}
mysqli_close($conn);
header("Location: ../index.php");
exit;

function getForm($dirImage, $dirImageFull, $allowedExt, $conn) {
    $data = array();
    $data['id'] = !empty($_POST["previous-id"]) ? $_POST["previous-id"] : null;
    $data['pre'] = !empty($_POST["previous-type"]) ? $_POST["previous-type"] : null;
    $data['type'] = $_POST["recipe-type"];
    $data['name'] = $_POST["recipe-name"];
    $data['mat1'] = !empty($_POST["mat1"]) ? $_POST["mat1"] : null;
    $data['mat2'] = !empty($_POST["mat2"]) ? $_POST["mat2"] : null;
    $data['mat3'] = !empty($_POST["mat3"]) ? $_POST["mat3"] : null;
    $data['mat4'] = !empty($_POST["mat4"]) ? $_POST["mat4"] : null;
    $data['mat5'] = !empty($_POST["mat5"]) ? $_POST["mat5"] : null;
    $data['mat6'] = !empty($_POST["mat6"]) ? $_POST["mat6"] : null;
    $data['url'] = !empty($_POST["recipe-url"]) ? $_POST["recipe-url"] : null;
    $data['servings'] = !empty($_POST["howmany"]) ? $_POST["howmany"] : null;
    $data['memo'] = !empty($_POST["memo"]) ? $_POST["memo"] : null;
    $data['priority'] = $_POST["priority"];
    $data['folder'] = $_POST["folder"];

    $data['img_name'] = uploadImage("recipe-image", $dirImage, $allowedExt, 1000000, $conn);
    $data['img_full'] = uploadImage("recipe-image-full", $dirImageFull, $allowedExt, 5000000, $conn);

    return $data;
}

function uploadImage($imageType, $dirImage, $allowedExt, $maxSize, $conn) {
    if (isset($_FILES[$imageType]) && $_FILES[$imageType]['error'] == UPLOAD_ERR_OK) {
        // 画像がある場合：アップロード、画像名を決定
        $fileName = $_FILES[$imageType]["name"];
        $fileTmpName = $_FILES[$imageType]['tmp_name'];
        $fileSize = $_FILES[$imageType]['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if(in_array($fileExt, $allowedExt)) {
            if($fileSize > $maxSize) {
                echo "画像の容量が大きすぎます(最大" . ($maxSize / 1000000) . "MB)";
                exit;
            }
        } else {
            echo "ファイルの拡張子が不適切です(許可：.png .jpg .jpeg)";
            exit;
        }
        // 画像の固有名を生成（画像ファイル名の重複防止）
        $img_name = uniqid('', true) . '.' . $fileExt;
        // 画像ファイルの保存先を指定
        $targetFile = $dirImage . $img_name;
        if (!move_uploaded_file($fileTmpName, $targetFile)) {
            echo "画像ファイルのアップロードに失敗しました。";
            exit;
        } 
    } else {
        // 新規画像がない場合、一旦仮で画像名を設定⇒以前の画像名を取得・再利用
        $img_name = ($imageType == "recipe-image") ? "noimg.png" : null;
        if (!empty($_POST["previous-type"])) {
            $sql = "SELECT img_name FROM main WHERE id='{$_POST["previous-id"]}'";
            $result = mysqli_query($conn, $sql);
            if (!$result) die("MySQLでエラーが発生しました: " . mysqli_error($conn));
            $row = mysqli_fetch_assoc($result);
            if ($imageType == "recipe-image" or ($_POST["recipe-type"] == "img" and $_POST["previous-type"] == "img")) {
                $img_name = $row["img_name"];
            }
        }
    }
    return $img_name;
}

$cssLinks = array("common", "home");
require_once('../views/head.php');
?>
<body>
<a class='link-recipe center' href="index.php">
    <div class="recipe-items">HOMEへ戻る</div>
</a>
</body>

<?php
/*

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームデータを取得
    $type = $_POST["recipe-type"];
    $name = $_POST["recipe-name"];
    $mat1 = !empty($_POST["mat1"]) ? $_POST["mat1"] : null;
    $mat2 = !empty($_POST["mat2"]) ? $_POST["mat2"] : null;
    $mat3 = !empty($_POST["mat3"]) ? $_POST["mat3"] : null;
    $mat4 = !empty($_POST["mat4"]) ? $_POST["mat4"] : null;
    $mat5 = !empty($_POST["mat5"]) ? $_POST["mat5"] : null;
    $mat6 = !empty($_POST["mat6"]) ? $_POST["mat6"] : null;
    $url = !empty($_POST["recipe-url"]) ? $_POST["recipe-url"] : null;
    // 完成写真画像の処理
    if (!empty($_FILES["recipe-image"])) {
        $fileName = $_FILES["recipe-image"]["name"];
        $fileTmpName = $_FILES['recipe-image']['tmp_name'];
        $fileSize = $_FILES['recipe-image']['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if(in_array($fileExt, $allowedExt)) {
            if($fileSize > 1000000) {
                echo "画像の容量が大きすぎます(最大1MB)";
                exit;
            }
        } else {
            echo "ファイルの拡張子が不適切です(許可：.png .jpg .jpeg)";
            exit;
        }
        // 画像の固有名を生成（画像ファイル名の重複防止）
        $img_name = uniqid('', true) . '.' . $fileExt;
        // 画像ファイルの保存先を指定
        $targetFile = $dirImage . $img_name;
        if (!move_uploaded_file($fileTmpName, $targetFile)) {
            echo "画像ファイルのアップロードに失敗しました。";
            exit;
        }   
    } else {
        $img_name = "noimg.png";
    }

    // レシピ全体画像の処理
    if (!empty($_FILES["recipe-image-full"])) {
        $fileName = $_FILES["recipe-image-full"]["name"];
        $fileTmpName = $_FILES['recipe-image-full']['tmp_name'];
        $fileSize = $_FILES['recipe-image-full']['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if(in_array($fileExt, $allowedExt)) {
            if($fileSize > 5000000) {
                echo "画像の容量が大きすぎます(最大5MB)";
                exit;
            }
        } else {
            echo "ファイルの拡張子が不適切です(許可：.png .jpg .jpeg)";
            exit;
        }
        // 画像の固有名を生成（画像ファイル名の重複防止）
        $img_full = uniqid('', true) . '.' . $fileExt;
        // 画像ファイルの保存先を指定
        $targetFile = $dirImageFull . $img_full;
        if (!move_uploaded_file($fileTmpName, $targetFile)) {
            echo "画像ファイルのアップロードに失敗しました。";
            exit;
        }   
    } else {
        $img_full = null;
    }

    // INSERT命令文を準備
    $stmt = mysqli_prepare($conn, "INSERT INTO main (type, name, img_name, mat1, mat2, mat3, mat4, mat5, mat6, url, img_full) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        // 準備時エラーメッセージ
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    // INSERT命令文に変数をバインド
    mysqli_stmt_bind_param($stmt, "sssssssssss", $type, $name, $img_name, $mat1, $mat2, $mat3, $mat4, $mat5, $mat6, $url, $img_full);

    // INSERT命令文を実行
    if (!mysqli_stmt_execute($stmt)) {
        // 実行時エラーメッセージ
        echo "エラー: " . mysqli_stmt_error($stmt);
        exit;
    }
    mysqli_stmt_close($stmt);

    // Allinの場合
    if ($type == "allin") {
        // 配列に「材料・分量・作り方」を格納
        $materials = array();
        $amounts = array();
        $steps = array();
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'step') === 0) {
                $steps[] = $value;
            } elseif (strpos($key, 'dmat') === 0) {
                $materials[] = $value;
            } elseif (strpos($key, 'damo') === 0) {
                $amounts[] = $value;
            }
        }
        // 作成されたレコードのIDを取得し、テーブル名（'r'+id）を書き込み
        $last_id = mysqli_insert_id($conn);
        $link = "r" . $last_id;
        $sql = "UPDATE $tablename SET table_name='$link' WHERE id=$last_id";
        if (mysqli_query($conn, $sql)) {
            // レシピの詳細を保存するテーブルを作成
            $sql = "CREATE TABLE $link (id INT AUTO_INCREMENT, material TEXT, amount TEXT, step TEXT, PRIMARY KEY (id)) DEFAULT CHARSET=utf8";
            if(mysqli_query($conn, $sql)) {
                // 配列のうち最大の要素数$max_countを取得
                $materials_count = count($materials);
                $amounts_count = count($amounts);
                $steps_count = count($steps);
                $max_count = max($materials_count, $amounts_count, $steps_count);
                // INSERT命令文を準備
                $stmt = mysqli_prepare($conn, "INSERT INTO $link (material, amount, step) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sss", $material, $amount, $step);
                for ($i = 0; $i < $max_count; $i++) {
                    // 配列の要素が存在しない場合はNULLを代入する
                    if (isset($materials[$i])) {
                        $material = $materials[$i];
                    } else {
                        $material = NULL;
                    }
                    if (isset($amounts[$i])) {
                        $amount = $amounts[$i];
                    } else {
                        $amount = NULL;
                    }
                    if (isset($steps[$i])) {
                        $step = $steps[$i];
                    } else {
                        $step = NULL;
                    }
                    // 同じ行に挿入する
                    if(!mysqli_stmt_execute($stmt)) {
                        echo "データの挿入に失敗しました: " . mysqli_stmt_error($stmt);
                        exit;
                    }
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "テーブルの作成に失敗しました: " . mysqli_error($conn);
            }
        }
    }
}
mysqli_close($conn);

header("Location: index.php");
*/