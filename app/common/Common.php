<?php
/*
 * Common公共特征
 * 5.40新增
 * 为php单继承语言而准备的一种代码复用机制
 * */
namespace app\common;

use think\Response;

trait Common
{
    public function returnApi($data = [], $msg = '数据为空！', $code = 201, $type = 'json'): Response
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        return Response::create($result, $type);
    }
}