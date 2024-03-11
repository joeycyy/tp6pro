<?php
declare (strict_types = 1);

namespace app;

use app\common\Common;
use app\model\admin\Admin;
use think\App;
use think\Config;
use think\exception\ValidateException;
use think\Response;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    use Common;
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];
    // 管理员信息
    protected $admin_info;
    protected $admin_id;
    protected $access;

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {
        // 登录验证
        $noLongin_arr = array(
            "login"
        );
        // 获取当前请求的控制器名
        $controller = request()->controller(true);
        // 如果不是登录的控制器，需要进行登录验证
        if (!in_array($controller, $noLongin_arr))
        {
            $check_res = $this->adminLoginCheck();
            dump($check_res);
        }
    }

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                list($validate, $scene) = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

    /*
     * 登录验证
     * */
    protected function adminLoginCheck()
    {
        $admin_id = session('admin_id');
        $admin_shell = session('admin_shell');
        if (empty($admin_id))
        {
            $admin_id = cookie('admin_id');
            $admin_shell = cookie('admin_shell');
        }
        if (empty($admin_id))
        {
            return $this->returnApi(config('status.fail'), 'admin_id为空');
        }
        $admin = new Admin();
        $admin_info = $admin->getAdminInfo($admin_id);
        if (empty($admin_info))
        {
            return $this->returnApi(config('status.fail'), '账号不存在');
        }

        if ($admin_shell != md5("LJAF&AFA".$admin['admin_id'].$admin['admin_pwd']))
        {
            return $this->returnApi(config('status.fail'), '登录已失效');
        }
        unset($admin_info['admin_pwd']);
        return $this->returnApi(config('status.success'), '登录信息校验通过', $admin_info);
    }
}
