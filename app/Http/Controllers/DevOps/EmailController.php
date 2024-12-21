<?php

namespace App\Http\Controllers\DevOps;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;
use App\Http\Service\DevOps\EmailService;
use Handyfit\Framework\Preacher\PreacherResponse;

/**
 * 邮箱控制器
 *
 * @author KanekiYuto
 */
class EmailController
{

    /**
     * 发生邮件
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function send(Request $request): PreacherResponse
    {
        $typeRule = ['backstage-admin-modify-email'];
        $requestParams = $request::validate([
            'type' => ['required', 'string', Rule::in($typeRule)],
        ]);

        return EmailService::send($request::user('admin')->email, $requestParams['type']);
    }

}
