<?php

require_once('php/mySQL.php');

// 修正の場合、元のデータを読み込み
$inputs = array();
if (!empty($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT id, name, img_name, mat1, mat2, mat3, mat4, mat5, mat6, type, url, img_full, table_name, folder, priority FROM main WHERE id='$id'";
  $result = mysqli_query($conn, $sql);
  if (!$result) {
      die("MySQLでエラーが発生しました: " . mysqli_error($conn));
  }
  $row = mysqli_fetch_assoc($result);
  $inputs = array(
      "TF" => true,
      "id" => $row["id"],
      "name" => $row["name"],
      "img_name" => $row["img_name"],
      "mat1" => $row["mat1"],
      "mat2" => $row["mat2"],
      "mat3" => $row["mat3"],
      "mat4" => $row["mat4"],
      "mat5" => $row["mat5"],
      "mat6" => $row["mat6"],
      "type" => $row["type"],
      "url" => $row["url"],
      "img_full" => $row["img_full"],
      "table_name" => $row["table_name"],
      "folder" => $row["folder"],
      "priority" => $row["priority"]
  );
  $inputs["tmp"] = $inputs["type"];
} else {
  // デフォルトのレシピ情報を指定(新規作成の時に適用)  
  $inputs["TF"] = false;
  $inputs["type"] = "url";
  $inputs["folder"] = 0;
  $inputs["priority"] = 1;
}

require_once('php/get_folders.php');
mysqli_close($conn);

$cssLinks = array("common", "add");
require_once('views/head.php');
?>

<body>
  <div class="top-wrapper">
    <h1 class="title">レシピを<?= empty($_GET['id']) ? "追加" : "編集" ?></h1>
    <div class="type-selector-wrapper">
      <button id="allin-selector" class='type-item type-allin <?= $inputs["type"]=="allin" ? "pressed" : "" ?>' type="button">Original</button>
      <button id="image-selector" class='type-item type-image <?= $inputs["type"]=="img" ? "pressed" : "" ?>' type="button">Image</button>
      <button id="url-selector" class='type-item type-url <?= $inputs["type"]=="url" ? "pressed" : "" ?>' type="button">URL</button>
    </div>
  </div>
  
  <form action="php/add_item.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="previous-id" value='<?= $inputs["TF"] ? $inputs["id"] : null ?>'>
    <input type="hidden" name="previous-type" value='<?= $inputs["TF"] ? $inputs["type"] : null ?>'>
    <input id="recipe-type" type="hidden" name="recipe-type" value='<?= $inputs["type"] ?>'>
    <div class="main-wrapper">
      <div class="input-wrapper">
        <p class="legend">レシピ名</p>
        <input type="text" name="recipe-name" value='<?= isset($inputs["name"]) ? $inputs["name"] : "" ?>' required>
      </div>
      <div class="input-wrapper">
        <p class="legend">完成写真</p>
        <input type="file" name="recipe-image">
      </div>
      <div class="input-wrapper">
        <div class="material-legend-wrapper">
          <p class="legend legend-main">メインの材料</p>
        </div>
        <div class="material-input-wrapper">
          <input type="text" class="material-input" name="mat1" placeholder="1" value='<?= isset($inputs["mat1"]) ? $inputs["mat1"] : "" ?>'>
          <input type="text" class="material-input" name="mat2" placeholder="2" value='<?= isset($inputs["mat2"]) ? $inputs["mat2"] : "" ?>'>
          <input type="text" class="material-input" name="mat3" placeholder="3" value='<?= isset($inputs["mat3"]) ? $inputs["mat3"] : "" ?>'>
          <input type="text" class="material-input" name="mat4" placeholder="4" value='<?= isset($inputs["mat4"]) ? $inputs["mat4"] : "" ?>'>
          <input type="text" class="material-input" name="mat5" placeholder="5" value='<?= isset($inputs["mat5"]) ? $inputs["mat5"] : "" ?>'>
          <input type="text" class="material-input" name="mat6" placeholder="6" value='<?= isset($inputs["mat6"]) ? $inputs["mat6"] : "" ?>'>
        </div>
      </div>
      <div id="h-url" class='input-wrapper <?= $inputs["type"]=="url" ? "" : "hidden" ?>'>
        <p class="legend">URL</p>
        <input type="text" name="recipe-url" value='<?= isset($inputs["url"]) ? $inputs["url"] : "" ?>'>
      </div>
      <div id="h-img" class='input-wrapper <?= $inputs["type"]=="img" ? "" : "hidden" ?>'>
        <p class="legend">レシピ画像</p>
        <input type="file" name="recipe-image-full">
      </div>
      <div id="detail-container" class='<?= $inputs["type"]=="allin" ? "" : "hidden" ?>'>
        <div class="detail-section-wrapper">
          <p class="detail-title">レシピの詳細</p>
          <input type="text" class="input-howmany" name="howmany" value="2人分">
          <p class="detail-howmany legend">(例：○人分,○食分)</p>
        </div>
        <div class="detail-section-wrapper">
          <p class="legend-material legend">材料</p>
          <p class="legend-amount legend">分量</p>
          <div class="material-wrapper">
            <input type="text" class="input-material" name="dmat1">
            <input type="text" class="input-amount" name="damo1">
          </div>
          <div class="material-wrapper">
            <input type="text" class="input-material" name="dmat2">
            <input type="text" class="input-amount" name="damo2">
          </div>
          <button id="add-material" class="add-input" type="button">+</button>
        </div>
        <div class="detail-section-wrapper">
          <p class="legend-step legend">作り方</p>
          <input type="text" class="input-step" name="step1">
          <input type="text" class="input-step" name="step2">
          <button id="add-step" class="add-input" type="button">+</button>
        </div>
        <div class="detail-section-wrapper">
          <p class="legend-memo legend">メモ</p>
          <textarea name="memo" rows="3" class="textarea-memo"></textarea>
        </div>
      </div>
      <div class="input-wrapper">
        <p class="legend">表示優先度</p>
        <select name="priority">
          <option value="1" <?= $inputs["priority"]==1 ? "selected" : "" ?>>普通</option>
          <option value="2" <?= $inputs["priority"]==2 ? "selected" : "" ?>>優先</option>
          <option value="3" <?= $inputs["priority"]==3 ? "selected" : "" ?>>最優先</option>
        </select>
      </div>
      <div class="input-wrapper">
        <p class="legend">フォルダ</p>
        <select name="folder">
          <option value="0" selected>なし</option>
          <?php foreach ($folders as $folder): ?>
          <option value='<?= $folder["id"] ?>' <?= $inputs["folder"]==$folder["id"] ? "selected" : "" ?>><?= $folder["name"] ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>
    

    <div class="submit-wrapper">
      <button id="return-button" type="submit">戻る</button>
      <button class='submit-button <?= empty($inputs["id"]) ? "" : "hidden" ?>' type="submit" name="submit" value="add">新規作成</button>
      <button class='submit-button <?= empty($inputs["id"]) ? "hidden" : "" ?>' type="submit" name="submit" value="edit">編集</button>
    </div>
  </form>

  <script src="js/add.js"></script>
  <?= "<script>console.log(" . json_encode($inputs) . ")</script>"; ?>
</body>
</html>

