<?php

namespace App\Cascade\Trace\Eloquent\Admin;

use Handyfit\Framework\Trace\EloquentTrace;

/**
 * 追踪类 （帮助 IDE 更好地发现）
 *
 * @author KanekiYuto
 */
class LogTrace extends EloquentTrace
{

    /**
     * 表名称
     *
     * @var string
     */
    public const TABLE = 'admin_log';

    /**
     * 主键
     *
     * @var string
     */
    public const PRIMARY_KEY = self::ID;

    /**
     * 管理员日志ID
     *
     * @var string
     */
    public const ID = 'id';

    /**
     * 管理员ID
     *
     * @var string
     */
    public const ADMIN_ID = 'admin_id';

    /**
     * API名称
     *
     * @var string
     */
    public const API = 'api';

    /**
     * 请求IP
     *
     * @var string
     */
    public const IPADDRESS = 'ipaddress';

    /**
     * 请求荷载
     *
     * @var string
     */
    public const PAYLOAD = 'payload';

    /**
     * 请求头
     *
     * @var string
     */
    public const HEADERS = 'headers';

    /**
     * 响应参数
     *
     * @var string
     */
    public const RESPONSE = 'response';

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
    public const FILLABLE = [self::ID, self::ADMIN_ID, self::API, self::IPADDRESS, self::PAYLOAD, self::HEADERS, self::RESPONSE, self::CREATED_AT, self::UPDATED_AT];

}
