<?php

namespace App\Cascade\Summaries\Personal;

use Handyfit\Framework\Summary\Summary;

/**
 * Summary class
 *
 * @author KanekiYuto
 */
class AccessTokensSummary extends Summary
{

    /**
     * 表名称
     *
     * @var string
     */
	public const TABLE = 'personal_access_tokens';

    /**
     * 主键
     *
     * @var string
     */
	public const PRIMARY_KEY = self::ID;

    /**
	 * 私人访问令牌ID
	 *
	 * @var string
	 */
	public const ID = 'id';
	
	/**
	 * 
	 *
	 * @var string
	 */
	public const TOKENABLE = 'tokenable';
	
	/**
	 * 令牌名称
	 *
	 * @var string
	 */
	public const NAME = 'name';
	
	/**
	 * 令牌内容
	 *
	 * @var string
	 */
	public const TOKEN = 'token';
	
	/**
	 * 令牌能力
	 *
	 * @var string
	 */
	public const ABILITIES = 'abilities';
	
	/**
	 * 令牌最终使用时间
	 *
	 * @var string
	 */
	public const LAST_USED_AT = 'last_used_at';
	
	/**
	 * 令牌过期时间
	 *
	 * @var string
	 */
	public const EXPIRES_AT = 'expires_at';
	
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
    public const HIDDEN = [self::TOKEN];

    /**
     * 可填充的列
     *
     * @var array<int, string>
     */
    public const FILLABLE = [self::NAME, self::TOKEN, self::ABILITIES, self::EXPIRES_AT];

}