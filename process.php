<?php
namespace Swoole;

/**
 * Swoole 进程管理
 * @package Swoole
 */
class  Process {

    /**
     * @param callback  $callback               子进程创建成功后要执行的函数
     * @param bool      $redirectStdinStdout    重定向子进程的标准输入和输出。启用此选项后，在子进程内输出内容将不是打印屏幕，
     *                                          而是写入到主进程管道。读取键盘输入将变为从管道中读取数据。默认为阻塞读取。
     * @param mixed     $createPipe             是否创建管道。
     *                                          小于等于 0 或为 false 时，不创建管道
     *                                          为 1 或为 true 时，管道类型将设置为 SOCK_STREAM
     *                                          为 2 时，管道类型将设置为 SOCK_DGRAM
     *                                          启用 $redirectStdinStdout 后，此选项将忽略用户参数，强制为1
     */
    public function __construct($callback, $redirectStdinStdout = false, $createPipe = true){}

    /**
     * 启动进程
     *
     * @return int|bool     创建成功返回子进程 PID，创建失败返回 false
     */
    public function start(){}

    /**
     * 修改进程名称
     *
     * name 方法应当在 start 之后的子进程回调函数中使用
     *
     * @param   string  $name   新进程名称
     * @return  bool
     *
     * @since   1.7.9+
     */
    public function name($name){}

    /**
     * 执行一个外部程序
     *
     * 此函数是 exec 系统调用的封装
     *
     * @param   string    $file 可执行文件的绝对路径
     * @param   array     $args exec 参数列表。
     * @return  bool
     *
     * @example $process->exec('/usr/bin/python', [('test.py', 123]) =  python test.py 123
     */
    public function exec($file, $args){}

    /**
     * 向管道内写入数据
     * @param   string  $data   待写入的数据。在 Linux 系统下最大不超过 8K，MacOS/FreeBSD 下最大不超过 2K
     * @return  int
     */
    public function write($data){}

    /**
     * 从管道中读取数据
     *
     * 这里是同步阻塞读取的，可以使用 swoole_event_add 将管道加入到事件循环中，变为异步模式
     *
     * @param   int $bufferSize 缓冲区大小。最大不超过 64k
     * @return  string|bool
     */
    public function read($bufferSize = 8192){}

    /**
     * 设置管道读写操作的超时时间
     *
     * @param   double  $timeout    超时时间。单位：秒
     * @return  bool
     *
     * @since   1.9.21
     */
    public function setTimeout($timeout){}

    /**
     * 启用消息队列作为进程间通信
     *
     * @param   int     $msgKey 消息队列的 Key。默认会使用 ftok(__FILE__, 1) 作为KEY
     * @param   int     $mode   通信模式。
     * @return  bool
     */
    public function useQueue($msgKey = 0, $mode = 2){}

    /**
     * 查看消息队列状态
     *
     * @return array    返回一个数组，包括 2 项信息
     *                  queue_num   队列中的任务数量
     *                  queue_bytes 队列数据的总字节数
     */
    public function statQueue(){}

    /**
     * 删除队列
     *
     * 如果程序中只调用了 useQueue 方法，未调用 freeQueue 在程序结束时并不会清除数据。
     * 重新运行程序时可以继续读取上次运行时留下的数据。
     * 系统重启时消息队列中的数据会被丢弃
     */
    public function freeQueue(){}

    /**
     * 投递数据到消息队列中
     *
     * 默认模式下（阻塞模式），如果队列已满，push 方法会阻塞等待
     * 非阻塞模式下，如果队列已满，push 方法会立即返回false
     *
     * @param   string  $data   要投递的数据。长度受限与操作系统内核参数的限制。默认为 8192，最大不超过 65536
     * @return  bool
     */
    public function push($data){}

    /**
     * 从队列中提取数据
     *
     * 默认模式下，如果队列中没有数据，pop 方法会阻塞等待
     * 非阻塞模式下，如果队列中没有数据，pop 方法会立即返回 false，并设置错误码为 ENOMSG
     *
     * @param   int $maxSize        获取数据的最大尺寸
     * @return  string|bool         操作成功会返回提取到的数据内容，失败返回 false
     */
    public function prop($maxSize = 8192){}

    /**
     * 关闭管道
     *
     * @return bool
     */
    public function close(){}

    /**
     * 退出子进程
     *
     * 异常退出不再执行 PHP 的 shutdown_function，其他扩展的清理工作
     * 在父进程中，执行 Process::wait 可以得到子进程退出的事件和状态码
     *
     * @param   int $status 退出进程的状态码。为 0 表示正常结束。不为 0，表示异常退出，会立即终止进程
     * @return  int
     */
    public function exit($status = 0){}

    /**
     * 向子进程发送信号
     *
     * @param   int   $pid      子进程ID
     * @param   int   $signo    信号
     * @return  bool
     */
    public static function kill($pid, $signo = SIGTERM){}

    /**
     * 回收结束运行的子进程
     *
     * @param   bool $blocking  是否阻塞等待
     * @return  array           操作成功会返回返回一个数组包含子进程的 PID、退出状态码、被哪种信号 kill，失败返回false
     *
     * @since   1.7.10+ $blocking 可用
     */
    public static function wait($blocking = true){}

    /**
     * 使当前进程蜕变为一个守护进程
     *
     * @param   bool $nochdir   是否不切换当前目录到根目录
     * @param   bool $noclose   是否不要关闭标准输入输出文件描述符
     * @return  bool
     *
     * @since   1.7.5-stable
     * @since   1.9.1-  $nochdir/$noclose 默认值均为 false
     */
    public static function daemon($nochdir = true, $noclose = true){}

    /**
     * 设置异步信号监听
     *
     * @param   int         $signo      信号
     * @param   callback    $callback   监听回调函数。为 null，表示移除信号监听
     * @return  bool
     *
     * @since   1.7.9+
     */
    public static function signal($signo, $callback){}

    /**
     * 高精度定时器，是操作系统 setitimer 系统调用的封装，可以设置微秒级别的定时器
     *
     * alarm 不能和 Swoole\Timer 同时使用
     *
     * @param   int     $intervalUsec   间隔时间。单位：微秒。如果为负数表示清除定时器
     * @param   int     $type           定时器类型
     *                                  0 表示为真实时间, 触发SIGALAM信号
     *                                  1 表示用户态 CPU 时间，触发 SIGVTALAM 信号
     *                                  2 表示用户态+内核态时间，触发 SIGPROF 信号
     * @return  bool
     *
     * @since   1.8.13
     */
    public static function alarm($intervalUsec, $type = ITIMER_REAL){}

    /**
     * 设置 CPU 亲和性，可以将进程绑定到特定的 CPU 核上
     *
     * 接受一个数组参数表示绑定哪些 CPU 核，如 [0,2,3] 表示绑定 CPU0/CPU2/CPU3
     *
     * @param   array $cpuSet
     * @return  bool
     *
     * @since   1.7.18+
     */
    public static function setaffinity($cpuSet){}
}