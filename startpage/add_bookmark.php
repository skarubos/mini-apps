<?php 

// 新規作成か編集か（'hidden-id'の有無で）場合分け
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['hidden-id'])) {
  //「編集」の処理
  // Connect to MySQL database
  require_once("../connect.php");
  $mysqli = new mysqli($host, $username, $password, $dbname);

  // Get file details
  $id = $_POST['hidden-id'];
  $name = $_POST["txt-name"];
  $url = $_POST["txt-url"];
   
  // Update MySQL database
  $stmt = $mysqli->prepare("UPDATE bookmarks SET name = ?, link_url = ? WHERE id = ?");
  $stmt->bind_param('ssi', $name, $url, $id);
  $stmt->execute();
  if ($stmt->errno) {
    die('Failed to update bookmarks: ' . $stmt->error);
  }

  $stmt->close();
  $mysqli->close();

  header('Location: index.php');

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
  //「新規作成」の処理
  // Connect to MySQL database
  require_once("../connect.php");

  // Get file details
  $fileName = $_FILES['image']['name'];
  $fileTmpName = $_FILES['image']['tmp_name'];
  $fileSize = $_FILES['image']['size'];
  $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  $name = $_POST["txt-name"];
  $url = $_POST["txt-url"];

  
  // Set folder where uploaded files will be saved
  $targetDir = 'images/';
  
  // Set allowed file extensions
   $allowedExt = array("jpg", "jpeg", "png");

  if(in_array($fileExt, $allowedExt)) {
    if($fileSize > 50000) {
      echo "画像の容量が大きすぎます(最大50KB)";
      exit;
    }
  } else {
    echo "ファイルの拡張子が不適切です(許可：.png .jpg .jpeg)";
    exit;
  }

  // Generate a unique name for the uploaded file
  $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  $fileNewName = uniqid('', true) . '.' . $fileExt;
  $targetFile = $targetDir . $fileNewName;
  
  // Upload file to server
  if (move_uploaded_file($fileTmpName, $targetFile)) {
    
    // Store file details in MySQL database
    $sql = "INSERT INTO bookmarks (name, link_url, img_name) VALUES ('$name', '$url', '$fileNewName')";
    mysqli_query($conn, $sql);
  } else {
    echo "Error uploading file.";
    exit;
  }
  
  // Close MySQL connection
  mysqli_close($conn);

  // Redirect the user to a specific page
  header('Location: index.php');

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  echo "入力を確認してください";
}
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
    <div id="dark-layer"></div>
    <div class="popup-window">
      <div class="popup-wrapper">
        <h2 id="popup-title"> 新規ブックマークを追加</h2>
        <form method="POST" enctype="multipart/form-data">
          <input type="hidden" id="hidden-id" name="hidden-id">
          <p class="popup-txt">名前</p>
          <input class="popup-input" type="text" id="txt-name" name="txt-name">
          <p class="popup-txt">URL</p>
          <input class="popup-input" type="text" id="txt-url" name="txt-url">
          <p class="popup-txt">サムネイル画像<span> (最大50KB)</soan></p>
          <input id="image-input" type="file" name="image">
          <p id="image-caution" class="hidden">(変更する場合は削除してから新たに作成してください。)</p>
          <a id="return-link" href="index.php">
            <div class="popup-btn btn" id="return-btn">戻る</div>
          </a>
          <input class="popup-btn btn" id="submit-btn" type="submit" value="完了">
        </form>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script>
      $(function() {
        var params = new URLSearchParams(window.location.search);
        //「編集」の場合、HTMLを書き換え
        if (params.has('id')) {
          var id = parseInt(params.get('id'));
          var name = params.get('name');
          var url = params.get('url');
          document.getElementById("hidden-id").value = id;
          document.getElementById("txt-name").value = name;
          document.getElementById("txt-url").value = url;
          document.getElementById("popup-title").textContent = "ブックマークを編集";
          document.getElementById('image-caution').classList.remove("hidden");
          document.getElementById("image-input").classList.add("hidden");
          document.getElementById("return-link").setAttribute('href', 'index_edit.php');
        }
      });
    </script>
  </body>
</html>