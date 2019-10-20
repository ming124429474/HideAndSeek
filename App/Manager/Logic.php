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
        DataCenter::pushPlayerToWaitList($playerId);
    }
}