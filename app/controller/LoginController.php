<?php

namespace app\controller;

use app\BaseController;

class LoginController extends BaseController {
    public function index() {
        $view_data['admin_title'] = 'php管理后台';
        return view('login', $view_data);
    }

    public function loginAct() {

    }
}