$(document).ready(function() {
    // メニューの表示・非表示の動作
    let start_x = null;
    $(document).on('touchstart', function(e) {
        start_x = e.touches[0].clientX;
    });
    $(document).on('touchend', function(e) {
        let end_x = e.changedTouches[0].clientX;
        if (start_x && end_x - start_x > 100) {
            $('.menu').css('left', '0');
        } else if (start_x && start_x - end_x > 100) {
            $('.menu').css('left', '-70%');
        }
    });
    $('.close-button').on('click', function() {
        $('.menu').css('left', '-70%');
    });

    // メニューのリンク
    $('.menu-type').each(function() {
        $(this).on('click', function() {
            $(this).find('form').submit();
        });
    });
    var menuItems = [
        {id: 'menu-home', href: 'index.php'},
        {id: 'menu-folder', href: 'folder.php'},
        {id: 'menu-add', href: 'add.php'}
    ];
    menuItems.forEach(function(item) {
        var $element = $('#' + item.id);
        $element.on('click', function() {
            window.location.href = item.href;
        });
    });


    // メニューリストの表示・非表示
    // レシピの形式のリスト
    let hiddenType = false;
    $('#menu-headline-type').on('click', function() {
        $('#menu-icon-type').toggleClass('active');
        let menuItems = $('.menu-type');
        menuItems.css('transition', 'all 0.5s ease-out');
        menuItems.css({
            height: hiddenType ? '' : '0',
            opacity: hiddenType ? '' : '0',
            padding: hiddenType ? '' : '0',
            margin: hiddenType ? '' : '0'
        });
        hiddenType = !hiddenType;
    });
    // 編集のリスト
    let hiddenEdit = false;
    $('#menu-headline-edit').on('click', function() {
        $('#menu-icon-edit').toggleClass('active');
        let menuItems = $('.menu-edit');
        menuItems.css('transition', 'all 0.5s ease-out');
        menuItems.css({
            height: hiddenEdit ? '' : '0',
            opacity: hiddenEdit ? '' : '0',
            padding: hiddenEdit ? '' : '0',
            margin: hiddenEdit ? '' : '0'
        });
        hiddenEdit = !hiddenEdit;
    });


    // 「選択して修正」「選択して削除」の処理
    const $menu = $('.menu');
    const $recipeItems = $("#recipe-items");
    const $searchWrapper = $('#search-wrapper');
    const $editWrapper = $('#edit-wrapper');
    const $confirmButton = $('#confirm-button');
    const $editCaption = $('#edit-caption');
    const $linkRecipeElements = $(".link-recipe");
    const $checkboxElements = $(".checkbox-delete");
    const $darkLayer = $('#dark-layer');

    // 編集用画面への切替
    function toggleEditMenu() {
        $recipeItems.css('marginTop', '90px');
        $searchWrapper.toggleClass("hidden");
        $editWrapper.toggleClass("hidden");
    }
    // 「選択して修正」が押された時
    $("#menu-change").on("click", function() {
        if (!window.matchMedia('(min-width: 835px)').matches) {
            $menu.css('left', '-70%');
        }
        if ($editWrapper.hasClass('hidden')) {
            toggleEditMenu();
        }
        $confirmButton.addClass("hidden");
        $editCaption.removeClass("hidden");
        $linkRecipeElements.each(function() {
            let originalHref = $(this).attr('href');
            $(this).attr('data-href', originalHref);
            let dataId = $(this).attr('data-id');
            $(this).attr('href', 'add.php?id=' + dataId);
        });
    });
    // 「選択して削除」が押された時
    $("#menu-delete").on("click", function() {
        if (!window.matchMedia('(min-width: 835px)').matches) {
            $menu.css('left', '-70%');
        }
        if ($editWrapper.hasClass('hidden')) {
            toggleEditMenu();
        }
        $confirmButton.removeClass("hidden");
        $editCaption.addClass("hidden");
        $checkboxElements.each(function() {
            $(this).removeClass("hidden");
        });
    });
    // キャンセルボタンが押された時
    $("#cancel-button").on("click", function() {
        toggleEditMenu();
        $recipeItems.css('marginTop', '10px');
        $linkRecipeElements.each(function() {
            let originalHref = $(this).attr('data-href');
            $(this).attr('href', originalHref);
            $(this).removeAttr('data-href');
        });
        $checkboxElements.each(function() {
            $(this).addClass("hidden");
        });
    });
    // 削除確認のポップアップ表示・非表示
    $("#confirm-button").on("click", function() {
        $darkLayer.removeClass("hidden");
        $editWrapper.addClass("hidden");
        $(window).scrollTop(0);
    });
    $("#popup-return-button").on("click", function() {
        $darkLayer.addClass("hidden");
        $editWrapper.removeClass("hidden");
    });
});