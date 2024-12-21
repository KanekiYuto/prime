<?php

namespace App\Http\Controllers\DevOps;

use App\Cascade\Models\Admin\AbilityModel;
use App\Cascade\Summaries\Admin\AbilitySummary;
use Handyfit\Framework\Preacher\PreacherResponse;
use Handyfit\Framework\Support\Facades\Preacher;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

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
     * @param Request $request
     *
     * @return PreacherResponse
     */
    public function rely(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'parent_id' => ['required', 'integer'],
            'type' => ['required', Rule::in(['group', 'menu', 'ability'])],
        ]);

        $stack = AbilityModel::query()
            ->where(AbilitySummary::PARENT_ID, $requestParams[AbilitySummary::PARENT_ID])
            ->where(AbilitySummary::TYPE, $requestParams[AbilitySummary::TYPE])
            ->get([
                AbilitySummary::ID,
                AbilitySummary::NAME,
                AbilitySummary::EXPLAIN,
            ])->all();

        return Preacher::rows($stack);
    }

}
