<?php 
require_once('load.php');
?>

<html>
    <head>
        <title>Rewards Automation</title>
        <meta name="viewport" content="width=640">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=uft-8">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta property="og:type" content="article">
        <meta property="og:title" content="MS Rewards(Bing Search)">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
        <div id="region">
            <h3><b>Rewards Automation</b></h3>
        </div>
        <div id="region">
            <p><b>公式リンク</b></p>
            <a class="linkbuttonsp" href="https://rewards.bing.com/" target="_blank">Microsoft Rewardsトップ</a>
            <a class="linkbuttonsp" href="https://rewards.bing.com/pointsbreakdown" target="_blank">ポイント確認</a><br>
        </div>
        <div id="region">
            <p><b>まとめて検索リンク</b></p>
            <p>
            <a class="linkbutton bing" href="#5-bing" onclick="OpenLinks(2, 5)">Bing 5検索</a>
            <a class="linkbutton bing" href="#2-bing" onclick="OpenLinks(2, 2)">Bing 2検索</a>
            <a class="linkbutton bing"" href="#5-news" onclick="OpenLinks(1, 5)">ニュース5検索</a>
            <a class="linkbutton bing"" href="#2-news" onclick="OpenLinks(1, 2)">ニュース2検索</a>
            </p>
            <p>
            <a class="linkbutton rakuten" href="#5-rakuten" onclick="OpenLinks(11, 5)">楽天 5検索</a>
            <a class="linkbutton rakuten" href="#2-rakuten" onclick="OpenLinks(11, 2)">楽天 2検索</a>
            </p>
            <p>※要注意：複数のタブが順々に開きます！</p>
            <p>※ブラウザとその設定によっては開かない場合があります（ポップアップを許可=ブロック解除すれば動作する場合があります）。</p><br>
        </div>
        <button id="openTab">新しいタブを開いて5秒後に閉じる</button>

    <script>
        document.getElementById('openTab').addEventListener('click', function() {
            const newTab = window.open('https://example.com', '_blank');
            if (newTab) {
                setTimeout(() => {
                    newTab.close();
                }, 5000);
            }
        });
        // window.addEventListener('load', function() {
        //     // 2秒後に新しいタブを開く
        //     setTimeout(function() {
        //         const url = "https://www.google.com/search?q=test"; // 開きたいURL
        //         const newTab = window.open(url, '_blank');

        //         // タブが正常に開けた場合のみ閉じる処理をセット
        //         if (newTab) {
        //             setTimeout(function() {
        //                 newTab.close();
        //             }, 5000); // 5000ミリ秒 = 5秒後に閉じる
        //         } else {
        //             console.warn("新しいタブを開けませんでした（ポップアップブロックの可能性）");
        //         }
        //     }, 2000); // 2000ミリ秒 = 2秒後に開く
        // });


        // 指定ミリ秒待機
        function Sleep(wait) {
            var start = new Date();
            while (new Date() - start < wait);
        }
        function howLong(type) {
            let waitingTime;
            if (type == 1 || type == 2) {
                waitingTime = 7600;
            } else if (type == 11) {
                waitingTime = 3100;
            } else {
                waitingTime = "typeが不正です"
            }
            return waitingTime;
        }

        function OpenLinks(type, unit) {
            console.log(type);
            let waitingTime = howLong(type);
            let href = "unit.php?type=" + type + "&unit=" + unit + "&now=1&rpt=1&wt=" + waitingTime;
            console.log(href);
            let tab = window.open(href);
            setTimeout(() => {
                tab.close();
            }, waitingTime * unit + 10000);
        }
    </script>

</body>
</html>