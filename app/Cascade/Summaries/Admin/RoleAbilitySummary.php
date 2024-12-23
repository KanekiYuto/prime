<?php

namespace App\Cascade\Summaries\Admin;

use Handyfit\Framework\Summary\Summary;

/**
 * Summary class
 *
 * @author KanekiYuto
 */
class RoleAbilitySummary extends Summary
{

    /**
     * 表名称
     *
     * @var string
     */
	public const TABLE = 'admin_role_ability';

    /**
     * 主键
     *
     * @var string
     */
	public const PRIMARY_KEY = self::ID;

    /**
	 * 角色能力 - [ID]
	 *
	 * @var string
	 */
	public const ID = 'id';
	
	/**
	 * 角色 - [ID]
	 *
	 * @var string
	 */
	public const ROLE_ID = 'role_id';
	
	/**
	 * 能力 - [ID]
	 *
	 * @var string
	 */
	public const ABILITY_ID = 'ability_id';
	
	/**
	 * 创建时间
	 *
	 * @var string
	 */
	public const CREATED_AT = 'created_at';
	
	/**
	 * 修改时间
	 *
	 * @var string
	 */
	public const UPDATED_AT = 'updated_at';

    /**
     * 隐藏列
     *
     * @var array<int, string>
     */
    public const HIDDEN = [];

    /**
     * 可填充的列
     *
     * @var array<int, string>
     */
    public const FILLABLE = [self::ID, self::ROLE_ID, self::ABILITY_ID, self::CREATED_AT, self::UPDATED_AT];

}