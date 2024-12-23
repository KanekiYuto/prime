<?php

namespace App\Http\Controllers\DevOps;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;
use App\Cascade\Models\AdminAbilityModel;
use App\Cascade\Summaries\AdminAbilitySummary;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;

/**
 * 能力控制器
 *
 * @author KanekiYuto
 */
class AbilityController
{

    /**
     * 根据能力依赖关系获取
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function rely(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'parent_id' => ['required', 'integer'],
            'type' => ['required', Rule::in(['group', 'menu', 'ability'])],
        ]);

        $stack = AdminAbilityModel::query()
            ->where(AdminAbilitySummary::PARENT_ID, $requestParams[AdminAbilitySummary::PARENT_ID])
            ->where(AdminAbilitySummary::TYPE, $requestParams[AdminAbilitySummary::TYPE])
            ->get([
                AdminAbilitySummary::ID,
                AdminAbilitySummary::NAME,
                AdminAbilitySummary::EXPLAIN,
            ])->all();

        return Preacher::rows($stack);
    }

}
