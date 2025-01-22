<?php 
require_once('data.php');
?>

<!DOCTYPE html>
<html lang="ja"></html>
<html>
  <head>
    <title>Start Page</title>
    <link rel="icon" type="image/png" href="images/favicon32.png" sizes="32x32">
    <meta http-equiv="content-type" charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
    <link rel="stylesheet" href="css/stylesheet.css">
  </head>
  <body>
    <div class="container">

      <?php foreach ($bookmarks as $bookmark): ?>
        <div class="link-wrapper">
          <div class="image-wrapper">
            <a href="<?php echo $bookmark->getURL() ?>">
              <div class="circular-image">
                <img src="images/<?php echo $bookmark->getImage() ?>">
              </div>
            </a>
          </div>
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
      <div class="link-wrapper">
        <div class="image-wrapper">
          <a href="index_edit.php">
            <div class="circular-image option-image">
              <img src="images/edit_button.png">
            </div>
          </a>
        </div>
        <div class="caption">- 編集 -</div>
      </div>
      <button class="dammy-link-wrapper"></button>
    </div>

    <a href="javascript:scrollToTop()">
      <img class="scroll-btn to-top" src="images/up-96.png" alt="ページの一番上へ">
    </a>
    <a href="javascript:scrollToBottom()">
      <img class="scroll-btn to-bottom" src="images/down-96.png" alt="ページの一番下へ">
    </a>

    <script src="main.js"></script>
    
  </body>
</html>