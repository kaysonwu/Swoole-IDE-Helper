<?php
namespace Swoole\Http;
use Swoole\Server as ServerBase;

/**
 * 异步非阻塞多进程 Http 服务器
 * @package Swoole\Http
 * @since   1.7.7
 */
class Server extends ServerBase {

    /**
     * http 服务器不支持该事件注册
     *
     * @deprecated
     */
    public $onConnect;

    /**
     * http 服务器不支持该事件注册
     *
     * @deprecated
     */
    public $onReceive;

    /**
     * 当收到一个完整的 Http 请求后触发
     *
     * @var     callback
     *
     * @since   1.7.7+
     * @example $server->on('Request', function(\Swoole\Http\Request $request, \Swoole\Http\Response $response){})
     */
    public $onRequest;
}