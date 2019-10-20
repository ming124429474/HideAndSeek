<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/10/20
 * Time: 10:11
 */

require_once __DIR__.'/../vendor/autoload.php';

use App\Manager\DataCenter;
use App\Manager\Logic;
class Server
{
    const CLIENT_CODE_MATCH_PLAYER = 600;
    const HOST='0.0.0.0';
    const FRONT_PORT = 9501;
    const CONFIG = [
        'worker_num'=>4,
        'enable_static_handler'=>true,
        'document_root'=>'/data1/Test/HideAndSeek/frontend'
    ];

    private $logic;
    private $ws;

    public function __construct()
    {
        $this->logic = new Logic();
        $this->ws = new \Swoole\WebSocket\Server(self::HOST, self::FRONT_PORT);
        $this->ws->set(self::CONFIG);
        $this->ws->on('start', [$this, 'onStart']);
        $this->ws->on('workerStart', [$this, 'onWorkerStart']);
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('close', [$this, 'onClose']);
        $this->ws->start();
        $this->ws->listen(self::HOST, self::FRONT_PORT, SWOOLE_SOCK_TCP);
    }
    public function onStart($server)
    {
        swoole_set_process_name('hide-and-seek');
        echo sprintf("master start (listening on %s:%d)\n",
            self::HOST, self::FRONT_PORT);
    }

    public function onWorkerStart($server, $workerId)
    {
        echo "server: onWorkStart,worker_id:{$server->worker_id}\n";
    }

    public function onOpen($server, $request)
    {
        DataCenter::log(sprintf('client open fd：%d', $request->fd));

        $playerId = $request->get['player_id'];
        DataCenter::setPlayerInfo($playerId,$request->fd);
    }

    public function onMessage($server, $request)
    {

        DataCenter::log(sprintf('client open fd：%d，message：%s', $request->fd, $request->data));

        $data = json_decode($request->data,true);
        $playerId = DataCenter::getPlayerId($request->fd);
        switch ($data['code']){
            case self::CLIENT_CODE_MATCH_PLAYER:
                $this->logic->matchPlayer($playerId);
                break;
        }

//        $server->push($request->fd, 'test success');
    }

    public function onClose($server, $fd)
    {
        DataCenter::log(sprintf('client close fd：%d', $fd));
        DataCenter::delPlayerInfo($fd);
    }


}
new Server();