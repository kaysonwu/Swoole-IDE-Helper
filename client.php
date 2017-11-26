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
     */
    public $setting = [

        /**
         * 是否开启 EOF 结束符协议
         *
         * @var bool
         */
        'open_eof_check'                => false,

        /**
         * 是否开启 EOF 分割
         * 底层会从数据包中间查找 EOF，并拆分数据包
         *
         * 与 open_eof_check 的差异
         *  open_eof_check 只检查接收数据的末尾是否为 EOF，因此它的性能最好，几乎没有消耗
         *  open_eof_check 无法解决多个数据包合并的问题，比如同时发送两条带有 EOF 的数据，底层可能会一次全部返回
         *  open_eof_split 会从左到右对数据进行逐字节对比，查找数据中的 EOF 进行分包，性能较差。但是每次只会返回一个数据包
         *
         * @var     bool
         * @since   1.7.15+
         */
        'open_eof_split'                => false,

        /**
         * EOF 结束符
         * 最大只允许传入 8 个字节的字符串
         *
         * @val string
         */
        'package_eof'                   => "\r\n",

        /**
         * 是否开启 固定包头+包体协议
         *
         * @var bool
         */
        'open_length_check'             => true,

        /**
         * 最大数据包尺寸。
         * 单位：字节
         * 此参数不宜设置过大，否则会占用很大的内存
         *
         * @var int
         */
        'package_max_length'            => 0,

        /**
         * 长度解析函数
         * 长度函数必须返回一个整数
         *  返回0，数据不足，需要接收更多数据
         *  返回-1，数据错误，底层会自动关闭连接
         *  返回包长度值（包括包头和包体的总长度），底层会自动将包拼好后返回给回调函数
         *
         * 回调函数原型：int function($data)
         *
         *
         * @var callback
         */
        'package_length_func'           => null,

        /**
         * 长度值的类型
         *
         * @var string
         * @see php pack()
         */
        'package_length_type'           => 'n',

        /**
         * 长度值在包头的第几个字节
         *
         * @var int
         */
        'package_length_offset'         => 0,

        /**
         * 从第几个字节开始计算包体长度
         *
         * @var int
         */
        'package_body_offset'           => 2,

        /**
         * 是否启用 Http 协议处理
         * Swoole\Http\Server 会自动启用此选项。
         * 设置为 false 表示关闭 Http 协议处理。
         *
         * @var bool
         */
        'open_http_protocol'            => false,

        /**
         * 是否启用 Http2 协议处理
         * 启用 HTTP2 协议解析，需要依赖 --enable-http2 编译选项。
         *
         * @var bool
         */
        'open_http2_protocol'           => false,

        /**
         * 是否启用 websocket 协议处理
         * Swoole\WebSocket\Server 会自动启用此选项
         * 设置 open_websocket_protocol 选项为 true 后，会自动设置 open_http_protocol 协议也为 true。
         */
        'open_websocket_protocol'       => false,

        /**
         * 是否启用 mqtt 协议处理
         * 启用后会解析 mqtt 包头，worker 进程 onReceive 每次会返回一个完整的 mqtt 数据包
         */
        'open_mqtt_protocol'            => false,

        /**
         * 客户端连接的缓存区长度
         * 单位：字节
         * 如 128 * 1024 *1024 表示每个 TCP 客户端连接最大允许有 128M 待发送的数据
         *
         * @var int
         */
        'socket_buffer_size'            => 0,

        /**
         * 是否启用 tcp_nodelay
         * 开启后 TCP 连接发送数据时会关闭 Nagle 合并算法，立即发往客户端连接
         * 在某些场景下，如 http 服务器，可以提升响应速度
         *
         * @var bool
         */
        'open_tcp_nodelay'              => false,

        /**
         * SSL 隧道加密， cert 证书文件
         * https 应用浏览器必须信任证书才能浏览网页
         * wss 应用中，发起 WebSocket 连接的页面必须使用 https
         * 浏览器不信任 SSL 证书将无法使用 wss
         * 文件必须为 PEM 格式，不支持 DER 格式，可使用 openssl 工具进行转换
         *
         * 使用SSL必须在编译swoole时加入--enable-openssl选项
         *
         * @var string
         */
        'ssl_cert_file'                 => null,

        /**
         * SSL 隧道加密， Key 私钥文件
         *
         * @var string
         */
        'ssl_key_file'                  => null,

        /**
         * openSSL 隧道加密算法
         *
         * @var     int
         * @since   1.7.20
         * @see     SWOOLE_SSL* 常量
         */
        'ssl_method'                    => null,

        /**
         * openssl 的加密算法
         * 启用 SSL 后，设置 ssl_ciphers 来改变默认的加密算法
         * Swoole 底层默认使用 EECDH+AESGCM:EDH+AESGCM:AES256+EECDH:AES256+EDH
         *
         * @var string
         */
        'ssl_ciphers'                   => null,

        /**
         * 绑定 IP 地址
         *
         * @var string
         * @since 1.8.5
         */
        'bind_address'                  => null,

        /**
         * 绑定端口
         *
         * @var     int
         * @since   1.8.5
         */
        'bind_port'                     => null,

        /**
         * Socks5 代理主机地址
         *
         * @var string
         */
        'socks5_host'                   => null,

        /**
         * Socks5 代理端口
         *
         * @var int
         */
        'socks5_port'                   => null,

        /**
         * Socks5 代理用户名
         *
         * @var string
         */
        'socks5_username'                => null,

        /**
         * Socks5 代理密码
         *
         * @var string
         */
        'socks5_password'               => null,

        /**
         * Http 代理主机地址
         *
         * @var string
         */
        'http_proxy_host'               => null,

        /**
         * Http 代理端口
         *
         * @var int
         */
        'http_proxy_port'               => null,
    ];

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