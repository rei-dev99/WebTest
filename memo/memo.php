<?php
// クラス名:パスカルケース YamadaTaro
// メソッド名:キャメルケース yamadaTaro()
// 変数名:スネークケース $yamada_taro

// DateTimeImmutableはイミュータブル（不変）
$entry = new DateTimeImmutable();
// PHPでは文字列を+(プラス)でなく.(ドット)で繋ぐ、改行はPHP_EOL、出力はecho
echo $entry->format("Y-m-d H:i:s") . PHP_EOL;

// 0:00に揃える、メソッドチェーンでsetTime使用しその日付の日時を変更
echo $entry->setTime(0, 0, 0)->format("Y-m-d H:i:s") . PHP_EOL;

// modifyで日付や時間の増減を行う
$departure = $entry->modify("+1 hours +30 minutes");
echo $departure->format("Y-m-d H:i:s") . PHP_EOL;

// 差分出力はdiff
$interval = $entry->diff($departure);
echo $interval->format('%a日 %h時間 %i分 %s秒') . PHP_EOL;

// gettypeで型の出力
echo gettype($interval->format("%i"));

// getTimestampで日時を秒数に変換
$seconds = $departure->getTimestamp() - $entry->getTimestamp();
echo $seconds . PHP_EOL;

// 型キャスト、組み込み関数
$minutes = (int) ceil($seconds / 60);
echo $minutes . PHP_EOL;

echo $entry->getTimestamp();
?>

<!-- 参考 -->
<!-- https://recursionist.io/dashboard/course/38/lesson/1546 -->
<!-- https://www.php.net/manual/ja/datetimeimmutable.settime.php -->
<!-- https://paiza.jp/works/reference/article-php-datetimeimmutable#h5e3379beb4 -->
