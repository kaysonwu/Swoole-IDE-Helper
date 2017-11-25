<?php
namespace Swoole;

/**
 * 内存表
 * @package Swoole
 */
class Table {

    /**
     * 获取实际占用内存的尺寸，单位为字节
     * @var int
     */
    public $memorySize;

    /**
     * 整型字段 默认为 4 个字节，以设置1，2，4，8一共4种长度
     */
    const TYPE_INT = 1;

    /**
     * 浮点型字段 占用8个字节的内存
     */
    const TYPE_FLOAT = 6;

    /**
     * 字符串字段
     */
    const TYPE_STRING = 7;

    /***
     *
     * @param int $size 指定表的最大行数
     */
    public function __construct($size){}

    /***
     * 增加列
     * @param string    $name   字段名称
     * @param int       $type   字段类型。参考 TYPE_ 常量
     * @param int       $size   字段长度，单位位字节。字符串类型的字段必需指定长度
     * @return bool
     */
    public function column($name, $type, $size = 0){}

    /**
     * 创建内存表
     * @return  bool
     */
    public function create(){}

    /**
     * 设置行的数据
     * @param string    $key        数据的 Key。相同的 key 对应同一行数据，如果 set同一个 key，会覆盖上一次的数据
     * @param array     $array      必须是一个数组，必须与字段定义的 name 完全相同
     */
    public function set($key, $array){}

    /**
     * 获取一行数据
     * @param   string    $key        数据的 Key
     * @param   string    $field      列名。当指定了列名时仅返回该字段的值，而不是整个记录
     * @return  array
     */
    public function get($key, $field = null){}

    /***
     * 原子自增
     * @param   string    $key      数据的 Key
     * @param   string    $column   列名。仅支持浮点型和整型字段
     * @param   int       $incrby   增量值
     * @return  mixed               失败返回 false，成功返回最终的结果数值
     */
    public function incr($key, $column, $incrby = 1){}

    /***
     * 原子自减
     * @param   string    $key      数据的 Key
     * @param   string    $column   列名。仅支持浮点型和整型字段
     * @param   int       $decrby   减量值
     * @return  mixed               失败返回 false，成功返回最终的结果数值
     */
    public function decr($key, $column, $decrby = 1){}

    /**
     * 检查表中是否存在某一个键
     * @param  string $key
     * @return bool
     */
    public function exist($key){}

    /***
     * 删除数据
     * @param   string $key
     * @return  bool
     */
    public function del($key){}
}