<?php

namespace App\Cascade\Summaries;

use Handyfit\Framework\Summary\Summary;

/**
 * Summary class
 *
 * @author KanekiYuto
 */
class AdminAbilitySummary extends Summary
{

    /**
     * 表名称
     *
     * @var string
     */
	public const TABLE = 'admin_ability';

    /**
     * 主键
     *
     * @var string
     */
	public const PRIMARY_KEY = self::ID;

    /**
	 * 能力 - [ID]
	 *
	 * @var string
	 */
	public const ID = 'id';
	
	/**
	 * 能力名称
	 *
	 * @var string
	 */
	public const NAME = 'name';
	
	/**
	 * 能力解释
	 *
	 * @var string
	 */
	public const EXPLAIN = 'explain';
	
	/**
	 * 父级 - ID
	 *
	 * @var string
	 */
	public const PARENT_ID = 'parent_id';
	
	/**
	 * 服务端路由
	 *
	 * @var string
	 */
	public const SERVER_ROUTING = 'server_routing';
	
	/**
	 * 客户端路由
	 *
	 * @var string
	 */
	public const CLIENT_ROUTING = 'client_routing';
	
	/**
	 * 允许操作的权限
	 *
	 * @var string
	 */
	public const OPERATION = 'operation';
	
	/**
	 * 能力类型
	 *
	 * @var string
	 */
	public const TYPE = 'type';
	
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
    public const FILLABLE = [self::ID, self::NAME, self::EXPLAIN, self::PARENT_ID, self::SERVER_ROUTING, self::CLIENT_ROUTING, self::OPERATION, self::TYPE, self::CREATED_AT, self::UPDATED_AT];

}