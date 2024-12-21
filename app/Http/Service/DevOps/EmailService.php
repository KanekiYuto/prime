<?php

namespace App\Http\Service\DevOps;

use App\Mail\IdentifyingCode;
use Handyfit\Framework\Preacher\PreacherResponse;
use Handyfit\Framework\Support\Facades\Preacher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

/**
 * 验证码服务类
 *
 * @author KanekiYuto
 */
class EmailService
{

    /**
     * 发生验证码
     *
     * @param string $email
     * @param string $type
     *
     * @return PreacherResponse
     */
    public static function send(string $email, string $type): PreacherResponse
    {
        mt_srand();

        $code = mt_rand(100000, 999999);
        $validity = 10 * 60;

        $cache = Cache::put($type, $code, $validity);
        if (!$cache) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_FAIL,
                '失败'
            );
        }

        $identifyingCode = new IdentifyingCode(
            '测试验证码',
            $code,
            $validity
        );

        Mail::to($email)->send($identifyingCode);

        return Preacher::base();
    }

}
