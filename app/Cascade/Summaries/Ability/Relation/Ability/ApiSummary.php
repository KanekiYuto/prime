<?php

namespace App\Cascade\Summaries\Ability\Relation\Ability;

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
    public const TABLE = 'ability_relation_ability_api';

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
     * 能力信息 - ID
     *
     * @var string
     */
    public const ABILITY_ID = 'ability_id';

    /**
     * 接口能力 - ID
     *
     * @var string
     */
    public const API_ID = 'api_id';

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
    public const FILLABLE = [self::ID, self::ABILITY_ID, self::API_ID, self::CREATED_AT, self::UPDATED_AT];

}
