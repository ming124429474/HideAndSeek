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
    private $players = [];  //保存玩家

    public function __construct()
    {
        $this->gameMap = new Map(12,12);
    }

    public function createPlayer($playerId,$x,$y)
    {
        //创建玩家
        $player = new Player($playerId,$x,$y);
        if(!empty($this->players)){
            $player->setType(Player::PLAYER_TYPE_HIDE);
        }
        $this->players[$playerId] = $player;

    }

    public function playerMove($playerId,$direction)
    {
        $player = $this->players[$playerId];

        if($this->_canMoveToDirection($player,$direction)){
            $player->{$direction}();
        }

    }

    private function _canMoveToDirection($player,$direction)
    {
        $x = $player->getX();
        $y = $player->getY();
        $moveCoor = $this->_getMoveCoor($x,$y,$direction);
        $mapData = $this->gameMap->getMapData();
        if(!$mapData[$moveCoor[0]][$moveCoor[1]]){
            return false;
        }
        return true;
    }

    private function _getMoveCoor($x,$y,$direction)
    {
        switch ($direction){
            case Player::UP:
                return [--$x,$y];
            case Player::DOWN:
                return [++$x,$y];
            case Player::LEFT:
                return [$x,--$y];
            case Player::RIGHT:
                return [$x,++$y];
        }
        return [$x,$y];
    }

    public function isGameOver()
    {
        $res = false;

        $x = -1;
        $y = -1;
        $players = array_values($this->players);
        foreach ($players as $key => $player){
            if($key == 0){
                $x = $player->getX();
                $y = $player->getY();
            }else if($x == $player->getX() && $y == $player->getY()){
                $res = true;
            }
        }
        return $res;
    }

    public function printGameMap()
    {
        $mapData = $this->gameMap->getMapData();

        $players = [2 => '追', 3 => '躲'];

        foreach ($this->players as $player){
            $mapData[$player->getX()][$player->getY()] = $player->getType() + 1;
        }

        foreach($mapData as $row){
            foreach($row as $item){
                if($item == 0){
                    echo '墙, ';
                }else if ($item == 1){
                    echo '    ';
                }else{
                    echo $players[$item].', ';
                }
            }
            echo PHP_EOL;
        }
    }
}