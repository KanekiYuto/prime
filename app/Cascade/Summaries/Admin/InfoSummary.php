<?php

namespace App\Cascade\Summaries\Admin;

use Handyfit\Framework\Summary\Summary;

/**
 * Summary class
 *
 * @author KanekiYuto
 */
class InfoSummary extends Summary
{

    /**
     * 表名称
     *
     * @var string
     */
    public const TABLE = 'admin_info';

    /**
     * 主键
     *
     * @var string
     */
    public const PRIMARY_KEY = self::ID;

    /**
     * 管理员ID
     *
     * @var string
     */
    public const ID = 'id';

    /**
     * 账号
     *
     * @var string
     */
    public const ACCOUNT = 'account';

    /**
     * 角色ID
     *
     * @var string
     */
    public const ADMIN_ROLE_ID = 'admin_role_id';

    /**
     * 邮箱
     *
     * @var string
     */
    public const EMAIL = 'email';

    /**
     * 密码
     *
     * @var string
     */
    public const PASS = 'pass';

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
    public const HIDDEN = [self::PASS];

    /**
     * 可填充的列
     *
     * @var array<int, string>
     */
    public const FILLABLE = [self::ID, self::ACCOUNT, self::ADMIN_ROLE_ID, self::EMAIL, self::PASS, self::CREATED_AT, self::UPDATED_AT];

}
