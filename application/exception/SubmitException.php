<?php

namespace app\exception;

class SubmitException extends BaseException
{
    public $code = 404;
    public $msg = '提交失败';
    public $errorCode = 10006;
}