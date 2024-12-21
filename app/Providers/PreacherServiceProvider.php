<?php

namespace App\Providers;

use Handyfit\Framework\Support\Facades\Preacher;
use Illuminate\Support\ServiceProvider;

/**
 * [Preacher] 服务提供者
 *
 * @author KanekiYuto
 */
class PreacherServiceProvider extends ServiceProvider
{

    /**
     * 引导服务
     *
     * @return void
     */
    public function boot(): void
    {
        // 实现国际化语言服务
        Preacher::useMsgHook(function (string $message) {
            $message = __("message.$message");
            return str_replace('message.', '', $message);
        });
    }

}
