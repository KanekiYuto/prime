<?php

namespace App\Cascade\Trace\Eloquent\Admin;

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
	const TABLE = 'admin_ability';

    /**
     * 主键
     *
     * @var string
     */
	const PRIMARY_KEY = self::ID;

    /**
	 * 能力 - [ID]
	 *
	 * @var string
	 */
	const ID = 'id';
	
	/**
	 * 能力名称
	 *
	 * @var string
	 */
	const NAME = 'name';
	
	/**
	 * 能力解释
	 *
	 * @var string
	 */
	const EXPLAIN = 'explain';
	
	/**
	 * 父级 - ID
	 *
	 * @var string
	 */
	const PARENT_ID = 'parent_id';
	
	/**
	 * 服务端路由
	 *
	 * @var string
	 */
	const SERVER_ROUTING = 'server_routing';
	
	/**
	 * 客户端路由
	 *
	 * @var string
	 */
	const CLIENT_ROUTING = 'client_routing';
	
	/**
	 * 允许操作的权限
	 *
	 * @var string
	 */
	const OPERATION = 'operation';
	
	/**
	 * 能力类型
	 *
	 * @var string
	 */
	const TYPE = 'type';
	
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
    const FILLABLE = [self::ID, self::NAME, self::EXPLAIN, self::PARENT_ID, self::SERVER_ROUTING, self::CLIENT_ROUTING, self::OPERATION, self::TYPE, self::CREATED_AT, self::UPDATED_AT];

}
