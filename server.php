<?php
namespace Swoole;

/**
 * 异步服务器程序
 * 支持TCP、UDP、UnixSocket 3种协议，支持 IPv4和 IPv6，支持 SSL/TLS 单向双向证书的隧道加密
 * @package Swoole
 */
class Server {

    /**
     * 运行参数
     *
     * @var array
     */
    public $setting = [

        /**
         * 最大连接。
         * 此参数用来设置 Server 最大允许维持多少个 TCP 连接。超过此数量后，新进入的连接将被拒绝
         *
         * @var int
         */
        'max_conn'                      => 0,

        /**
         * 守护进程化
         *
         * @var bool
         */
        'daemonize'                     => false,

        /**
         * reactor 线程数。
         * 通过此参数来调节 poll 线程的数量，以充分利用多核。
         * 默认设置为 CPU 核数
         * reactor_num 必须小于或等于 worker_num。
         * 如果设置的 reactor_num 大于 worker_num，那么 swoole 会自动调整使 reactor_num 等于 worker_num
         *
         * @var     int
         * @since   1.7.14+ 超过 8 核的机器上 reactor_num 默认设置为 8
         */
        'reactor_num'                   => 0,

        /**
         * worker 进程数
         * 全异步非阻塞：worker_num 配置为CPU核数的 1-4 倍即可。
         * 同步阻塞：worker_num 配置为100或者更高，具体要看每次请求处理的耗时和操作系统负载状况。
         * 当设定的 worker 进程数小于 reactor 线程数时，会自动调低 reactor 线程的数量
         *
         * @var int
         */
        'worker_num'                    => 0,

        /**
         * task 进程数
         * 配置此参数后将会启用 task 功能。
         * 所以Server 务必要注册onTask、onFinish 2个事件回调函数。
         * 如果没有注册，服务器程序将无法启动。
         * task进程内不能使用 task 方法
         * task进程内不能使用 swoole_mysql、swoole_redis、swoole_event 等异步IO函数
         *
         * @var int
         */
        'task_worker_num'               => 0,

        /**
         * 设置 task 进程与 worker 进程之间通信的方式
         * 1) 使用unix socket通信，默认模式
         * 2) 使用消息队列通信
         * 3) 使用消息队列通信，并设置为争抢模式
         *
         * 模式 2 和模式 3 的不同之处是:
         * 模式2支持定向投递，$serv->task($data, $task_worker_id) 可以指定投递到哪个 task 进程。
         *
         * @var int
         */
        'task_ipc_mode'                 => 1,

        /**
         * task 进程的最大任务数
         * task 进程在处理完超过此数值的任务后将自动退出。
         * 这个参数是为了防止 PHP 进程内存溢出。
         * 如果不希望进程自动退出可以设置为 0。
         *
         * 此配置在 1.7.17 以下版本默认为 5000，受 swoole_config.h 的 SW_MAX_REQUEST 宏控制
         * 此配置在 1.7.17 以上版本默认值调整为 0，不会主动退出进程
         *
         * @var int
         */
        'task_max_request'              => 0,

        /**
         * task 的数据临时目录
         * 如果投递的数据超过 8192 字节，将启用临时文件来保存数据
         * 这里的 task_tmpdir 就是用来设置临时文件保存的位置
         *
         * @var     string
         * @since   1.7.7+
         */
        'task_tmpdir'                   => '/tmp',

        /**
         * 最大请求次数
         * 此参数表示 worker 进程在处理完此数值请求后结束运行。
         * manager 会重新创建一个 worker 进程。
         * 这个参数是为了防止 PHP 进程内存溢出。
         * onConnect/onClose 不增加计数
         * 0 表示不自动重启
         *
         * @var int
         */
        'max_request'                   => 0,

        /**
         * Listen 队列长度
         * 此参数将决定最多同时有多少个待 accept 的连接
         * swoole 本身 accept 效率是很高的，基本上不会出现大量排队情况
         *
         * @var int
         */
        'backlog'                       => 0,

        /**
         * CPU 亲和设置
         *
         * @var bool
         */
        'open_cpu_affinity'             => false,

        /**
         * 亲和设置将忽略的 CPU
         * 如果不设置此选项，Swoole 将会使用全部 CPU 核
         * 此选项必须与 open_cpu_affinity 同时设置才会生效
         * 接受一个数组作为参数，[0, 1] 表示不使用CPU0,CPU1，专门空出来处理网络中断
         *
         * @var array
         */
        'cpu_affinity_ignore'           => null,

        /**
         * 是否启用 tcp_nodelay
         * 开启后 TCP 连接发送数据时会关闭 Nagle 合并算法，立即发往客户端连接
         * 在某些场景下，如 http 服务器，可以提升响应速度
         *
         * @var bool
         */
        'open_tcp_nodelay'              => false,

        /**
         * 此参数设定一个秒数，当客户端连接到服务器时，在约定秒数内并不会触发 accept
         * 直到有数据发送或者超时时才触发
         *
         * @var int
         */
        'tcp_defer_accept'              => 0,

        /**
         * 日志文件路径
         * 指定 Swoole 错误日志文件。在 Swoole 运行期发送的异常信息会记录到这个文件中
         * 默认会打印到屏幕
         * 开启守护进程模式后 daemonize => true 标准输出将会被重定向到 log_file
         *
         * @var string
         */
        'log_file'                      => null,

        /**
         * 错误日志打印的等级
         * 低于  log_level 设置的日志信息不会抛出
         *
         * 级别
         *  0 =>DEBUG
         *  1 =>TRACE
         *  2 =>INFO
         *  3 =>NOTICE
         *  4 =>WARNING
         *  5 =>ERROR
         *
         * @var int
         */
        'log_level'                     => 0,

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
         * @see php pack()
         *
         * @var string
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
         * 心跳检测间隔时间
         * 每隔多少秒检测一次，单位秒，Swoole 会轮询所有 TCP 连接，将超过心跳时间的连接关闭
         * 心跳时间即 heartbeat_idle_time
         *
         * heartbeat_check 仅支持 TCP 连接
         *
         * @var int
         */
        'heartbeat_check_interval'      => 0,

        /**
         * TCP 连接的最大闲置时间，单位秒
         *
         * @var int
         */
        'heartbeat_idle_time '          => 0,

        /**
         * worker 进程数据包分配模式
         * 1) 平均分配
         * 2) 按 $fd 取模固定分配
         * 3) 抢占式分配
         * 4) IP 分配。根据客户 IP 进行取模固定分配
         * 5) UID 分配。需要用户代码中调用 $server->bind() 将一个连接绑定 1 个 uid
         * 抢占式分配，每次都是空闲的 worker 进程获得数据。很合适 SOA/RPC 类的内部服务框架
         * 当选择为抢占模式时，worker 进程内发生 onConnect/onReceive/onClose/onTimer
         * 会将 worker 进程标记为忙，不再接受新的请求。
         * reactor 会将新请求投递给其他状态为闲的 worker 进程
         *
         * @var     int
         * @since   1.7.8+  4,5 两种模式可用
         */
        'dispatch_mode '                => 2,

        /**
         * dispatch 函数
         * swoole 底层了内置了 5 种 dispatch_mode，如果仍然无法满足需求
         * 可以使用自定义回调函数进行分配
         *
         * 回调函数原型： int function($server, $fd, $type, $data);
         *      $fd        客户端连接标识
         *      $type      数据的类型       0-来自客户端的数据 4-客户端连接关闭 5-客户端建立连接
         *      $data      数据内容
         *      return     必须返回一个 [0 - worker_num) 的数字，表示数据包投递的目标工作进程ID
         *
         * @var     callback
         * @since   1.9.7
         * @since   1.9.18  PHP 回调函数可用
         */
        'dispatch_func '                => null,

        /**
         * 消息队列的 Key
         * 仅在 task_ipc_mode = 2/3 时使用
         * 设置的 Key 仅作为 task 任务队列的KEY
         * 此参数的默认值为 ftok($php_script_file, 1)
         *
         * @var string
         */
        'message_queue_key'             => null,

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
         * @see SWOOLE_SSL* 常量
         *
         * @var     int
         * @since   1.7.20
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
         * 设置 worker/task 子进程的所属用户
         * 仅在使用 root 用户启动时有效
         *
         * @var     string
         * @since   1.7.9+
         */
        'user'                          => null,

        /**
         * 设置 worker/task 子进程的所属用户组
         * 仅在使用 root 用户启动时有效
         *
         * @var     string
         * @since   1.7.9+
         */
        'group'                         => null,

        /**
         * 重定向 worker 进程的文件系统根目录
         * 此设置可以使进程对文件系统的读写与实际的操作系统文件系统隔离。提升安全性
         *
         * @var     string
         * @since   1.7.9+
         */
        'chroot'                        => null,

        /**
         * PID 存储文件
         * 在 Server 启动时自动将 master 进程的 PID 写入到文件
         * 在Server关闭时自动删除PID文件
         * 用时需要注意如果 Server 非正常结束，PID文件不会删除
         *
         * @var     string
         * @since   1.9.5
         */
        'pid_file'                      => null,

        /**
         * 管道通信的内存缓存区长度
         * swoole 的 reactor 线程与 worker 进程之间
         * worker 进程与 task 进程之间
         *
         * task_ipc_mode=2/3 时会使用消息队列通信不受此参数控制
         * 管道缓存队列已满会导致 reactor 线程、worker 进程发生阻塞
         *
         * 此配置在 1.7.17 以上版本默认为 32M，1.7.17 以下版本默认为 8M
         * 此配置在 1.9.16 或更高版本已移除此配置项，底层不再限制管道缓存区的长度
         *
         * @var int
         */
        'pipe_buffer_size'              => 0,

        /**
         * 发送输出缓存区内存尺寸
         * 单位：字节
         * 注意此函数不应当调整过大，避免拥塞的数据过多，导致吃光机器内存
         * 开启大量 worker 进程时，将会占用 worker_num * buffer_output_size 字节的内存
         *
         * @var int
         */
        'buffer_output_size'            => 2 * 1024 * 1024,

        /**
         * 客户端连接的缓存区长度
         * 单位：字节
         * 如 128 * 1024 *1024 表示每个 TCP 客户端连接最大允许有 128M 待发送的数据
         *
         * @var int
         */
        'socket_buffer_size'            => 0,

        /**
         * 是否启用非安全事件
         * swoole 在配置 dispatch_mode=1/3后, 系统无法保证 onConnect/onReceive/onClose 的顺序，
         * 默认关闭了onConnect/onClose 事件
         *
         * 如果应用程序需要 onConnect/onClose 事件，并且能接受顺序问题可能带来的安全风险，
         * 可以通过设置 enable_unsafe_event 为 true，启用onConnect/onClose事件
         *
         * @var     bool
         * @since   1.7.18+
         */
        'enable_unsafe_event'           => false,

        /**
         * 是否丢弃超时请求
         * swoole 在配置 dispatch_mode=1/3后，系统无法保证 onConnect/onReceive/onClose 的顺序，
         * 因此可能会有一些请求数据在连接关闭后，才能到达Worker进程。
         *
         * true：表示如果 worker 进程收到了已关闭连接的数据请求，将自动丢弃
         * false：表示无论连接是否关闭 worker 进程都会处理数据请求
         *
         * @var     bool
         * @since   1.7.16+
         */
        'discard_timeout_request'       => false,

        /**
         * 是否启用端口重用
         * 此参数用于优化 TCP 连接的 Accept 性能，启用端口重用后多个进程可以同时进行 Accept 操作
         *
         * 仅在 Linux-3.9.0 以上版本的内核可用
         * 启用端口重用后可以重复启动同一个端口的 Server 程序
         *
         * @var bool
         */
        'enable_reuse_port'             => false,

        /**
         * 是否启用延迟接收
         *
         * true: accept 客户端连接后将不会自动加入 EventLoop，仅触发 onConnect 回调
         * worker 进程可以调用 $server->confirm($fd) 对连接进行确认，此时才会将客户加入
         * EventLoop 开始进行数据收发，也可以调用 $server->close($fd) 关闭此连接
         *
         * @var bool
         * @since   1.8.8
         */
        'enable_delay_receive'          => false,

        /**
         * 是否开启异步重启
         * 设置为 true 时，将启用异步安全重启特性，Worker 进程会等待异步事件完成后再退出
         *
         * @var bool
         */
        'reload_async'                  => false,

        /**
         * 是否启用 TCP 快速握手特性
         * 此项特性，可以提升 TCP 短连接的响应速度，在客户端完成握手的第三步，发送 SYN 包时携带数据。
         *
         * @var bool
         */
        'tcp_fastopen'                  => false,
    ];

