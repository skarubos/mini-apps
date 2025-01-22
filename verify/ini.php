<?php 

/** 用意された画像数 */
$maxNumShaun = 20;
$maxNumOther = 20;

/** shaunとotherの個数比を決定 */
$min = 3; $max = 6;
$trueNum = mt_rand($min, $max);

/** 一時的な配列 */
$shaunRands = generateCode($trueNum, $maxNumShaun, 2);
$otherRands = generateCode(9-$trueNum, $maxNumOther, 2);

/** 難易度を決定して最終的な配列に格納 */
$rands = [];
foreach ($shaunRands as $element) {
  if (random_int(1,3)<=2) {
    array_push($rands, "shaun/a" . $element);
  } else {
    array_push($rands, "shaun/b" . $element);
  }
}
foreach ($otherRands as $element) {
  if (random_int(1,3)<=2) {
    array_push($rands, "other/a" . $element);
  } else {
    array_push($rands, "other/b" . $element);
  }
}

/** 配列をシャッフル */
shuffle($rands);

/* var_dump($rands); */


/** 1~$maxまでのランダムな整数値（桁数$lengthで頭を0で埋める）を返す */
function generateCode($num, $max, $length) {
  $rands = [];
  for($i = 1; $i <= $num; $i++){
    while(true){
      $rand = random_int(1, $max);                // 乱数生成
      $tmp = sprintf('%0'. $length. 'd', $rand);  // 乱数の頭0埋め
      /*
       * 乱数配列に含まれているならwhile続行、 
       * 含まれてないなら配列に代入してbreak 
       */
      if( !(in_array( $tmp, $rands, true )) ){
        array_push( $rands, $tmp );
        break;
      } 
    }
  }
  return $rands;
}
?>