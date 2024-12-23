<?php

namespace App\Cascade\Summaries;

use Handyfit\Framework\Summary\Summary;

/**
 * Summary class
 *
 * @author KanekiYuto
 */
class AbilityInfoSummary extends Summary
{

    /**
     * 表名称
     *
     * @var string
     */
	public const TABLE = 'ability_info';

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
	 */
	public const ID = 'id';
	
	/**
	 * 名称
	 *
	 * @var string
	 */
	public const NAME = 'name';
	
	/**
	 * 说明
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
	 * 类型
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
    public const FILLABLE = [self::ID, self::NAME, self::EXPLAIN, self::PARENT_ID, self::TYPE, self::CREATED_AT, self::UPDATED_AT];

}