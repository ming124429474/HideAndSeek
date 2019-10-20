<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/10/20
 * Time: 11:02
 */

namespace App\Lib;


class Redis
{
    protected static $instance;
    protected static $config = [
        'host'=>'127.0.0.1',
        'port'=>6379,
        'auth'=>'developer',
        'db'=>'15',

    ];
    /**
     * 获取redis实例
     *
     * @return \Redis|\RedisCluster
     */

    public static function getInstance()
    {
        if(empty(self::$instance)){
            $instance = new \Redis();
            $instance->connect(self::$config['host'],self::$config['port']);
            if(!empty(self::$config['auth'])){
                $instance->auth(self::$config['auth']);
            }
            if(!empty(self::$config['db'])){
                $instance->select(self::$config['db']);
            }
            self::$instance = $instance;
        }
        return self::$instance;
    }
}