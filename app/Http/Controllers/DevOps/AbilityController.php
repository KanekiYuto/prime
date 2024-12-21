<?php

namespace App\Http\Controllers\DevOps;

use App\Cascade\Models\Admin\AbilityModel;
use App\Cascade\Trace\Eloquent\Admin\AbilityTrace;
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
            ->where(AbilityTrace::PARENT_ID, $requestParams[AbilityTrace::PARENT_ID])
            ->where(AbilityTrace::TYPE, $requestParams[AbilityTrace::TYPE])
            ->get([
                AbilityTrace::ID,
                AbilityTrace::NAME,
                AbilityTrace::EXPLAIN,
            ])->all();

        return Preacher::rows($stack);
    }

}
