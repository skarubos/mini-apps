<?php
// フォームから送信されたクエリを取得
$query = $_POST['query'];

require_once('php/mySQL.php');

$sql = "SELECT id, name, img_name, mat1, mat2, mat3, mat4, mat5, mat6, type, url, img_full, table_name FROM $tablename
        WHERE `name` LIKE '%$query%' OR `mat1` LIKE '%$query%' OR `mat2` LIKE '%$query%' OR `mat3` LIKE '%$query%' OR `mat4` LIKE '%$query%' OR `mat5` LIKE '%$query%' OR `mat6` LIKE '%$query%'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("MySQLでエラーが発生しました: " . mysqli_error($conn));
}

require_once('php/make_instance.php');

$cssLinks = array("common", "home");
require_once('views/head.php');
?>

<body>
  <?php require_once('views/menu.php') ?>

  <div id="main-container">
    <div id="search-wrapper">
      <form action="search.php" method="post">
        <input type="text" name="query" placeholder=<?= $query ?> required>
        <button class="search-btn btn" type="submit">検索</button>
      </form>
    </div>
    
    <?= require_once('views/list_common.php') ?>
    
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/menu.js"></script>
</body>
</html>
