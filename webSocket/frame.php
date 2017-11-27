<?php
namespace Swoole\WebSocket;

/**
 * WebScoket 数据帧
 * @package Swoole\WebSocket
 */
class Frame {

    /**
     * 客户端的 Socket Id。使用 push 推送数据时需要用到
     *
     * @var int
     */
    public $fd;

    /**
     * 数据内容。可以是文本内容也可以是二进制数据。可以通过 opCode 的值来判断
     * 如果是文本类型，编码格式必然是 UTF-8，这是 WebSocket 协议规定的
     *
     * @var string
     */
    public $data;

    /**
     * 数据内容格式
     *
     * @see WEBSOCKET_OPCODE 常量
     * @var int
     */
    public $opCode;

    /**
     * 数据帧是否完整
     * 一个 WebSocket 请求可能会分成多个数据帧进行发送
     *
     * @var bool
     */
    public $finish;
}