<?php
/**
 * Created by PhpStorm.
 * User: liuxian
 * Date: 2018/1/24
 * Time: 13:43
 */

function fs(){
    $fs = fsockopen("m.tdamm.com",80);
    if(!$fs){
        echo "fscokeopen erroe";
    }else{
        $out = "GET /test/worker  HTTP/1.1\r\n";
        $out .= "Host: m.tdamm.com\r\n";
        $out .= "Connection: Close\r\n\r\n";
        stream_set_blocking($fs,true);
        stream_set_timeout($fs,1);
        fwrite($fs, $out);
        usleep(1000);
        fclose($fs);
    }
}

function fp(){
    $i = 0;
    while ($i < 10) {
        fs();
        $i++;
    }
    echo "ok";
}