<?php
class MangaCafeFeeCalculation {
    public $entry_time;
    public $departure_time;
    public $course;

    public function __construct($entry_time, $departure_time, $course = 0) {
        $this->entry_time = $entry_time;
        $this->departure_time = $departure_time;
        $this->course = $course;
        $this->price = $this->coursePrice($course);
    }

    function coursePrice($n) {
        $courses = [
            0 => 0,
            1 => 500,
            3 => 800,
            5 => 1500,
            8 => 1900
        ];

        return $courses[$n];
    }

    function extensionPrice() {
        $seconds = $this->departure_time->getTimestamp() - $this->entry_time->getTimestamp();
        $minutes = ceil($seconds / 60);
        $interval = $minutes - $this->course * 60;
        $diff = max(0, ceil($interval / 10));

        return $diff * 100;
    }

    function midnightPrice() {
        $date = $this->entry_time->modify("-1 day");
        $entry_time_stamp = $this->entry_time->getTimestamp();
        $departure_time_stamp = $this->departure_time->getTimestamp();

        while ($date < $this->departure_time) {
            $night_start = $date->setTime(22, 0, 0);
            $night_end = $date->modify("+1 day")->setTime(5, 0, 0);

            $night_start_time_stamp = $night_start->getTimestamp();
            $night_end_time_stamp = $night_end->getTimestamp();

            // 入店時間が深夜時間帯の終了(翌朝5:00)より前 && 退店時間が深夜時間帯の開始(22:00)より後 なら深夜時間
            if ($entry_time_stamp < $night_end_time_stamp && $departure_time_stamp > $night_start_time_stamp) {
                return 1.15;
            }

            $date = $date->modify("+1 day");
        }

        return 1;
    }

    function calculatePriceExcludingTax() {
        $total_price = $this->price + $this->extensionPrice();
        $total_price = $total_price * $this->midnightPrice();

        return $total_price;
    }

    function calculatePriceTaxincluded() {
        $total_price = $this->price + $this->extensionPrice();
        $total_price = $total_price * $this->midnightPrice() * 1.1;

        return $total_price;
    }

    public function information() {
        echo "入店時間:" . $this->entry_time->format("Y-m-d H:i:s") . PHP_EOL;
        echo "退店時間:" . $this->departure_time->format("Y-m-d H:i:s") . PHP_EOL;
        echo "コース:" . $this->course . PHP_EOL;
        echo "料金:" . $this->price . "円" . PHP_EOL;
        echo "延長料金:" . $this->extensionPrice() . "円" . PHP_EOL;
        echo "深夜割増比率:" . $this->midnightPrice() . PHP_EOL;
        echo "税抜料金:" . $this->calculatePriceExcludingTax() . "円" . PHP_EOL;
        echo "税込料金:" . $this->calculatePriceTaxincluded() . "円" . PHP_EOL;
    }
}

// 標準入力余裕があれば追加
// echo "漫画喫茶へようこそ" . PHP_EOL;
// echo "利用する日付と日時を入力してください。もしも現在日時で良いのであれば'now'と入力してください。" . PHP_EOL;
// echo "例：2026-01-20、2026-10-20、now" . PHP_EOL;
// ※無効な入力の可能性もあるのでwhile文で繰り返し処理を行う。
// $date = fgets(STDIN) . PHP_EOL;
// echo $date;
// echo "コース番号を選んでください。1: 1時間500円、3: 3時間800円、5: 5時間1500円、8: 8時間1900円、何も入力がなければ10分毎の100円追加料金となります。" . PHP_EOL;
// ※無効な入力の可能性もあるのでwhile文で繰り返し処理を行う。
// $course = fgets(STDIN) . PHP_EOL;
// echo $course;

// 想定利用ケース
$user1 = new MangaCafeFeeCalculation(new DateTimeImmutable('2026-10-20 20:00:00', new DateTimeZone('Asia/Tokyo')), new DateTimeImmutable('2026-10-20 23:00:00', new DateTimeZone('Asia/Tokyo')), 3);
$user1->information();
$user2 = new MangaCafeFeeCalculation(new DateTimeImmutable('2026-10-20 02:00:00', new DateTimeZone('Asia/Tokyo')), new DateTimeImmutable('2026-10-20 07:00:00', new DateTimeZone('Asia/Tokyo')), 5);
$user2->information();
$user3 = new MangaCafeFeeCalculation(new DateTimeImmutable('2026-10-20 06:00:00', new DateTimeZone('Asia/Tokyo')), new DateTimeImmutable('2026-10-20 14:00:00', new DateTimeZone('Asia/Tokyo')), 8);
$user3->information();
$user4 = new MangaCafeFeeCalculation(new DateTimeImmutable('2026-10-20 21:00:00', new DateTimeZone('Asia/Tokyo')), new DateTimeImmutable('2026-10-21 05:00:00', new DateTimeZone('Asia/Tokyo')), 8);
$user4->information();
$user5 = new MangaCafeFeeCalculation(new DateTimeImmutable('2026-10-20 05:00:00', new DateTimeZone('Asia/Tokyo')), new DateTimeImmutable('2026-10-21 05:00:00', new DateTimeZone('Asia/Tokyo')), 8);
$user5->information();
?>
