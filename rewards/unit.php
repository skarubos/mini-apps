<?php
if (!empty($_GET['unit']) && (int)$_GET['unit'] < 10) {
    $type = $_GET['type'];
    $unit = $_GET['unit'];
    $now = $_GET['now'];
    $repeat = $_GET['rpt'];
    $waitTime = $_GET['wt'];
    $type = (int)htmlspecialchars($type, ENT_QUOTES, 'UTF-8');
    $unit = (int)htmlspecialchars($unit, ENT_QUOTES, 'UTF-8');
    $now = (int)htmlspecialchars($now, ENT_QUOTES, 'UTF-8');
    $repeat = (int)htmlspecialchars($repeat, ENT_QUOTES, 'UTF-8');
    $waitTime = (int)htmlspecialchars($waitTime, ENT_QUOTES, 'UTF-8');
    if (!empty($_GET['txt'])) {
        $txt = $_GET['txt'];
        $txt = htmlspecialchars($txt, ENT_QUOTES, 'UTF-8');
    } else {
        $txt = 0;
    }
} else {
    $type = 0;
}
?>
<html>
<head>
    <title>Rewards Automation</title>
    <meta name="viewport" content="width=640">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=uft-8">
    <meta http-equiv="Cache-Control" content="no-cache">
</head>
<body>
    <div id="region">
        <h3><b>Rewards Automation (UNIT)</b></h3>
    </div>
    <div id="region">
        <p>
            <?= "Unit : " . $unit ?> <br>
            <?= "Repeat : " . $now . " / " . $repeat ?>
        </p>
    </div>

<script>
    // ランダムな数値の配列（URLのtxtから取得、要素番号の指定に利用）
    let arr = [];
    // 検索に使用する単語の配列
    let array;

    if (<?= $type ?> != 0) {
        var type = <?= $type ?>;
        var unit = <?= $unit ?>;
        var now = <?= $now ?>;
        var repeat = <?= $repeat ?>;
        var waitTime = <?= $waitTime ?>;
        if (type == 11) {
            array = ['アシガバート','アスタナ','アスマラ','アスンシオン','アディスアベバ','アテネ','アピア','アブジャ','アブダビ','アムステルダム','アルジェ','アンカラ','アンタナナリボ','アンドラ・ラ・ベリャ','アンマン','イスラマバード','ウィーン','ヴィエンチャン','ヴィクトリア','ヴィリニュス','ウィントフック','ウェリントン','ウランバートル','エレバン','オスロ','オタワ','カイロ','カストリーズ','カトマンズ','カブール','カラカス','カンパラ','キーウ','キガリ','キシナウ','ギテガ','キト','キャンベラ','キングスタウン','キングストン','キンシャサ','グアテマラシティ','クアラルンプール','クウェート','コナクリ','コペンハーゲン','ザグレブ','サナア','サラエヴォ','サンサルバドル','サンティアゴ','サントドミンゴ','サントメ','サンホセ','サンマリノ','ジュバ','ジブチ','ジャカルタ','ジョージタウン','シンガポール','スクレ','スコピエ','ストックホルム','スバ','スリジャヤワルダナプラコッテ','セントジョージズ','セントジョンズ','ソウル','ソフィア','台北','ダカール','タシュケント','ダッカ','ダブリン','ダマスカス','タラワ','タリン','チュニス','ティラナ','ディリ','ティンプー','テグシガルパ','テヘラン','東京','ドゥシャンベ','ドーハ','ドドマ','トビリシ','トリポリ','ナイロビ','ナッソー','ニアメ','ニコシア','ニューデリー','ヌアクショット','ヌクアロファ','ネピドー','バクー','バグダード','バセテール','パナマシティ','ハノイ','ハバナ','ハボローネ','バマコ','パラマリボ','ハラレ','パリ','パリキール','ハルツーム','バレッタ','バンギ','バンコク','バンジュール','バンダルスリブガワン','ビサウ','ビシュケク','平壌','ファドゥーツ','ブエノスアイレス','ブカレスト','ブダペスト','フナフティ','プノンペン','プライア','ブラザヴィル','ブラジリア','ブラチスラバ','プラハ','フリータウン','ブリッジタウン','ブリュッセル','ケープタウン','ベイルート','ベオグラード','北京','ヘルシンキ','ベルモパン','ベルリン','ベルン','ボゴタ','ポドゴリツァ','ポートオブスペイン','ポートビラ','ポートモレスビー','ポートルイス','ホニアラ','ポルトノボ','ポルトープランス','マジュロ','マスカット','マセル','マドリード','マナグア','マナーマ','マニラ','マプト','マラボ','マルキョク','マレ','ミンスク','ムババーネ','メキシコシティ','モガディシュ','モスクワ','モロニ','モンテビデオ','モンロビア','ヤウンデ','ヤムスクロ','ヤレン','ラバト','リガ','リスボン','リーブルヴィル','リマ','リヤド','リュブリャナ','リロングウェ','ルアンダ','ルクセンブルク','ルサカ','レイキャヴィーク','ロゾー','ローマ','ロメ','ロンドン','ワガドゥグー','ワシントンDC','ワルシャワ'];
            if (<?= $txt ?> == 0) {
                while(arr.length < unit){
                    let num = Math.floor(Math.random() * (array.length - 1));
                    if(arr.indexOf(num) === -1) arr.push(num);
                }
            } else {
                var txt = "<?= $txt ?>";
                console.log(typeof txt);
                for (let i = 0; i < txt.length; i += 3) {
                    let num = parseInt(txt.substring(i, i + 3), 10);
                    arr.push(num);
                }
            }
            console.log(arr);
        }
    } else {
        var type = 0;
    }
    

    // 指定ミリ秒待機
    function Sleep(wait) {
        var start = new Date();
        while (new Date() - start < wait);
    }
    // 配列の要素をランダムに並べ替え
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            let j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }
    function generateURL(type, step, now) {
        let href;
        if (type == 1 || type == 2) {
            let random = Math.floor( Math.random() * (10000 - 1000) ) + 1000;
            let key = "q=東京証券取引所+" + now + step + "+" + random;
            if (type == 1) {
                href = "https://www.bing.com/news?" + key;
            } else if (type == 2) {
                href = "https://www.bing.com/search?" + key;
            } 
            href = href + "&qs=n&form=QBRE&sp=-1&ghc=1&lq=0" + "&p" + key
        } else if (type == 11) {
            href = "https://websearch.rakuten.co.jp/Web?qt=" + array[arr[step-1]] + "&ref=top_r&col=OW";
        } else {
            href = "typeが不正です";
        }
        return href;
    }

    function OpenLinks(count){
        let tabs = [];
        let href;
        for (let step = 1; step < (count + 1); step++) {
            href = generateURL(type, step, now);

            console.log(step);
            console.log(href);

            let tab = window.open(href, step);
            tabs.push(tab);
            Sleep(waitTime);
        }
        tabs.forEach(function(tab) {
            setTimeout(() => tab.close(), 2000);
        });
    }

    window.onload = function() {
        if (type == 0) {
            alert("unitが不正です。(5以下を推奨)");
            return;
        }
        OpenLinks(unit);
    }
</script>
</body>
</html>