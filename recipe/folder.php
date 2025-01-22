<?php
  require_once('php/mySQL.php');
  require_once('php/get_folders.php');

  $cssLinks = array("common", "folder");
  require_once('views/head.php');
?>
<body>
  <?php require_once('views/menu.php') ?>
  <div class="folder-items">
    <?php foreach ($folders as $folder): ?>
      <div class="folder-item">
      <form action="index.php" method="post">
        <p><?= $folder["name"] ?></p>
        <input type="hidden" name="folder" value='<?= $folder["name"] ?>'>
        <input type="hidden" name="folder-id" value='<?= $folder["id"] ?>'>
      </form>
      </div>
    <?php endforeach ?>
    <img id="button-add-folder" src="images/add_button.png">
  </div>
  <div id="dark-layer" class="hidden">
    <div class="popup popup-folder">
      <img id="button-close" src="images/close_black.png">
      <h2>フォルダを作成</h2>
      <form action="php/add_folder.php" method="post">
        <input type="text" name="folder-name" required>
        <div class="popup-button-wrapper">
          <button class='submit-button' type="submit">作成</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/menu.js"></script>
  <script>
    $(document).ready(function() {
      // 要素ごとにフォームを送信させる処理
      $('.folder-item').on('click', function() {
        $(this).find('form').submit();
      });

      // フォルダ追加のポップアップ表示・非表示
      const $darkLayer = $('#dark-layer');
      $('#button-add-folder').on('click', function() {
        $darkLayer.removeClass('hidden');
      });
      $('#button-close').on('click', function() {
        $darkLayer.addClass('hidden');
      });
      $darkLayer.on('click', function(event) {
        if (event.target === this) {
          $darkLayer.addClass('hidden');
        }
      });
    });
  </script>
</body>
</html>

