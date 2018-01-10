<?php
$arr = glob("C:/Users/liux/Desktop/old/*.jpg");
foreach ($arr as $k => $v) {
    $filename1 = 'C:/Users/liux/Desktop/card/20180110_' . ($k + 1) . '.jpg';
    echo $v . "----->" . $filename1 . "<br>";
    rename($v, $filename1);
}