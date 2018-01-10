<?php
$arr = glob("C:/Users/liux/Desktop/old/*.jpg");
foreach ($arr as $k => $v) {
    $filename1 = 'C:/Users/liux/Desktop/card/20180110_' . ($k + 1) . '.jpg';
    echo $v . "----->" . $filename1 . "<br>";
    rename($v, $filename1);
}


# -----------------------------------------

$dirname = 'c:/Users/liux/Desktop/card';
$handle = opendir($dirname);
while (($fn = readdir($handle)) !== false) {
    if ($fn != '.' && $fn != '..') {
        $curDir = $dirname . '/' . $fn;
        $path = pathinfo($curDir);
        if (is_dir($curDir)) {
            echo "Is dir: $path[basename]";
        } else {
            var_dump($path['basename']);
            // $newname = ???// 新名字
            // rename($curDir,$newname); 
        }
    }
}