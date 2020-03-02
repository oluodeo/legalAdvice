<?php

namespace app\exception;

use think\exception\Handle;
use Exception;//基类Exception
use think\Request;
use think\Log;

/*
 * 重写Handle的render方法，实现自定义异常消息
 */
class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    public function render(Exception $e)
     {
        if ($e instanceof BaseException)
        {
			$this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }
        else{
			// 如果是服务器未处理的异常，将http状态码设置为500，并记录日志
            if(config('app_debug')){
                // 调试状态下显示TP默认的异常页面
                return parent::render($e);
            }
			$this->code = 500;
            $this->msg = 'Internal Server Error!';
            $this->errorCode = 999;
			$this->recordErrorLog($e);
        }
//
        $request = Request::instance();
        $result = [
            'msg'  => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request = $request->url()
        ];
        return json($result, $this->code);
    }
	
	/*
     * 将异常写入日志
     */
    private function recordErrorLog(Exception $e)
    {
        Log::init([
            'type'  =>  'File',
            'path'  =>  LOG_PATH,
            'level' => ['error']
        ]);
//        Log::record($e->getTraceAsString());
        Log::record($e->getMessage(),'error');
    }

}