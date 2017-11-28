<?php
namespace Swoole\WebSocket;
use Swoole\Http\Server as HttpServer;

/**
 * 异步非阻塞多进程 WebSocket 服务器
 * @package Swoole\WebSocket
 * @since   1.7.9
 */
class Server extends HttpServer {

    /**
     * 客户端与服务器建立连接后触发
     *
     * WebSocket 服务器已经内置 了handshake，如果用户希望自己进行握手处理
     * 可以设置 onHandShake 事件回调函数
     *
     * @optional
     * @var callback
     *
     * @example $server->on('HandShake', function(\Swoole\Http\Request $request, \Swoole\Http\Response $response){})
     */
    public $onHandShake;

    /**
     * 客户端与服务器建立连接并完成握手后会触发
     *
     * @optional
     * @var callback
     *
     * @example $server->on('Open', function(\Swoole\WebSocket\Server $server, \Swoole\Http\Request $request){})
     */
    public $onOpen;

    /**
     * 当服务器收到来自客户端的数据帧时触发
     *
     * @required
     * @var callback
     *
     * @example $server->on('Message', function(\Swoole\WebSocket\Server $server, \Swoole\WebSocket\Frame $frame){})
     */
    public $onMessage;

    /**
     * 推送数据
     *
     * @param   int         $fd         客户端连接标识符
     * @param   string      $data       要发送的数据内容。长度不得超过 2M
     * @param   int         $opCode     数据内容的格式。默认为文本。参考：WEBSOCKET_OPCODE_ 常量
     * @param   bool|true   $finish     帧是否完成
     * @return  bool
     *
     * @since   1.7.11+
     */
    public function push($fd, $data, $opCode = WEBSOCKET_OPCODE_TEXT, $finish = true){}

    /**
     * 打包消息
     *
     * @param   string      $data       消息内容
     * @param   int         $opCode     数据内容的格式。默认为文本。参考：WEBSOCKET_OPCODE_ 常量
     * @param   bool|true   $finish     帧是否完成
     * @param   bool|false  $mask       是否设置掩码
     * @return  string|bool
     */
    public function pack($data, $opCode = WEBSOCKET_OPCODE_TEXT, $finish = true, $mask = false){}

    /**
     * 解包消息
     *
     * @param   string                      $data   消息内容
     * @return  Swoole\WebSocket\Frame|bool         解析失败返回 false。解析成功返回 Swoole\WebSocket\Frame 对象
     */
    public function unpack($data){}
}