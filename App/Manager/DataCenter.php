<?php
namespace App\Manager;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/10/20
 * Time: 10:54
 */
use App\Lib\Redis;
class DataCenter
{
    public static $global;
    public static $server;
    const PREFIX_KEY = 'game';

    public static function log($info, $context=[], $level='INFO')
    {
        if($context){
            echo sprintf("[%s][%s]: %s %s\n", date('Y-m-d H:i:s'), $level, $info,
                json_encode($context, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        }else{
            echo  sprintf("[%s][%s]: %s\n", date('Y-m-d H:i:s'), $level, $info);
        }
    }

    public static function redis()
    {
        return Redis::getInstance();
    }

    public static function getPlayerWaitListLen()
    {
        $key = self::PREFIX_KEY . ":player_wait_list";
        return self::redis()->lLen($key);
    }

    public static function pushPlayerToWaitList($playerId)
    {
        $key = self::PREFIX_KEY . ":player_wait_list";
        self::redis()->lPush($key, $playerId);
    }

    public static function popPlayerFromWaitList()
    {
        $key = self::PREFIX_KEY . ":player_wait_list";
        return self::redis()->rPop($key);
    }

    public static function getPlayerFd($playerId)
    {
        $key = self::PREFIX_KEY . ":player_fd:" . $playerId;
        return self::redis()->get($key);
    }

    public static function setPlayerFd($playerId, $playerFd)
    {
        $key = self::PREFIX_KEY . ":player_fd:" . $playerId;
        self::redis()->set($key, $playerFd);
    }

    public static function delPlayerFd($playerId)
    {
        $key = self::PREFIX_KEY . ":player_fd:" . $playerId;
        self::redis()->del($key);
    }

    public static function getPlayerId($playerFd)
    {
        $key = self::PREFIX_KEY . ":player_id:" . $playerFd;
        return self::redis()->get($key);
    }

    public static function setPlayerId($playerFd, $playerId)
    {
        $key = self::PREFIX_KEY . ":player_id:" . $playerFd;
        self::redis()->set($key, $playerId);
    }

    public static function delPlayerId($playerFd)
    {
        $key = self::PREFIX_KEY . ":player_id:" . $playerFd;
        self::redis()->del($key);
    }

    public static function setPlayerInfo($playerId, $playerFd)
    {
        self::setPlayerId($playerFd, $playerId);
        self::setPlayerFd($playerId, $playerFd);
    }

    public static function delPlayerInfo($playerFd)
    {
        $playerId = self::getPlayerId($playerFd);
        self::delPlayerFd($playerId);
        self::delPlayerId($playerFd);
    }


    public static function setPlayerRoomId($playerId,$roomId)
    {
        $key = self::PREFIX_KEY . ':player_room_id:' . $playerId;
        self::redis()->set($key, $roomId);
    }

    public static function getPlayerRoomId($playerId)
    {
        $key = self::PREFIX_KEY . ':player_room_id:' . $playerId;
        return self::redis()->get($key);
    }

    public static function delPlayerRoomId($playerId)
    {
        $key = self::PREFIX_KEY . ':player_room_id:' . $playerId;
        self::redis()->del($key);
    }

    public static function initDataCenter()
    {
        //清空匹配队列
        $key = self::PREFIX_KEY.':player_wait_list';
        self::redis()->del($key);
        //情况玩家id
        $key  = self::PREFIX_KEY.':player_id*';
        $values = self::redis()->keys($key);
        foreach ($values as $value){
            self::redis()->del($value);
        }

        //清空玩家Fd
        $key  = self::PREFIX_KEY.':player_fd*';
        $values = self::redis()->keys($key);
        foreach ($values as $value){
            self::redis()->del($value);
        }

        //清空玩家房间ID
        $key  = self::PREFIX_KEY.':player_room_id*';
        $values = self::redis()->keys($key);
        foreach ($values as $value){
            self::redis()->del($value);
        }
    }

}