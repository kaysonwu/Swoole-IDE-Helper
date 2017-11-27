<?php
namespace Swoole;

/**
 * Swoole 客户端
 * @package Swoole
 */
class Client {

    /**
     * 运行参数
     *
     * @var array
     * @see config.php
     */
    public $setting = [];

    /**
     * 阻塞等待直到收到指定长度的数据后返回
     * 用于 recv 方法的第二个参数
     */
    const MSG_WAITALL = 256;

    /**
     * 非阻塞接收数据，无论是否有数据都会立即返回。
     */
    const MSG_DONTWAIT = 64;

    /**
     * 窥视 socket 缓存区中的数据
     * 设置 MSG_PEEK 参数后，recv 读取数据不会修改指针，因此下一次调用 recv 仍然会从上一次的位置起返回数据
     */
    const MSG_PEEK = 2;

    /**
     * 读取带外数据
     */
    const MSG_OOB = 1;

    /**
     * 当前错误码
     *
     * @var      int
     * @example  echo socket_strerror($client->errCode);
     */
    public $errCode;

    /**
     * socket 的文件描述符
     *
     * @var     int
     * @example $sock = fopen("php://fd/".$swoole_client->sock);
     */
    public $sock;

    /**
     * 是否为复用连接
     *
     * @var     bool    true-复用已存在的 false-新创建的
     * @since   1.8.0
     */
    public $reuse;

    /**
     * @param int       $sockType   socket 类型。参考：SWOOLE_SOCK_
     * @param int       $isSync     是否异步模式。默认为同步阻塞
     * @param string    $key        长连接的 Key。默认使用 Ip:Port
     *
     * @since   1.7.5+  $key 可用
     */
    public function __construct($sockType, $isSync = SWOOLE_SOCK_SYNC, $key = null){}

    /**
     * 设置运行参数
     *
     * @param   array $settings 参数数组
     * @return  bool
     */
    public function set($settings){}

    /**
     * 注册事件
     *
     * 同步阻塞客户端无法使用
     *
     * @param   string      $event      支持 connect/error/receive/close 4种
     * @param   callback    $callback   回调函数
     * @return  int
     *
     * @see     https://wiki.swoole.com/wiki/page/459.html
     * @since   1.6.3+      UDP 协议可以使用
     */
    public function on($event, $callback){}

    /**
     * 连接到远程服务器
     *
     * @param   string    $host     远程服务器的地址
     * @param   int       $port     远程服务器的端口
     * @param   float     $timeout  网络 IO 的超时时间。包括 connect/send/recv，单位是s，支持浮点数
     * @param   int       $flag
     * @return  bool
     */
    public function connect($host, $port, $timeout = 0.1, $flag = 0){}

    /**
     * 获取连接状态
     *
     * @return bool
     *
     * @since  1.7.5+
     */
    public function isConnected(){}

    /**
     * 获取底层的 Socket 资源句柄
     *
     * 此方法需要依赖 PHP 的 sockets 扩展，并且编译 swoole 时需要开启 --enable-sockets 选项
     *
     * @return resource
     */
    public function getSocket(){}

    /**
     * 获取客户端 Socket 的本地 host:port
     *
     * @return array
     *
     * @since  1.7.13+
     */
    public function getSockName(){}

    /**
     * 获取对端 socket 的IP地址和端口
     *
     * 仅支持 SWOOLE_SOCK_UDP/SWOOLE_SOCK_UDP6 类型的 swoole_client 对象
     * 此函数必须在 $client->recv() 之后调用
     *
     * @return bool
     */
    public function getPeerName(){}

    /**
     * 获取服务器端证书信息
     *
     * 需要在编译 swoole 时启用 --enable-openssl
     * 必须在 SSL 握手完成后才可以调用此方法
     *
     * @return string|bool  成功返回 X509 证书字符串信息，失败返回 false
     *
     * @see   可以使用 openssl 扩展提供的 openssl_x509_parse 函数解析证书的信息
     * @since 1.8.8
     */
    public function getPeerCert(){}

    /**
     * 发送数据到远程服务器
     *
     * @param   string    $data 待发送的数据。支持二进制数据
     * @return  bool|int        成功返回已发数据长度，失败返回 false 可以通过 errCode 方法获取错误码
     */
    public function send($data){}

    /**
     * 向任意 Ip:Port 的主机发送 UDP 数据包
     * 仅支持SWOOLE_SOCK_UDP/SWOOLE_SOCK_UDP6类型的swoole_client对象。
     *
     * @param   string    $ip       目标主机的IP地址。支持 IPv4/IPv6
     * @param   int       $port     目标主机端口
     * @param   string    $data     要发送的数据。不得超过 64K
     * @return  bool
     */
    public function sendTo($ip, $port, $data){}

    /**
     * 发送文件到服务器
     *
     * 如果是同步, 会一直阻塞直到整个文件发送完毕或者发生致命错误
     * 如果是异步, 当发生致命错误时会回调 onError
     *
     * @param   string  $filename   发送文件的路径
     * @param   int     $offset     文件的偏移量。可以指定从文件的中间部分开始传输数据。此特性可用于支持断点续传
     * @param   int     $length     发送数据的尺寸。默认为整个文件的尺寸
     * @return  bool
     *
     * @since   1.9.11  $offset/$length 可用
     */
    public function sendFile($filename, $offset = 0, $length = 0){}

    /**
     * 从服务器端接收数据
     *
     * @param   int     $size   接收数据的缓存区最大长度。此参数不要设置过大，否则会占用较大内存
     * @param   int     $flags  标志。参见：MSG_ 开头常量
     * @return  bool|string     成功收到数据返回字符串，连接关闭返回空字符串。失败返回 false，并设置 $client->errCode 属性
     */
    public function recv($size = 65535, $flags = 0){}

    /**
     * 关闭连接
     *
     * @param   bool $force   是否强制关闭。设置为 true 表示强制关闭连接，可用于关闭 SWOOLE_KEEP 长连接
     * @return  bool
     */
    public function close($force = false){}

    /**
     * 进入睡眠模式，停止接收数据
     *
     * 此方法仅停止从 socket 中接收数据，但不会移除可写事件，所以不会影响发送队列
     * sleep 操作与 wakeup 作用相反，使用 wakeup 方法可以重新监听可读事件
     *
     * @since   1.7.21
     */
    public function sleep(){}

    /**
     * 停止睡眠，开始接收数据
     *
     * 如果 socket 并未进入 sleep 模式，wakeup 操作没有任何作用
     *
     * @since   1.7.21
     */
    public function wakeup(){}

    /**
     * 动态开启 SSL 隧道加密
     *
     * 客户端创建时类型必须为非 SSL
     * 客户端已与服务器建立了连接
     *
     * @return  bool
     */
    public function enableSSL(){}
}