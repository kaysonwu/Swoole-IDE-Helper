<?php
namespace Swoole\Http;

/**
 * Http 请求对象
 * 保存了 Http 客户端请求的相关信息，包括 Get、Post、Cookie、Header 等
 * @package Swoole\Http
 */
class Request {

    /**
     * Http 请求的头部信息
     * 所有 key 均为小写
     *
     * @var array
     */
    public $header;

    /**
     * Http 请求的服务器信息
     * 相当于 PHP 的 $_SERVER 数组
     * 包含了 Http 请求的方法，URL 路径，客户端IP等信息
     *
     * @var array
     */
    public $server;

    /**
     * Http 请求的 GET 参数
     * 相当于 PHP 中的 $_GET
     *
     * @var array
     */
    public $get;

    /**
     * Http 请求的 POST 参数
     * 相当于 PHP 中的 $_POST
     *
     * @var array
     */
    public $post;

    /**
     * Http 请求携带的 Cookie 信息
     * 相当于 PHP 中的 $_COOKIE
     *
     * @var array
     */
    public $cookie;

    /**
     * Http 请求携带的文件上传信息
     * 相当于 PHP 中的 $_FILES
     *
     * @var array
     */
    public $files;

    /**
     * 获取原始的 POST 包体
     * 用于非 application/x-www-form-urlencoded 格式的 Http POST 请求
     *
     * @return string
     */
    public function rawContent(){}
}