CREATE TABLE `admin` (
    `id` smallint unsigned NOT NULL AUTO_INCREMENT,
    `account` varchar(20) NOT NULL COMMENT '账号',
    `passwd` varchar(80) NOT NULL COMMENT '密码',
    `name` varchar(20) NOT NULL COMMENT '姓名',
    `remark` varchar(250) NOT NULL COMMENT '备注',
    `is_root` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '是否为rooter',
    `status` tinyint unsigned NOT NULL COMMENT '是否可用',
    PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员';

CREATE TABLE `role` (
    `id` smallint unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(20) NOT NULL COMMENT '角色名称',
    `remark` varchar(250) NOT NULL COMMENT '备注',
    PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理角色';

CREATE TABLE `admin_role_relation` (
    `id` smallint unsigned NOT NULL AUTO_INCREMENT,
    `admin_id` smallint unsigned NOT NULL COMMENT '管理员id',
    `role_id` smallint unsigned NOT NULL COMMENT '角色id',
    PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员-角色关联';

CREATE TABLE `permission` (
    `id` smallint unsigned NOT NULL AUTO_INCREMENT,
    `parent_id` smallint unsigned NOT NULL COMMENT '上级id',
    `name` varchar(20) NOT NULL COMMENT '权限名称',
    `actions` varchar(250) NOT NULL COMMENT '对应action; 多个用逗号隔开',
    PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理权限';

CREATE TABLE `role_permission_relation` (
    `id` smallint unsigned NOT NULL AUTO_INCREMENT,
    `role_id` smallint unsigned NOT NULL COMMENT '角色id',
    `permission_id` smallint unsigned NOT NULL COMMENT '权限id',
    PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色-权限关联';