<html>
    <head>
        <title>Rewards Automation</title>
        <meta name="viewport" content="width=640">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=uft-8">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta property="og:type" content="article">
        <meta property="og:title" content="MS Rewards(Bing Search)">
        <meta property="og:description" content="Microsoft Rewards/Bing Search Automation">
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
    <script>
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

    <style>
        *{
            text-decoration:none;
        }
        p{
            margin-block-start:10px;
            margin-block-end:10px;
        }
        #region{
            display:block;
            width:90%;
            padding:1% 5%;
            height:auto;
        }
        a.linkbutton,a.linkbuttonsp{
            display:inline-block;
            width:auto;
            min-width:30px;
            margin-right:20px;
            margin-bottom:20px;
            padding-top:14px;
            padding-bottom:14px;
            padding-left:10px;
            padding-right:10px;
            border-radius:10px;
            color:rgba(80,75,40,1.0);
            font-weight:bolder;
            text-align:center;
        }
        .bing{
            background-color:rgba(240,220,120,1.0);
        }
        .rakuten{
            background-color:rgba(241,166,166,1.0);
        }
        a.linkbutton:visited{
            background-color:rgb(230,230,230);
            color:rgba(180,180,180);
        }
        a.linkbuttonsp{
            background-color:rgba(100,150,200,0.5);
            color:rgba(30,50,65);
        }
        a.linkbuttonsp:visited{
            background-color:rgba(100,150,200,0.5);
            color:rgba(60,90,120);
        }
    </style>
</body>
</html>