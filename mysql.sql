-- 管理员表
CREATE TABLE `tp_admin` (
                            `admin_id` int(11) NOT NULL AUTO_INCREMENT,
                            `admin_name` varchar(30) NOT NULL,
                            `admin_pwd` varchar(100) NOT NULL,
                            `admin_truename` varchar(20) DEFAULT NULL,
                            `admin_mobile` varchar(11) DEFAULT NULL,
                            `admin_dept` varchar(30) DEFAULT NULL,
                            `admin_role_id` int(11) DEFAULT '0',
                            `admin_role_name` varchar(30) DEFAULT NULL,
                            `admin_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 正常 2 限制登录 3 封禁',
                            `add_datetime` datetime NOT NULL,
                            PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员';

--管理员操作日志
CREATE TABLE `tp_admin_op_log` (
                                   `id` int(11) NOT NULL AUTO_INCREMENT,
                                   `admin_id` int(11) DEFAULT '0',
                                   `admin_name` varchar(30) DEFAULT NULL,
                                   `op_url` varchar(100) DEFAULT NULL,
                                   `op_param` varchar(200) DEFAULT NULL,
                                   `op_controller` varchar(50) DEFAULT NULL,
                                   `op_action` varchar(50) DEFAULT NULL,
                                   `ip_address` varchar(20) DEFAULT NULL,
                                   `add_datetime` datetime DEFAULT NULL,
                                   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员操作日志';

-- 管理员权限表
CREATE TABLE `tp_admin_power` (
                                  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `pname` varchar(30) NOT NULL,
                                  `ptype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 一级菜单 2 二级菜单  3 操作',
                                  `parent_id` int(11) NOT NULL DEFAULT '0',
                                  `pcontroller` varchar(50) DEFAULT NULL,
                                  `paction` varchar(50) DEFAULT NULL,
                                  `pstatus` tinyint(1) DEFAULT '1' COMMENT '1 启用 2 关闭',
                                  `add_datetime` datetime DEFAULT NULL,
                                  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限表';

-- 管理员角色表
CREATE TABLE `tp_admin_role` (
                                 `role_id` int(11) NOT NULL AUTO_INCREMENT,
                                 `role_name` varchar(30) DEFAULT NULL,
                                 `role_desc` varchar(255) DEFAULT NULL,
                                 `role_powers` text,
                                 PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员角色';