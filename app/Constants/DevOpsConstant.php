<?php

namespace App\Constants;

/**
 * 后台常量类
 *
 * @author KanekiYuto
 */
class DevOpsConstant
{

    /**
     * 签发凭证有效时间（秒）
     *
     * @var int
     */
    public const TOKEN_VALIDITY = 30 * 60;

    /**
     * 守卫名称
     *
     * @var string
     */
    public const GUARD = 'admin';

}
