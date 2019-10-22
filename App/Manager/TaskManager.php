<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/10/22
 * Time: 8:53
 */

namespace App\Manager;


class TaskManager
{
    const TASK_CODE_FIND_PLAYER=1; //用于发起寻找玩家task任务。

    public static function findPlayer()
    {
        $playerListLen = DataCenter::getPlayerWaitListLen();
        if($playerListLen >= 2){
            $redPlayer = DataCenter::popPlayerFromWaitList();
            $bluePlayer = DataCenter::popPlayerFromWaitList();
            return [
                'red_player'=>$redPlayer,
                'blue_player'=>$bluePlayer
            ];
        }
        return false;

    }
}