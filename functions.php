<?php

// 说明：推荐使用命名空间 + 对象的方式使用 Swoole，而不是采用以下函数

/**
 * 创建一个异步服务器程序
 *
 * @return \Swoole\Server
 */
function swoole_server(){}

/**
 * 创建一个客户端程序
 *
 * @return \Swoole\Client
 *
 * @deprecated
 */
function swoole_client(){}

/**
 * 创建一个进程管理对象
 *
 * @return      \Swoole\Process
 *
 * @deprecated
 */
function swoole_process(){}

/**
 * 设置一个间隔时钟定时器。
 *
 * @param   int         $ms             间隔时间，单位为毫秒。最大不得超过 86400000
 * @param   callback    $callback       回调函数。原型：function callback(int $timer_id, mixed $params = null)
 * @param   mixed       $user_param     用户参数，该参数会被传递到 $callback 中
 * @return  int                         定时器 ID
 *
 * @deprecated
 */
function swoole_timer_tick($ms, $callback, $user_param){}

/**
 * 在指定的时间后执行函数。该函数是一个一次性定时器，执行完后就会销毁。
 *
 * @param   int        $after_time_ms   间隔时间，单位为毫秒。最大不得超过 86400000
 * @param   callback   $callback        回调函数。
 * @return  int                         定时器 ID
 *
 * @deprecated
 */
function swoole_timer_after($after_time_ms, $callback){}

/**
 * 使用定时器 ID 来删除定时器。
 *
 * @param   int   $timer_id
 * @return  bool
 *
 * @deprecated
 */
function swoole_timer_clear($timer_id){}