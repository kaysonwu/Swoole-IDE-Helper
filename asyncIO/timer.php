<?php
namespace Swoole;

class Timer {

    /**
     * 设置一个间隔时钟定时器。
     *
     * @param   int         $ms             间隔时间，单位为毫秒。最大不得超过 86400000
     * @param   callback    $callback       回调函数。原型：function callback(int $timer_id, mixed $params = null)
     * @param   mixed       $user_param     用户参数，该参数会被传递到 $callback 中
     * @return  int                         定时器 ID
     */
    public function tick($ms, $callback, $user_param){}

    /**
     * 在指定的时间后执行函数。该函数是一个一次性定时器，执行完后就会销毁。
     *
     * @param   int        $after_time_ms   间隔时间，单位为毫秒。最大不得超过 86400000
     * @param   callback   $callback        回调函数。
     * @return  int                         定时器 ID
     */
    public function afer($after_time_ms, $callback){}

    /**
     * 使用定时器 ID 来删除定时器。
     *
     * @param   int   $timer_id
     * @return  bool
     */
    public function clear($timer_id){}
}
