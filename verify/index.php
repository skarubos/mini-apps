<?php 
require('ini.php');
?>

<!DOCTYPE html>
<html lang="ja"></html>
<html>
  <head>
    <title>画像認証</title>
    <link rel="icon" type="image/png" href="images/favicon32.png" sizes="32x32">
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
    <link rel="stylesheet" href="stylesheet.css">
    <script src="main.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="order-wrapper">
        <h2 id="txt-big">ショーン</h2>
        <h4 id="txt-small">の画像をすべて選択してください。</h4>
      </div>
      <div class="panel-wrapper">
      <?php for ($i=0; $i<9; $i++): ?>
        <div class="panel-item <?= substr($rands[$i], 0, 5) ?> no<?= substr($rands[$i], -2) ?>">
          <img src="images/<?= $rands[$i] ?>.jpg" class="panel-img">
          <img src="images/check01.png" class="check-mark hidden">
          <a href="javascript:showImg('<?= substr($rands[$i], 0, 5) . substr($rands[$i], -2) ?>')">
            <div class="hidden overlay" id="<?= substr($rands[$i], 0, 5) . substr($rands[$i], -2) ?>"></div>
          </a>
        </div>
      <?php endfor ?>
      </div>
      <div class="bottom-wrapper">
        <a class="reload-btn" href="index.php">
          <img src="images/reload.png">
        </a>
        <a class="submit-btn" href="javascript:clickConfirm()">確認</a>
      </div>
    </div>
    <div id="dark-layer" class="hidden"></div>
    <?php for ($i=0; $i<9; $i++): ?> 
    <?= '<div class="full-img hidden" id="div-' . substr_replace($rands[$i], '', 5, 2) . '">' ?>
      <a href="javascript:closeImg('<?= substr($rands[$i], 0, 5) . substr($rands[$i], -2) ?>')">
        <img id="<?= substr_replace($rands[$i], '', 5, 2) ?>" src="imagesfull/<?= substr_replace($rands[$i], '', 6, 1) ?>.jpg">
      </a>
    <?= '</div>' ?>
    <?php endfor ?>
    <div id="popup-window" class="hidden">
      <div class="popup-txt-wrapper">
        <h3> 9問中  <strong id="answer"></strong> 問正解</h3>
        <span>青枠で囲まれたパネルが「ショーン」です。</span>
      </div>
      <a href="javascript:closePopup()">
        <div class="popup-btn">答えを見る</div>
      </a>
    </div>
  </body>
</html>