    /**
     * 当前服务器主进程的 PID
     *
     * @var int
     */
    public $master_pid;

    /**
     * 当前服务器管理进程的 PID
     *
     * @var int
     */
    public $manager_pid;

    /**
     * 当前 Worker 进程的编号，包括 Task 进程
     *
     * @var int
     */
    public $worker_id;

    /**
     * 当前 Worker 进程的操作系统进程 ID
     *
     * 与 posix_getpid() 的返回值相同
     *
     * @var int
     */
    public $worker_pid;

    /**
     * 是否为任务进程
     *
     * @var bool
     */
    public $taskworker;

    /**
     * 当前所有的连接
     *
     * @var     array
     * @since   1.7.16
     *
     * @see     连接迭代器依赖pcre库（不是PHP的pcre扩展），未安装pcre库无法使用此功能
     *          pcre库的安装方法: http://wiki.swoole.com/wiki/page/312.html
     */
    public $connections;

    /**
     * 创建一个异步服务对象
     *
     * @param   string  $host           主机地址。指定监听的 IP 地址 0.0.0.0 监听全部地址
     * @param   int     $port           端口
     * @param   int     $mode           运行模式。参考常量：SWOOLE_PROCESS、SWOOLE_BASE
     * @param   int     $sockType       Socket 类型。参考常量 SWOOLE_SOCK_ 开头
     */
    public function __construct($host, $port = 0, $mode = SWOOLE_PROCESS, $sockType = SWOOLE_SOCK_TCP){}

