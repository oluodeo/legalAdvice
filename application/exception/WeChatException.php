<?php


namespace app\exception;

/**
 * 微信服务器异常
 */
class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = 'wechat unknown error';
    public $errorCode = 999;
}