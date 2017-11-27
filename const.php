<?php
namespace Swoole;

/* 预定义常量 */

// 当前 Swoole 的版本号，字符串类型，如 1.6.0
define('SWOOLE_VERSION', '1.9.22');

/* Swoole\Server 构造函数参数 */

// 使用 Base 模式，业务代码在 Reactor 进程中直接执行
define('SWOOLE_BASE', 4);

// 使用进程模式，业务代码在Worker进程中执行
define('SWOOLE_PROCESS', 3);

/* Swoole\Client构造函数参数 */

// 创建 tcp socket
define('SWOOLE_SOCK_TCP', 1);

// 创建 tcp ipv6 socket
define('SWOOLE_SOCK_TCP6', 3);

// 创建 udp socket
define('SWOOLE_SOCK_UDP', 2);

// 创建 udp ipv6 socket
define('SWOOLE_SOCK_UDP6', 4);

// 同步客户端
define('SWOOLE_SOCK_SYNC', 0);

// 异步客户端
define('SWOOLE_SOCK_ASYNC', 1);

/* swoole_lock 构造函数参数 */

// 创建文件锁
define('SWOOLE_FILELOCK', 2);

// 创建互斥锁
define('SWOOLE_MUTEX', 3);

// 创建读写锁
define('SWOOLE_RWLOCK', 1);

// 创建自旋锁
define('SWOOLE_SPINLOCK', 5);

// 创建信号量
define('SWOOLE_SEM', 4);

/* SSL加密方法 */
define('SWOOLE_SSLv3_METHOD', SWOOLE_SSLv3_METHOD);

define('SWOOLE_SSLv3_SERVER_METHOD', SWOOLE_SSLv3_SERVER_METHOD);

define('SWOOLE_SSLv3_CLIENT_METHOD', SWOOLE_SSLv3_CLIENT_METHOD);

// 默认加密方法
define('SWOOLE_SSLv23_METHOD', SWOOLE_SSLv23_METHOD);

define('SWOOLE_SSLv23_SERVER_METHOD', SWOOLE_SSLv23_SERVER_METHOD);

define('SWOOLE_TLSv1_METHOD', SWOOLE_TLSv1_METHOD);

define('SWOOLE_TLSv1_SERVER_METHOD', SWOOLE_TLSv1_SERVER_METHOD);

define('SWOOLE_TLSv1_CLIENT_METHOD', SWOOLE_TLSv1_CLIENT_METHOD);

define('SWOOLE_TLSv1_1_METHOD', SWOOLE_TLSv1_1_METHOD);

define('SWOOLE_TLSv1_1_SERVER_METHOD', SWOOLE_TLSv1_1_SERVER_METHOD);

define('SWOOLE_TLSv1_1_CLIENT_METHOD', SWOOLE_TLSv1_1_CLIENT_METHOD);

define('SWOOLE_TLSv1_2_METHOD', SWOOLE_TLSv1_2_METHOD);

define('SWOOLE_TLSv1_2_SERVER_METHOD', SWOOLE_TLSv1_2_SERVER_METHOD);

define('SWOOLE_TLSv1_2_CLIENT_METHOD', SWOOLE_TLSv1_2_CLIENT_METHOD);

define('SWOOLE_DTLSv1_METHOD', SWOOLE_DTLSv1_METHOD);

define('SWOOLE_DTLSv1_SERVER_METHOD', SWOOLE_DTLSv1_SERVER_METHOD);

define('SWOOLE_DTLSv1_CLIENT_METHOD', SWOOLE_DTLSv1_CLIENT_METHOD);

/* Timer */

// 以系统真实的时间来计算，发送的信号是 SIGALRM
define('ITIMER_REAL', 0);

// 以该进程在用户态下花费的时间来计算，发送的信号是 SIGVTALRM
define('ITIMER_VIRTUAL', 1);

// 以该进程在用户态下和内核态下所费的时间来计算，发送的信号是 SIGPROF
define('ITIMER_PROF', 2);

/* WebSocket */

// UTF-8文本字符数据
define('WEBSOCKET_OPCODE_TEXT', 1);

// 二进制数据
define('WEBSOCKET_OPCODE_BINARY', 2);

// 心跳 ping 类型数据
define('WEBSOCKET_OPCODE_PING', 9);

// 连接进入等待握手
define('WEBSOCKET_STATUS_CONNECTION', 1);

// 正在握手
define('WEBSOCKET_STATUS_HANDSHAKE', 2);

// 已握手成功等待浏览器发送数据帧
define('WEBSOCKET_STATUS_FRAME', 3);