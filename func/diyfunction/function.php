<?php
 //查询枚举里面的值  暂时只适用tp框架
use Think\Model;
 function selectEnum($tabname,$columns,$encode="utf-8"){  
     $Model=new Model();
     $data2=$Model->query("show columns from $tabname like '$columns'");
     $enum=$data2[0]['type'];
     $enum_arr=eXPlode("(",$enum);
     $enum=$enum_arr[1];
     $enum_arr=explode(")",$enum);
     $enum=$enum_arr[0];
     $enum_arr=explode(",",$enum);
     $arr=array();
     for($i=0;$i<count($enum_arr);$i++){
         $enum=mb_substr($enum_arr[$i],1,-1,$encode);
         $arr[]=$enum;
     }
     return $arr;
 }