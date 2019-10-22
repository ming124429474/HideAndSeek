<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/10/22
 * Time: 9:47
 */

namespace App\Manager;

class Sender
{
    const MSG_ROOM_ID = 1001;

    const CODE_MSG = [
        self::MSG_ROOM_ID => '房间ID',
    ];

    public static function sendMessage($playerId, $code, $data = [])
    {
        $message = [
            'code'=>$code,
            'msg'=>self::CODE_MSG[$code]??'',
            'data'=>$data
        ];


        $playerFd = DataCenter::getPlayerFd($playerId);
        if(empty($playerFd)){
            return ;
        }
        DataCenter::$server->push($playerFd, json_encode($message));
    }
}