<?php

class Cache
{
    private static Redis $redis;

    /**
     * @throws Exception
     */
    public static function connect(): void
    {
        try {
            if (empty(self::$redis)) {
                self::$redis = new Redis();
                self::$redis->connect(app::$redis['host'], app::$redis['port']);
                if (isset(app::$redis['password']) && app::$redis['password'] != '') {
                    self::$redis->auth(app::$redis['password']);
                }
            }
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    public static function set($key, $value, $timeout = null): void
    {
        try {
            self::connect();
            self::$redis->set($key, $value, $timeout);
        } catch (Exception $e) {
        }
    }

    public static function get($key){
        try {
            self::connect();
            return self::$redis->get($key);
        } catch (Exception $e) {
        }
        return false;
    }

    public static function mget($keys): array|bool|Redis
    {
        try {
            self::connect();
            return self::$redis->mGet($keys);
        } catch (Exception $e) {
        }
        return false;
    }

    public function keys($pattern): bool|array|Redis
    {
        try {
            self::connect();
            return self::$redis->keys($pattern);
        } catch (Exception $e) {
        }
        return false;
    }

    public static function setFileCache($key,$value): void
    {
        file_put_contents('cache/'.$key, $value);
    }

    public static function getFileCache($key): bool|string
    {
        $contents = file_get_contents('cache/' . $key);
        return $contents;
    }

}