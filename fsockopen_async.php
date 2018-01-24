<?php
/*利用php的系统调用，开启新的进程来实现。

php 提供了fsockopen函数，此函数的功能为初始化一个套接字连接到指定主机，默认情况下将以阻塞模式开启套接字连接。当然你可以通过stream_set_blocking()将它转换到非阻塞模式。这是关键。所以，思路就是：开启一个非阻塞的套接字连接到本机，本机收到之后作一些耗时处理。

类似这样的处理代码（文件posttest.php）：*/

$fp = fsockopen($php_Path,80);
if (!$fp) {
    LMLog::error("fsockopen:err" );
} else {
    $out = "GET /album/action/album_write_friends_thread_record.php?key=&u=   HTTP/1.1\r\n";
    $out .= "Host: ".$php_Path."\r\n";
    $out .= "Connection: Close\r\n\r\n";
    stream_set_blocking($fp,true);
    stream_set_timeout($fp,1);
    fwrite($fp, $out);
    usleep(1000);
    fclose($fp);
}

/*这里，usleep(1000) 非常关键，它能保证这个请求能发出去。*/
?>

<?php
/*我们在来看处理的代码逻辑（文件album_write_friends_thread_record.php）*/

/**
 * 客户端调用服务器接口页面
 * user: guwen
 */
sleep(20);// 睡眠20s
?>
实际上，我们服务器在执行fsockopen 那段程序时，就不会再等20s之后才能返回给客户端，而是发出这个请求之后，即返回客户端，销毁进程，而把剩余的工作交由其他进程慢慢做去，这就实现了php的异步。