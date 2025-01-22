<div class="menu">
    <div class="close-button"></div>
    <div class="menu-wrapper">
        <ul>
        <li id="menu-home" class="menu-text">HOME</li>
        <li id="menu-folder" class="menu-text">フォルダ</li>
        <div id="menu-headline-type" class="menu-headline-wrapper">
            <p class="menu-headline">レシピの形式</p>
            <div id="menu-icon-type" class="openbtn active"><span></span><span></span><span></span></div>
        </div>
        <li class="menu-type">
            <img class="menu-type-image" src='images/recipe-86.png'>
            Original
            <form action="index.php" method="post">
                <input type="hidden" name="type" value='allin'>
            </form>
        </li>
        <li class="menu-type">
            <img class="menu-type-image" src='images/image-81.png'>
            Image
            <form action="index.php" method="post">
                <input type="hidden" name="type" value='img'>
            </form>
        </li>
        <li class="menu-type">
            <img class="menu-type-image" src='images/url-100.png'>
            URL
            <form action="index.php" method="post">
                <input type="hidden" name="type" value='url'>
            </form>
        </li>
        <?php if ($editable) : ?>
            <div id="menu-headline-edit" class="menu-headline-wrapper active">
                <p class="menu-headline">編集</p>
                <div id="menu-icon-edit" class="openbtn active"><span></span><span></span><span></span></div>
            </div>
            <li id="menu-add" class="menu-text menu-edit">新規作成</li>
            <li id="menu-change" class="menu-text menu-edit">選択して修正</li>
            <li id="menu-delete" class="menu-text menu-edit">選択して削除</li>
        <?php endif; ?>
        </ul>
    </div>
</div>