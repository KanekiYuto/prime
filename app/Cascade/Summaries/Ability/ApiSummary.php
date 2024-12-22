<?php

namespace App\Cascade\Summaries\Ability;

use Handyfit\Framework\Summary\Summary;

/**
 * Summary class
 *
 * @author KanekiYuto
 */
class ApiSummary extends Summary
{

    /**
     * 表名称
     *
     * @var string
     */
    public const TABLE = 'ability_api';

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
     * 路由名称
     *
     * @var string
     */
    public const ROUTE = 'route';

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
    public const FILLABLE = [self::ID, self::NAME, self::EXPLAIN, self::ROUTE, self::CREATED_AT, self::UPDATED_AT];

}
