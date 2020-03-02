<?php

namespace app\exception;

class UserException extends BaseException
{
	public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 30000;
}