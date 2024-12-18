<?php

namespace App\Constants;

/**
 * 后台常量类
 *
 * @author KanekiYuto
 */
class BackstageConstant
{

    /**
     * 签发凭证有效时间（秒）
     *
     * @var int
     */
    const TOKEN_VALIDITY = 30 * 60;

    /**
     * 守卫名称
     *
     * @var string
     */
    const GUARD = 'admin';

}