    /**
     * 设置运行参数
     *
     * @param   array $setting 参数数组。参见属性 $setting
     * @return  bool
     */
    public function set($setting){}

    /**
     * 注册事件
     *
     * @param   string    $event      事件名称 不区分大小写
     * @param   callback  $callback   回调函数
     * @return  bool
     *
     * @see https://wiki.swoole.com/wiki/page/p-event/onStart.html
     */
    public function on($event, $callback){}

    /**
     * 添加一个用户自定义的 Worker 进程
     *
     * @param   \Swoole\Process   $process
     * @return  bool
     *
     * @since   1.7.9+
     */
    public function addProcess($process){}

    /**
     * 增加监听对象
     *
     * @param   string  $host   主机地址
     * @param   int     $port   端口
     * @param   int     $type   Socket 类型。参考常量 SWOOLE_SOCK_开头
     * @return  bool
     */
    public function addListener($host, $port, $type = SWOOLE_SOCK_TCP){}

    /**
     * 增加监听对象。此方法是 addListener 的别名
     *
     * @param   string  $host   主机地址
     * @param   int     $port   端口
     * @param   int     $type   Socket 类型。参考常量 SWOOLE_SOCK_开头
     *
     * @return  bool
     *
     * @since   1.7.9+
     */
    public function listen($host, $port, $type = SWOOLE_SOCK_TCP){}

