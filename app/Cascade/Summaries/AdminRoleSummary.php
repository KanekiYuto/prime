<?php

namespace App\Cascade\Summaries;

use Handyfit\Framework\Summary\Summary;

/**
 * Summary class
 *
 * @author KanekiYuto
 */
class AdminRoleSummary extends Summary
{

    /**
     * 表名称
     *
     * @var string
     */
	public const TABLE = 'admin_role';

    /**
     * 主键
     *
     * @var string
     */
	public const PRIMARY_KEY = self::ID;

    /**
	 * 管理员角色ID
	 *
	 * @var string
	 */
	public const ID = 'id';
	
	/**
	 * 管理员角色名称
	 *
	 * @var string
	 */
	public const NAME = 'name';
	
	/**
	 * 管理员角色说明
	 *
	 * @var string
	 */
	public const EXPLAIN = 'explain';
	
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
    public const FILLABLE = [self::ID, self::NAME, self::EXPLAIN, self::CREATED_AT, self::UPDATED_AT];

}