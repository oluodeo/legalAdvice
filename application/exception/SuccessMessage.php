<?php

namespace app\exception;

/**
 * 404时抛出此异常
 */
class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg = 'ok';
    public $errorCode = 0;
}