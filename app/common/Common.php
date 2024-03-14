<?php
/*
 * Common公共特征
 * 5.40新增
 * 为php单继承语言而准备的一种代码复用机制
 * */

namespace app\common;

use think\facade\Log;
use think\Response;

trait Common {
    /*
     * 用于和前端交互，返回失败的Response数据
     * */
    public function success($msg, $data = [], $code = 1, $type = 'json'): Response {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'status' => 'SUCCESS'
        ];
        Log::debug($msg, $data);
        return Response::create($result, $type);
    }

    /*
     * 用于和前端交互，返回失败的Response数据
     * */
    public function error($msg, $data = [], $code = 0, $type = 'json'): Response {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'status' => 'FAIL'
        ];
        Log::debug($msg, $data);
        return Response::create($result, $type);
    }

    /*
     * 后端自己的交互，返回一个数组
     * */
    public function returnApi($status, $msg = '', $data = []): array {
        Log::debug($msg, $data);
        return array(
            'status' => $status,
            'data' => $data,
            'msg' => $msg
        );
    }
}