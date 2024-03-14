<?php

namespace app\controller;

use app\BaseController;
use app\model\admin\Admin;
use think\captcha\facade\Captcha;
use think\facade\Log;
use think\Response;
use think\Response\View;

class LoginController extends BaseController {
    // 显示登录模板
    public function index(): View {
        Log::debug('登录Index');
        $view_data['admin_title'] = 'php管理后台';
        return view('login', $view_data);
    }

    // 登录操作
    public function loginAct(): Response {
        Log::debug('登录操作');
        // 获取前端传入参数
            $data = request()->param();
        // 校验输入的验证码是否正确
        if (!captcha_check($data['vercode'])) {
//            return $this->error('验证码输入错误');
        }

        $username = $data['username'];
        if (empty($username)) {
            return $this->error('管理员账号为空');
        }

        // 登录验证
        $admin = new Admin();
        $admin_info = $admin->getAdminInfoByAdminName($username);

        // 如果找不到对应的管理员账号信息
        if (empty($admin_info)) {
            return $this->error('登录失败,账号或密码错误！');
        }
        // 判断密码是否正确
        if (!password_verify($data['password'], $admin_info['admin_pwd'])) {
            // TODO 增加日记
            return $this->error('登录失败,账号或密码错误！');
        }

        // 判断账号状态
        if ($admin_info['admin_status'] == 2) {
            return $this->error('登录失败,账号已被限制登录！');
        } elseif ($admin_info['admin_status'] == 3) {
            return $this->error('登录失败,账号已被冻结！');
        }

        // 判断当天是否登录错误超过10次 TODO

        // 记录登录日志 TODO

        // 记录session和cookie TODO
        session('admin_id', $admin_info['admin_id']);
        session('admin_name', $admin_info['admin_name']);
        session('admin_shell', md5("LJAF&AFA" . $admin_info['admin_id'] . $admin_info['admin_pwd']));

        // 保存密码，则保存cookie15天
        if ($admin_info['remember'] == 1) {
            cookie('admin_id', $admin_info['admin_id'], 1296000);
            cookie('admin_name', $admin_info['admin_name'], 1296000);
            cookie('admin_shell', md5("LJAF&AFA" . $admin_info['admin_id'] . $admin_info['admin_pwd']), 1296000);
        }

        return $this->success('登录成功！');
    }

    // 登录验证码图片生成
    public function loginYzm(): Response {
        Log::debug('验证码生成');
        return Captcha::create();
    }
}