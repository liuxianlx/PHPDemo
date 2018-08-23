<?php
/**
 * Redis连接池
 * User: liuxian
 * Date: 2018/8/23
 * Time: 10:16
 */

class CRedis {

    private static $redis;

    public static function getRedis($db = 0, $host = '127.0.0.1', $port = 6379) {
        if (!self::$redis instanceof Redis) {
            self::$redis = self::connectRedis($host, $port);
        }
        self::$redis->select($db);
        return self::$redis;
    }

    private static function connectRedis($host, $port) {
        $redis = new Redis();
        $redis->connect($host, $port);
        return $redis;
    }
}