    /**
     * 启动服务，监听所有的 TCP/UDP 端口
     *
     * @return bool
     */
    public function start(){}

    /**
     * 重启所有 Worker 进程
     *
     * @param   bool $onlyReloadTaskworkrer   是否仅重启 task 进程
     * @return  bool
     *
     * @since   1.7.7   $onlyReloadTaskworkrer 可用
     */
    public function reload($onlyReloadTaskworkrer = false){}

    /**
     * 停止指定的 Worker 进程，并立即触发 onWorkerStop 回调函数
     *
     * @param   int     $workerId      Worker 进程ID。-1 代表当前 Worker 进程
     * @param   bool    $waitEvent     false-表示立即退出，true-等待事件循环为空时再退出
     * @return  bool
     *
     * @since   1.8.2
     * @since   1.9.19  $waitEvent 可用
     */
    public function stop($workerId = -1, $waitEvent = false){}

    /**
     * 关闭服务器
     */
    public function shutdown(){}

    /**
     * 设置一个定时器。是 swoole_timer_tick 函数别名
     *
     * @param   int         $ms             间隔时间，单位为毫秒。最大不得超过 86400000
     * @param   callback    $callback       回调函数。原型：function callback(int $timerId, mixed $params = null)
     * @param   mixed       $userParam      用户参数，该参数会被传递到 $callback 中
     * @return  int                         定时器 ID
     *
     * @since   1.8.0   在 task 进程中可用
     */
    public function tick($ms, $callback, $userParam){}

