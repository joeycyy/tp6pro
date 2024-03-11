<?php

namespace app\model\admin;

use think\Model;

/**
 *管理员角色
 */
class AdminRole extends Model
{
    public function getAllAdminRole()
    {
        $roles = $this->select();
        return $roles;
    }
}