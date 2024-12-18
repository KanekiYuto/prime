<?php

namespace App\Cascade\Trace\Eloquent\AdminRole;

use Handyfit\Framework\Trace\EloquentTrace;

/**
 * 追踪类 （帮助 IDE 更好地发现）
 *
 * @author KanekiYuto
 */
class AbilityTrace extends EloquentTrace
{

    /**
     * 表名称
     *
     * @var string
     */
	const TABLE = 'admin_role_ability';

    /**
     * 主键
     *
     * @var string
     */
	const PRIMARY_KEY = self::ID;

    /**
	 * 角色能力 - [ID]
	 *
	 * @var string
	 */
	const ID = 'id';
	
	/**
	 * 角色 - [ID]
	 *
	 * @var string
	 */
	const ROLE_ID = 'role_id';
	
	/**
	 * 能力 - [ID]
	 *
	 * @var string
	 */
	const ABILITY_ID = 'ability_id';
	
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
    const HIDDEN = [];

    /**
     * 可填充的列
     *
     * @var array<int, string>
     */
    const FILLABLE = [self::ID, self::ROLE_ID, self::ABILITY_ID, self::CREATED_AT, self::UPDATED_AT];

}
