<?php
/**
 * Created by PhpStorm.
 * User: liuxian
 * Date: 2018/1/24
 * Time: 13:44
 */
function worker(){
    sleep(20);
    $this->logging->write_log("php_async", microtime(true));
}