    /**
     * 在指定的时间后执行函数。是 swoole_timer_after 函数别名
     *
     * @param   int        $afterTimeMs     间隔时间，单位为毫秒。最大不得超过 86400000
     * @param   callback   $callback        回调函数。
     * @return  int                         定时器 ID
     *
     * @since   1.7.7+
     * @since   1.8.0   在 task 进程中可用
     */
    public function after($afterTimeMs, $callback){}

    /**
     * 延后执行一个 PHP 函数。
     *
     * Swoole 底层会在 EventLoop 循环完成后执行此函数。
     * 此函数的目的是为了让一些 PHP 代码延后执行，程序优先处理IO事件
     *
     * @param   callback $callback  回调函数
     * @return  bool
     *
     * @since   1.8.0
     */
    public function defer($callback){}

    /**
     * 删除指定的定时器。是 swoole_timer_clear 函数的别名
     *
     * @param   int   $timerId 定时器 ID
     * @return  bool
     */
    public function clearTimer($timerId){}

    /**
     * 关闭客户端连接
     *
     * @param  int  $fd      客户端连接标识符
     * @param  bool $reset   true-强制关闭连接，丢弃发送队列中的数据
     * @return bool
     *
     * @since  1.8.0
     */
    public function close($fd, $reset = false){}

    /**
     * 向客户端发送数据
     *
     * @param   int     $fd         客户端连接标识符
     * @param   string  $data       要发送的数据。TCP协议最大不得超过 2M，可修改 buffer_output_size  改变允许发送的最大包长度
     * @param   int     $extrData   额外的数据。TCP 发送数据，不需要该参数
     * @return  bool                true-成功，false-失败，通过 $server->getLastError() 方法可以得到错误信息
     */
    public function send($fd, $data, $extrData = 0){}

    /**
     * 向客户端发送文件
     *
     * @param   int       $fd           客户端连接标识符
     * @param   string    $filename     要发送的文件路径。如果文件不存在会返回 false
     * @param   int       $offset       指定文件偏移量。可以从文件的某个位置起发送数据。默认为 0，表示从文件头部开始发送
     * @param   int       $length       指定发送的长度，默认为文件尺寸。
     * @return  bool
     *
     * @since   1.9.17  SSL 客户端连接可用
     * @since   1.9.11  $length 和 $offset 可用
     */
    public function sendFile($fd, $filename, $offset = 0, $length = 0){}

    /**
     * 向任意的客户端 (IP:Port) 发送UDP 数据包
     *
     * @param   string    $ip              IP地址。为 IPV4 字符串，如果 IP 不合法会返回错误
     * @param   int       $port            网络端口号。为 1 - 65535 ，如果端口错误发送会失败
     * @param   string    $data            要发送的数据。可以是文本或者二进制内容
     * @param   int       $serverSocket    使用那个端口发送数据包。服务器可能会同时监听多个 UDP 端口
     * @return  bool
     *
     * @since   1.7.10+
     */
    public function sendTo($ip, $port, $data, $serverSocket = -1){}

