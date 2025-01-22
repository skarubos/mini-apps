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
        <h1>買い物リスト作成</h1>
      </div>
      <div class="item-form-wrapper">
        <p class="form-label">買うもの</p>
        <form action="update.php" method="POST">
          <input class="writing" type="text" name="newName">
          <input type="submit" value="作成する">
        </form>
      </div>
      <a href="index.php" class="cancel-button"></span>もどる</a>
    </div>
  </body>
</html>