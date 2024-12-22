<?php

namespace App\Cascade\Summaries\Ability\Relation\Api;

use Handyfit\Framework\Summary\Summary;

/**
 * Summary class
 *
 * @author KanekiYuto
 */
class QuerySummary extends Summary
{

    /**
     * 表名称
     *
     * @var string
     */
	public const TABLE = 'ability_relation_api_query';

    /**
     * 主键
     *
     * @var string
     */
	public const PRIMARY_KEY = self::ID;

    /**
	 * ID
	 *
	 * @var string
	 */public const ID = 'id';
	/**
	 * 接口能力 - ID
	 *
	 * @var string
	 */public const API_ID = 'api_id';
	/**
	 * 查询能力 - ID
	 *
	 * @var string
	 */public const QUERY_ID = 'query_id';
	/**
	 * 创建时间
	 *
	 * @var string
	 */public const CREATED_AT = 'created_at';
	/**
	 * 修改时间
	 *
	 * @var string
	 */public const UPDATED_AT = 'updated_at';

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
    public const FILLABLE = [self::ID, self::API_ID, self::QUERY_ID, self::CREATED_AT, self::UPDATED_AT];

}