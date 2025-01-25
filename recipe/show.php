<?php
// URLパラメータを取得
$table = $_GET['table'];
$recipe_name = $_GET['name'];
$image_name = $_GET['image'];

require_once('../connect.php');

// クエリを実行して結果セットを取得
$sql = "SELECT material, amount, step FROM $table";
$result = mysqli_query($conn, $sql);

// 結果セットからデータを取得し、配列に格納
$materials = array();
$amounts = array();
$steps = array();
while ($row = mysqli_fetch_assoc($result)) {
    if (!is_null($row['material'])) {
        $materials[] = $row['material'];
    }
    if (!is_null($row['amount'])) {
        $amounts[] = $row['amount'];
    }
    if (!is_null($row['step'])) {
        $steps[] = $row['step'];
    }
}
mysqli_free_result($result);

// 材料と分量の配列を結合
if (count($materials) == count($amounts)) {
  $combined = array_combine($materials, $amounts);
} else {
  echo "Error: The number of elements in the two arrays is different.";
}

// 「何人前」と「メモ」を取得
$sql = "SELECT servings, memo FROM $table WHERE id=1";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)) {
    $servings = $row["servings"];
    $memo = $row["memo"];
}
mysqli_free_result($result);
mysqli_close($conn);

$cssLinks = array("common", "show");
require_once('views/head.php');
?>

<body>
<img src='<?= "images/".$image_name ?>' class="top-img">
<div class="container">
<h1 class="title"><?= $recipe_name ?></h1>
<section class="materials">
    <h2>
        材料
        <span>(<?= $servings ?>)</span>
    </h2>
    <ul class="material-list">
    <?php foreach ($combined as $material => $amount): ?>
        <li class="material-list-item">
            <p class="material-name"><?= $material ?></p>
            <p class="material-amount"><?= $amount ?></p>
        </li>
    <?php endforeach ?>
    </ul>
</section>
<section class="instructions">
    <h2>
        作り方
    </h2>
    <ol class="instruction-list">
    <?php foreach ($steps as $step): ?>
        <li class="instruction-list-item">
            <p class="instruction-content"><?= $step ?></p>
        </li>
    <?php endforeach ?>
    </ol>
</section>
<section class="memo">
    <h2>
        メモ
    </h2>
    <p class="memo-content"><?= $memo ?></p>
</section>
</body>
</html>