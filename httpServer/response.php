<?php
namespace Swoole\Http;

/**
 * Http 响应对象
 * @package Swoole\Http
 */
class Response {

    /**
     * 设置 Http 响应的 Header 信息
     * 该设置必须在 end 方法之前执行
     *
     * @param   string  $key    键名。必须完全符合 Http 的约定，每个单词首字母大写，不得包含中文，下划线或者其他特殊字符
     * @param   string  $value  值。必须填写
     */
    public function header($key, $value){}

    /**
     * 设置 Http 响应的 Cookie 信息
     * 此方法参数与 PHP 的 setcookie 完全一致
     * 该设置必须在 end 方法之前执行
     *
     * @param   string      $key        名称
     * @param   string      $value      值
     * @param   int         $expire     有效期
     * @param   string      $path       服务器路径
     * @param   string      $domain     域名
     * @param   bool|false  $secure     是否通过安全的 Https 连接来传输 Cookie
     * @param   bool|false  $httpOnly   是否仅可通过 Http 协议访问
     * @return  bool
     */
    public function cookie($key, $value = '', $expire = 0, $path = '/', $domain = '', $secure = false, $httpOnly = false){}

    /**
     * 设置 Http 响应的状态码
     * 该设置必须在 end 方法之前执行
     *
     * @param int   $code
     */
    public function status($code){}

    /**
     * 是否启用 Http Gzip 压缩
     *
     * 压缩可以减小 Html 内容的尺寸，有效节省网络带宽，提高响应时间
     * jpg/png/gif 格式的图片已经经过压缩，无需再次压缩
     * 调用 gzip 方法后，底层会自动添加 Http 编码头，PHP 代码中不应当再行设置相关 Http 头
     * 该设置必需在 write/end 发送内容之前执行
     *
     * @param   int $level  压缩等级。范围是1-9，等级越高压缩后的尺寸越小，但CPU消耗更多。默认为 1
     *
     * @since   1.7.14+
     */
    public function gzip($level = 1){}

    /**
     * 启用 Http Chunk 分段向浏览器发送相应内容
     *
     * 使用 write 分段发送数据后，end 方法将不接受任何参数
     * 调用 end 方法后会发送一个长度为 0 的 Chunk 表示数据传输完毕
     *
     * @param   string $data    要发送的数据内容。最大长度不得超过 2M
     * @return  bool
     */
    public function write($data){}

    /**
     * 发送文件到浏览器
     *
     * sendFile 不支持 gzip 压缩
     * 调用 sendFile 前不得使用 write 方法发送 Http-Chunk
     * 底层无法推断要发送文件的 MIME 格式因此需要应用代码指定 Content-Type
     * 调用 sendFile 后底层会自动执行 end
     *
     * @param   string  $filename   要发送的文件路径。文件不存在或没有访问权限 sendFile 会失败
     * @param   int     $offset     上传文件的偏移量。可以指定从文件的中间部分开始传输数据。此特性可用于支持断点续传
     * @param   int     $length     发送数据的尺寸。默认为整个文件的尺寸
     * @return  bool
     *
     * @since   1.9.11  $offset/$length 可用
     * @example
     *
     * // 设置 MIME 格式
     * $response->header('Content-Type', 'image/jpeg');
     * $response->sendFile(__DIR__.$request->server['request_uri']);
     */
    public function sendFile($filename, $offset = 0, $length = 0){}

    /**
     * 发送 Http 响应体，并结束请求处理
     *
     * end 操作后将向客户端浏览器发送 HTML 内容
     * end 只能调用一次，如果需要分多次向客户端发送数据，请使用 write 方法
     * 客户端开启了 KeepAlive，连接将会保持，服务器会等待下一次请求
     * 客户端未开启 KeepAlive，服务器将会切断连接
     *
     * @param string    $html
     */
    public function end($html){}
}