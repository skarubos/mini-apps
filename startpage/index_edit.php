<?php 
require_once('data.php');
require_once('class.php');
?>

<!DOCTYPE html>
<html lang="ja"></html>
<html>
  <head>
    <title>Start Page</title>
    <link rel="icon" type="image/png" href="images/favicon32.png" sizes="32x32">
    <meta http-equiv="content-type" charset="UTF-8">
    <link rel="stylesheet" href="css/stylesheet.css">
  </head>
  <body>
    <div class="container">
      <div class="button-wrapper-top">
        <button class="home-button menu-btn btn">戻る</button>
        <button class="completion-button menu-btn btn">変更を保存</button>
      </div>  

      <?php foreach ($bookmarks as $bookmark): ?>
        <div class="link-wrapper" id="n<?= $bookmark->getID() ?>">
          <div class="image-wrapper">
            <a href="<?php echo $bookmark->getURL() ?>">
              <div class="circular-image">
                <img src="images/<?php echo $bookmark->getImage() ?>">
              </div>
            </a>
          </div>
          <a href="javascript:editThis(<?= $bookmark->getID() ?>, '<?= $bookmark->getName() ?>', '<?= $bookmark->getURL() ?>')">
            <div class="modify-btn edit-btn">
              <img src="images/edit48.png">
            </div>
          </a>
          <a href="javascript:deleteConfirm(<?= $bookmark->getID() ?>, '<?= $bookmark->getName() ?>')">
            <div class="modify-btn delete-btn">
              <img src="images/delete48.png">
            </div>
          </a>
          <div class="caption">
            <a href="<?php echo $bookmark->getURL() ?>"><?php echo $bookmark->getName() ?></a>
          </div>
        </div>
      <?php endforeach ?>

      <div class="link-wrapper">
        <div class="image-wrapper">
          <a href="add_bookmark.php">
            <div class="circular-image option-image">
              <img src="images/add_button.png">
            </div>
          </a>
        </div>
        <div class="caption">- 追加 -</div>
      </div>

      <div class="button-wrapper-bottom">
        <button class="dammy-btn"></button>
        <button class="home-button menu-btn btn">戻る</button>
        <button class="completion-button menu-btn btn">変更を保存</button>
      </div>  
    </div>

    <a href="javascript:scrollToTop()">
      <img class="scroll-btn to-top" src="images/up-96.png" alt="ページの一番上へ">
    </a>
    <a href="javascript:scrollToBottom()">
      <img class="scroll-btn to-bottom" src="images/down-96.png" alt="ページの一番下へ">
    </a>

    <div id="dark-layer" class="hidden"></div>

    <div id="delete-popup" class="hidden">
      <div class="popup-txt-wrapper">
        <h3>本当に削除しますか？</h3>
        <p id="delete-name"></p>
        <p>(ID:<span id="delete-id"></span>)</p>
      </div>
      <button class="return-button popup-btn btn">戻る</button>
      <button class="delete-button popup-btn btn">削除する</button>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script src="main.js"></script>
  </body>
</html>