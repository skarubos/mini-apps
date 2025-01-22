<?php
require_once('child_allin.php');
require_once('child_image.php');
require_once('child_url.php');

$recipes = array();
while ($row = mysqli_fetch_assoc($result)) {
    //配列$main_mにメイン材料を格納
    $main_m = array();
    for ($i = 1; $i <=6; $i++) {
        $mat = 'mat'.$i;
        if ($row[$mat] != NULL) {
            $main_m[] = $row[$mat];
        }
    }
    //レシピタイプ別にインスタンスを生成
    if ($row['type'] == "allin") {
        $recipe = new Allin($row['id'], $row['name'], $row['img_name'], $main_m, $row['table_name']);
    } elseif ($row['type'] == "img") {
        $recipe = new Image($row['id'], $row['name'], $row['img_name'], $main_m, $row['img_full']);
    } else {
        $recipe = new URL($row['id'], $row['name'], $row['img_name'], $main_m, $row['url']);
    }

    $recipes[] = $recipe;
}

mysqli_free_result($result);
mysqli_close($conn);