    /**
     * 阻塞地向客户端发送数据
     *
     * 仅可用于 SWOOLE_BASE 运行模式下
     *
     * @param   int     $fd         客户端连接标识符
     * @param   string  $sendData   要发送的数据
     * @return  bool
     */
    public function sendWait($fd, $sendData){}

    /**
     * 向任意 worker/task 进程发送消息
     *
     * 在非主进程和管理进程中可调用。收到消息的进程会触发 onPipeMessage 事件
     * 使用 sendMessage 必须注册 onPipeMessage 事件回调函数
     *
     * @param   string  $message        消息内容。没有长度限制，但超过8K时会启动内存临时文件
     * @param   int     $dstWorkerId    目标进程ID。范围是0 ~ (worker_num + task_worker_num - 1)
     * @return  bool
     *
     * @since   1.7.9+
     */
    public function sendMessage($message, $dstWorkerId){}

    /**
     * 检测对应的连接是否存在
     *
     * @param int   $fd 客户端连接标识符
     * @return bool
     *
     * @since  1.7.18+
     */
    public function exist($fd){}

    /**
     * 停止指定客户端的数据接收
     *
     * 调用此函数后会将连接从EventLoop中移除，不再接收客户端数据
     * 此函数不影响发送队列的处理
     * 仅可用于 SWOOLE_BASE 模式
     *
     * @param  int   $fd 客户端连接标识符
     * @return bool
     */
    public function pause($fd){}

    /**
     * 恢复指定客户端的数据接收
     *
     * 调用此函数后会将连接重新加入到EventLoop中，继续接收客户端数据
     * 仅可用于 SWOOLE_BASE 模式
     *
     * @param  int   $fd 客户端连接标识符
     * @return bool
     */
    public function resume($fd){}

    /**
     * 获取连接信息
     *
     * @param   int         $fd             客户端连接标识符
     * @param   int         $extraData      额外的数据
     * @param   bool        $ignoreError    是否忽略错误。true-即使连接关闭也会返回连接的信息
     * @return  array|bool
     */
    public function connection_info($fd, $extraData, $ignoreError = false){}

    /**
     * 获取当前 Server 所有的客户端连接
     *
     * @param   int     $startFd    起始的客户端连接标识符
     * @param   int     $pageSize   每页显示数量。最大不得超过 100
     * @return  array|bool          false-失败 array-客户端连接标识符
     *
     * @since   1.5.8
     */
    public function connection_list($startFd, $pageSize = 10){}

    /**
     * 将连接绑定一个用户定义的 UID，可以设置 dispatch_mode=5 设置以此值进行 hash 固定分配
     *
     * @param   int $fd     客户端连接标识符
     * @param   int $uid    UID
     * @return  bool
     */
    public function bind($fd, $uid){}

    /**
     * 获取当前 Server 的活动 TCP 连接数/启动数据/accpet/close的总次数等信息
     *
     * @return  array
     *              start_time              服务器启动的时间
     *              connection_num          当前连接的数量
     *              accept_count            接受了多少个连接
     *              close_count             关闭的连接数量
     *              request_count           Server收到的请求次数
     *              worker_request_count    当前Worker进程收到的请求次数
     *              tasking_num             当前正在排队的任务数
     *              task_queue_num          消息队列中的Task数量
     *              task_queue_bytes        消息队列的内存占用字节数
     *
     * @since   1.7.5+
     * @since   1.8.5   增加消息队列的统计数据
     */
    public function stats(){}

