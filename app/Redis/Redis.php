<?php

namespace App\Redis;


use Exception;
use Redis as RedisDriver;

class Redis
{

    /**
     * Redis server host address
     *
     * @var string
     */
    protected static string $host = '127.0.0.1';

    /**
     * Redis server port number
     *
     * @var int
     */
    protected static int $port = 6379;


    /**
     * Redis connection timeout
     *
     * @var float|int
     */
    protected static float|int $timeout = 0;

    /**
     * Redis Driver to connecting to server
     *
     * @var RedisDriver|null
     */
    protected static ?RedisDriver $redisDriverInstance =  null;



    /**
     * Create a new instance of redis driver
     *
     */
    public function __construct()
    {
        //
    }


    /**
     * Get or create a new instance of redis driver client
     *
     * @return RedisDriver
     */
    public static function redisClient(): RedisDriver
    {
        if (!static::$redisDriverInstance) {
            try {
                $redisClient = new RedisDriver();
                $redisClient->connect(static::$host, static::$port, static::$timeout);
                static::$redisDriverInstance = $redisClient;

            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        return static::$redisDriverInstance;
    }

    public static function get(string $key): mixed
    {
        try {
            return static::redisClient()->get($key);
        } catch (\RedisException $e) {
            echo "Error to get index form redis";
            return null;
        }
    }

    public static function exists(string $key): bool
    {
        try {
            return static::redisClient()->exists($key);
        } catch (\RedisException $e) {
            return false;
        }
    }

    public static function set(string $key , mixed $value): bool
    {
        try {
            return static::redisClient()->set($key, $value);
        } catch (\RedisException $e) {
            return false;
        }
    }


    /**
     * Increment an index in redis
     *
     * @param string $key
     * @return int
     */
    public static function increment(string $key): int
    {
        $value = self::get($key);
        $value === false ? $value = 0 : $value ++;
        self::set($key, $value);
        return $value;
    }



}