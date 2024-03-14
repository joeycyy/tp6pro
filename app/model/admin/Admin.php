<?php

namespace app\model\admin;

use think\Model;

class Admin extends Model {
    protected $pk = 'admin_id';

    // 设置字段信息
    protected $schema = [
        'admin_id' => 'int',
        'admin_name' => 'string',
        'admin_truename' => 'string',
        'admin_mobile' => 'string',
        'admin_dept' => 'string',
        'admin_role_id' => 'int',
        'admin_role_name' => 'string',
        'admin_status' => 'int',
        'add_datetime' => 'datetime'
    ];

    // 模型初始化
    protected static function init() {

    }

    // 插入数据-新增一个管理员
    public function addItem($data) {
        // 不需要在model层进行数据校验，一般在前端和controller进行拦截，默认model层都是合法的数据
        $data['admin_pwd'] = password_hash($data['pass'], PASSWORD_DEFAULT);
        $data['add_datetime'] = date("Y-m-d H:i:s");

        // 判断账号是否重复
        $item = $this->where("admin_name", $data['admin_name'])->find();
        if (!empty($item)) {
            return array('status' => 'FAIL', 'msg' => '该管理员账号已经存在，请重新输入');
        }

        $admin_id = $this->insertGetId($data);

        return array('status' => 'SUCCESS', 'msg' => '添加管理员成功', 'data' => array('admin_id' => $admin_id));
    }

    // 获取角色权限列表
    public function selectAllRole() {
        $roles = $this->select();
        echo $this->getLastSql();
        return $roles;
    }

    /*
     * 根据admin_id查找管理员信息
     * */
    public function getAdminInfo($admin_id) {
        return $this->where('admin_id', $admin_id)->findOrEmpty();
    }

    /*
     * 根据admin_name查找管理员信息
     * */
    public function getAdminInfoByAdminName($admin_name) {
        return $this->where('admin_name', $admin_name)->findOrEmpty();
    }
    public function checkLogin() {

    }
}