    /**
     * 投递一个异步的任务到 task 进程池去执行
     *
     * @param   mixed       $data           任务数据
     * @param   int         $dstWorkerId    task 进程ID。指定本参数则任务将被投递到该进程内，-1 表示随机投递
     * @param   callback    $callback       finish 回调函数
     * @return  int|bool                    int- task ID。false 失败
     *
     * @since   1.6.11+     $dstWorkerId
     * @since   1.8.6       $callback
     */
    public function task($data, $dstWorkerId = -1, $callback = null){}

    /**
     * 投递一个异步的任务到 task 进程池去执行。与 task 不同的是 taskwait 是阻塞等待的，直到任务完成或者超时返回。
     *
     * @param   mixed     $data         任务数据
     * @param   float     $timeout      超时时间。单位：秒
     * @param   int       $dstWorkerId  task 进程ID。指定本参数则任务将被投递到该进程内，-1 表示随机投递
     * @return  string|bool
     *
     * @since   1.6.11+   $dstWorkerId
     */
    public function taskWait($data, $timeout = 0.5, $dstWorkerId = -1){}

    /**
     * 并发执行多个 Task
     *
     * @param   array $tasks        任务数组。仅支持关联索引数组
     * @param   float $timeout      超时时间。单位秒
     * @return  array               任务完成或超时，返回结果数组。某个任务执行超时不会影响其他任务，返回的结果数据中将不包含超时的任务
     *
     * @since   1.8.8
     */
    public function taskWaitMulti($tasks, $timeout = 0.5){}

    /**
     * 并发执行 Task 并进行协程调度
     *
     * @param   array   $tasks      任务数组。仅支持关联索引数组
     * @param   float   $timeout    超时时间。单位秒
     * @return  array               任务完成或超时，返回结果数组。某个任务执行超时不会影响其他任务，返回的结果数据中将不包含超时的任务
     *
     * @since   2.0.9
     */
    public function taskCo($tasks, $timeout = 0.5){}

    /**
     * task 进程传递结果数据给 worker 进程
     *
     * 使用此方法，必须注册 onFinish 回调函数
     * finish 是可选的。如果 worker 进程不关心任务执行的结果，不需要调用此函数
     * 在 onTask 回调函数中 return 字符串，等同于调用 finish
     *
     * @param   string  $data
     * @return  bool
     */
    public function finish($data){}

    /**
     * 检测服务器所有连接，并找出已经超过约定时间的连接
     *
     * @param bool $ifCloseConnection 是否自动关闭超时连接
     * @return array
     *
     * @since 1.6.10+
     * @since 1.7.4+  $ifCloseConnection
     */
    public function heartbeat($ifCloseConnection = true){}

    /**
     * 获取最近一次操作错误的错误码
     *
     * @return int
     */
    public function getLastError(){}

    /**
     * 获取底层的 Socket 资源句柄
     *
     * @return resource
     *      1001 连接已经被 Server 端关闭了，出现这个错误一般是代码中已经执行了 $server->close() 关闭了某个连接，
     *           但仍然调用 $server->send()向这个连接发送数据
     *      1002 连接已被 Client 端关闭了，Socket 已关闭无法发送数据到对端
     *      1003 正在执行 close，onClose 回调函数中不得使用 $server->send()
     *      1004 连接已关闭
     *      1005 连接不存在，传入 $fd 可能是错误的
     *      1007 接收到了超时的数据，TCP关闭连接后，可能会有部分数据残留在管道缓存区内，这部分数据会被丢弃
     *      1008 发送缓存区已满无法执行send操作，出现这个错误表示这个连接的对端无法及时收数据导致发送缓存区已塞满
     *      1202 发送的数据超过了 $server->buffer_output_size 设置
     */
    public function getSocket(){}

    /**
     * 设置客户端连接为保护状态，不被心跳线程切断
     *
     * @param   int     $fd     客户端连接标识符
     * @param   bool    $value  状态。true-保护状态 false-表示不保护
     * @return  bool
     */
    public function protect($fd, $value = true){}

    /**
     * 确认连接，与 enable_delay_receive 或 wait_for_bind 配合使用
     *
     * @param   int     $fd 客户端连接标识符
     * @return  bool
     */
    public function confirm($fd){}
}