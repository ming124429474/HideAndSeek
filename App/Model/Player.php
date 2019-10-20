<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/10/19
 * Time: 17:23
 */

namespace App\Model;


class Player
{
    const DIRECTION = [self::UP,self::DOWN,self::LEFT,self::RIGHT]; //随机选择数组

    const UP = 'up';
    const DOWN = 'down';
    const LEFT = 'left';
    const RIGHT = 'right';

    const PLAYER_TYPE_SEEK = 1; //找寻者
    const PLAYER_TYPE_HIDE = 2; //多藏者


    private $id; //角色唯一id
    private $x;  //角色横向移动
    private $y;  //角色纵向移动

    private $type = self::PLAYER_TYPE_SEEK;

    public function __construct($id,$x,$y)
    {
        $this->id = $id;
        $this->x = $x;
        $this->y = $y;
    }


    public function setType($type)
    {
        $this->type = $type;
    }

    public function getId()
    {
        return $this->id;
    }

    public function up()
    {
        $this->x--;
    }

    public function down()
    {
        $this->x++;
    }

    public function left()
    {
        $this->y--;
    }

    public function right(){
        $this->y++;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getX()
    {
        return $this->x;
    }

    public function getY()
    {
        return $this->y;
    }
}