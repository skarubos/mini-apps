<?php
  if (empty($recipes)) {
    echo '<p class="search-result-text">検索結果：0件</p>';
  }
?>
<div id="recipe-items">
<form action="php/delete.php" method="post">
    <?php foreach ($recipes as $recipe): ?>
      <div class="recipe-item clearfix">
        <a class='link-recipe center' href='<?php 
            if ($recipe instanceof Allin) { 
              echo "show.php?table=".$recipe->getTable()."&name=".$recipe->getName()."&image=".$recipe->getImage();
            } elseif ($recipe instanceof Image) { 
              echo "images/full/".$recipe->getImageFull();
            } elseif ($recipe instanceof URL) {
              echo $recipe->getURL();
            } 
          ?>' data-id='<?= $recipe->getID() ?>'>
          <img src='<?= "images/".$recipe->getImage() ?>' class="recipe-img">
          <div class="text-wrapper">
            <h2 class="recipe-neme"><?= $recipe->getName() ?></h2>
            <img class="recipe-type" src='images/<?php 
                if ($recipe instanceof Allin) { 
                  echo "recipe-86";
                } elseif ($recipe instanceof Image) { 
                  echo "image-81";
                } elseif ($recipe instanceof URL) {
                  echo "url-100";
                }
              ?>.png'>
            <?php $mains = $recipe->getMain(); ?>
            <?php foreach ($mains as $material): ?>
              <div class="material-wrapper"><?= $material ?></div>
            <?php endforeach ?>
          </div>
        </a>
        <input type="checkbox" name="delete[]" class="checkbox-delete hidden" value="<?= $recipe->getID() ?>">
      </div>
    <?php endforeach ?>
    <div id="dark-layer" class="hidden">
      <div class="popup delete-confirm">
        <h2>選択した項目を<br>削除しますか？</h2>
        <div class="popup-button-wrapper">
          <div id="popup-return-button" class="btn">戻る</div>
          <button class='submit-button delete-button' type="submit">削除</button>
        </div>
      </div>
    </div>
</form>
</div>
<div id="edit-wrapper" class="hidden">
  <p id="edit-caption" class="hidden">修正するレシピを選択</p>
  <div id="confirm-button" class="btn">選択項目を削除</div>
  <div id="cancel-button" class="btn">キャンセル</div>
</div>