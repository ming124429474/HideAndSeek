<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/10/20
 * Time: 10:54
 */

namespace App\Manager;

use App\Manager\DataCenter;

class Logic
{
    public function matchPlayer($playerId)
    {
        //将用户放入队列中
        DataCenter::pushPlayerToWaitList($playerId);

        //发起一个task尝试匹配
        //swoole_server->task(xxx);
        $server = DataCenter::$server;
        $server->task(['code'=>TaskManager::TASK_CODE_FIND_PLAYER]);
    }

    public function createRoom($redPlayer, $bluePlayer)
    {
        $roomId = uniqid('room_');
        $this->bindRoomWorker($redPlayer,$roomId);
        $this->bindRoomWorker($bluePlayer,$roomId);

    }

    private function bindRoomWorker($playerId, $roomId)
    {
        $playerFd = DataCenter::getPlayerFd($playerId);
        DataCenter::$server->bind($playerFd,crc32($roomId));
//        DataCenter::$server->push($playerId,$roomId);
        Sender::sendMessage($playerId,Sender::MSG_ROOM_ID,['room_id'=>$roomId]);
    }
}