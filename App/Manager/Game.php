<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/10/19
 * Time: 17:23
 */

namespace App\Manager;

use App\Model\Map;
use App\Model\Player;

class Game
{
    private $gameMap = []; //保存游戏地图
    private $player = [];  //保存玩家

    public function __construct()
    {
        $this->gameMap = new Map(12,12);
    }

    public function createPlayer($player,$x,$y)
    {

    }

    public function playerMove($player,$direction)
    {

    }
}