<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>LIST APP</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container">
      <div class="container-header">
        <h1>買い物リスト編集</h1>
      </div>
      <div class="item-form-wrapper">
        <p class="form-label"><?= $_GET['name'] ?>を変更</p>
        <form action="update.php" method="post">
          <input type="hidden" name="updateId" value="<?= $_GET['id'] ?>">
          <input class="writing" type="text" name="updateName" value="<?= $_GET['name'] ?>">
          <input type="submit" value="更新する">
        </form>
      </div>
      <a href="index.php" class="cancel-button">もどる</a>
    </div>
  </body>
</html>