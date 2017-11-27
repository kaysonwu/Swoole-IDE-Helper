<?php
return [

    // +----------------------------------------------------------------------
    // | 以下为客户端和服务器程序通用配置
    // +----------------------------------------------------------------------

    /**
     * 客户端连接的缓存区长度
     * 单位：字节
     * 如 128 * 1024 *1024 表示每个 TCP 客户端连接最大允许有 128M 待发送的数据
     *
     * @var int
     */
    'socket_buffer_size'            => 0,

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

    // +----------------------------------------------------------------------
    // | 以下为客户端配置
    // +----------------------------------------------------------------------

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


    // +----------------------------------------------------------------------
    // | 以下为服务器配置
    // +----------------------------------------------------------------------

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

    // +----------------------------------------------------------------------
    // | 以下为 Http 服务器配置
    // +----------------------------------------------------------------------

    /**
     * 上传文件的临时存放目录
     *
     * @var string
     */
    'upload_tmp_dir'                => null,

    /**
     * 是否开启 POST 消息解析
     *
     * true：自动将 Content-Type 为 x-www-form-urlencoded 的请求包体解析到 POST 数组。
     * false：将关闭POST解析
     *
     * @var bool
     */
    'http_parse_post'               => false,

    /**
     * 是否开启静态处理
     *
     * 开启后底层收到 Http 请求会先判断 document_root 路径下是否存在此文件，
     * 如果存在会直接发送文件内容给客户端，不再触发 onRequest 回调
     *
     * @var bool
     *
     * @since   1.9.17
     */
    'enable_static_handler'         => false,

    /**
     * 静态文件根目录
     *
     * @var     string
     *
     * @since   1.9.17
     */
    'document_root'                 => null,

];