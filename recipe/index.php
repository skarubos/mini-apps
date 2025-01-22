<?php
  require_once('php/listup.php');

  $cssLinks = array("common", "home");
  require_once('views/head.php');
?>
<body>
  <?php require_once('views/menu.php') ?>
  <div id="main-container">
    <div id="search-wrapper">
      <form action="search.php" method="post">
        <input type="text" name="query" placeholder="Search..." required>
        <button class="search-btn btn" type="submit">検索</button>
      </form>
    </div>
    
    <?php require_once('views/list_common.php') ?>

  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/menu.js"></script>
</body>
</html>
