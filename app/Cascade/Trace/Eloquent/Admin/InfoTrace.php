<?php

namespace App\Cascade\Trace\Eloquent\Admin;

use Handyfit\Framework\Trace\EloquentTrace;

/**
 * 追踪类 （帮助 IDE 更好地发现）
 *
 * @author KanekiYuto
 */
class InfoTrace extends EloquentTrace
{

    /**
     * 表名称
     *
     * @var string
     */
	const TABLE = 'admin_info';

    /**
     * 主键
     *
     * @var string
     */
	const PRIMARY_KEY = self::ID;

    /**
	 * 管理员ID
	 *
	 * @var string
	 */
	const ID = 'id';
	
	/**
	 * 账号
	 *
	 * @var string
	 */
	const ACCOUNT = 'account';
	
	/**
	 * 角色ID
	 *
	 * @var string
	 */
	const ADMIN_ROLE_ID = 'admin_role_id';
	
	/**
	 * 邮箱
	 *
	 * @var string
	 */
	const EMAIL = 'email';
	
	/**
	 * 密码
	 *
	 * @var string
	 */
	const PASS = 'pass';
	
	/**
	 * 创建时间
	 *
	 * @var string
	 */
	const CREATED_AT = 'created_at';
	
	/**
	 * 修改时间
	 *
	 * @var string
	 */
	const UPDATED_AT = 'updated_at';
	

    /**
     * 隐藏列
     *
     * @var array<int, string>
     */
    const HIDDEN = [self::PASS];

    /**
     * 可填充的列
     *
     * @var array<int, string>
     */
    const FILLABLE = [self::ID, self::ACCOUNT, self::ADMIN_ROLE_ID, self::EMAIL, self::PASS, self::CREATED_AT, self::UPDATED_AT];

}
