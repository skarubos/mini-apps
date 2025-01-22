<?php 
require_once('../connect.php');
require_once('data.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>LIST APP</title>
    <link rel="stylesheet" href="style.css">
    <script src=""></script>
  </head>
  <body>
    <div class="container">
      <div class="container-header">
        <a href="new.php" class="new-button">+ 新規登録</a>
      </div>
      <div class="index-table-wrapper">
        <div class="table-head">
          <span>Shopping List</span>
        </div>
        <ul class="table-body">
          <?php foreach ($shoppings as $shopping): ?>
            <li id="li<?= $shopping->getID() ?>" class="">
              <div class="item-menu item-edit">
                <img class="icon-pen" src="images/pen-solid.svg">
                <a href="edit.php?id=<?= $shopping->getID() ?>&name=<?= $shopping->getName() ?>"></a>
              </div>
              <div class="item-data">
                <?php 
                  if (mb_strlen($shopping->getName()) > 10) {
                    echo '<div class="name-txt longest-txt">';
                  } elseif (mb_strlen($shopping->getName()) > 7) {
                    echo '<div class="name-txt long-txt">';
                  } else {
                    echo '<div class="name-txt">';
                  }
                ?>
                  <?= $shopping->getName() ?>
                </div>
                <div class="date-txt"><?= $shopping->getDate() ?></div>
              </div>
              <div class="item-menu">
                <img class="icon-shopping" src="images/cart-arrow-down-solid.svg">
                <a class="item-delete" id="id<?= $shopping->getID() ?>"></a>
              </div>
            </li>
          <?php endforeach ?>
        </ul>
        <div class="dammy-bottom"></div>
      </div>
    </div>
    <a href="new.php" class="new-button-circle">+</a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
      $(function () {
        //「削除」の処理
        $('.item-delete').click(function(event) {
          event.preventDefault();
          // クリックされたアイテムのidを取得
          var itemId = event.target.id.substring(2);
          
          $.ajax({
            url: "item_delete.php",
            type: 'POST',
            data: { itemID: itemId },
            timeout: 10000,
            dataType: 'text'
          })
          .then(function(data) {
            //　<li>タグにクラス"hidden"を追加して非表示に（再読み込みより楽？）
            document.getElementById('li' + itemId).classList.add("hidden");
          })
          .catch(function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX request failed: " + textStatus + ", " + errorThrown);
            alert("削除に失敗しました。");
          });
        });
      });
    </script>
  </body>
</html>