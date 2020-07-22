<?php
//冒泡排序
$arr = [2,7,5,10,30,24,1,3];
//需要的冒泡轮次 len-1
//for ($i=0;$i<count($arr)-1; $i++){
//    //找出一个数需要的比较次数,len-1-已冒泡轮数$i(即已经沉底的最大值不需要在进行比较了)
//    for ($j=0;$j<count($arr)-1-$i;$j++){
//        if ($arr[$j]>$arr[$j+1]){
//            $tmp = $arr[$j];
//            $arr[$j] = $arr[$j+1];
//            $arr[$j+1] = $tmp;
//        }
//    }
//}

//选择排序:首先选出最小值与第一个位置交换，然后找出剩下的最小值与第二位交换，以此类推
//for ($j=0;$j<count($arr);$j++){
//    $minVal = $j;
//    for ($i=$j+1;$i<count($arr);$i++){
//        if ($arr[$minVal] > $arr[$i]){
//            $minVal = $i;
//        }
//    }
//    $tmp = $arr[$minVal];
//    $arr[$j] = $tmp;
//    $arr[$minVal] = $arr[$j];
//}

//快排:通常选取第一个或最后一个元素为基准值，将数组分为比基准小和比基准大的两部分，以此递归
//基准值就是排好序的正确位置，最后合并三部分即为最终结果
//function keySort($data){
//    if (count($data) <= 1){
//        return $data;
//    }
//    $baseVal = $data[0];
//    $leftArr = [];
//    $rightArr = [];
//    for ($i=0;$i<count($data);$i++){
//        if ($data[$i] < $baseVal){
//            $leftArr[] = $data[$i];
//        }
//        if ($data[$i] > $baseVal){
//            $rightArr[] = $data[$i];
//        }
//    }
//    $leftArr = keySort($leftArr);
//    $rightArr = keySort($rightArr);
//    return array_merge($leftArr, [$baseVal],$rightArr);
//}
//print_r(keySort($arr));
//$str = "abbcddde";
//$strArr = str_split($str);
//$idx = 0;
//$res = '';
//for ($i=0;$i<count($strArr);$i++){
//    if (isset($strArr[$i+1]) && $strArr[$i] == $strArr[$i+1]){
//        continue;
//    }else{
//        $res .= $strArr[$idx].($i-$idx+1);
//        $idx = $i+1;
//    }
//}
//echo $res;
//function mk($n,$m){
//    $data = range(1, $n);
//    $i = 1;//起始编号
//    while (count($data) > 1){
//        if ($i % $m != 0){
//            array_push($data, $data[$i-1]);
//        }
//        unset($data[$i-1]);
//        $i++;
//    }
//    return $data;
//}
//print_r(mk(6,8));
//实现线性表
function insertArr($val,$arr,$idx)
{
    $len = count($arr);
    for ($j=$len;$j>=$idx;$j--){
        $arr[$j]=$arr[$j-1];
    }
    $arr[$idx-1] = $val;
    return $arr;
}
print_r(insertArr(100,$arr,2));