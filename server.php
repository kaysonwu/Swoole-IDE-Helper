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
     * @see config.php
     */
    public $setting = [];

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
     * 设置一个定时器
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
     * 在指定的时间后执行函数
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
     * 删除指定的定时器
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