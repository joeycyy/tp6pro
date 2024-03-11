<?php
/*
 * Common公共特征
 * */
namespace app\common;

use think\Response;

trait Common
{
    public function ReturnApi($data = [], $msg = '数据为空！', $code = 201, $type = 'json')
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        return Response::create($result, $type);
    }
}