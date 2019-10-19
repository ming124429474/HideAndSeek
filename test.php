<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/10/19
 * Time: 17:22
 */
$redId = "red_player";
$blueId = "blue_player";
//创建游戏控制器
$game = new Game();
//添加玩家
$game->createPlayer($redId, 6, 1);
//添加玩家
$game->createPlayer($blueId, 6, 10);
//移动坐标
$game->playerMove($redId, 'up');