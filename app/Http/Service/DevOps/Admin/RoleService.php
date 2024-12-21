<?php

namespace App\Http\Service\DevOps\Admin;

use App\Experimental\Crush\Crush;
use Kaneki\Diverse\Equation\Equation;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;
use App\Cascade\Trace\Eloquent\Admin\AbilityTrace;
use App\Cascade\Models\Admin\RoleModel as AdminRole;
use App\Experimental\Crush\Params\Paging as PagingParams;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as TheTrace;

/**
 * 管理员角色服务类
 *
 * @author KanekiYuto
 */
class RoleService
{

    /**
     * 分页查询管理员角色信息
     *
     * @param  PagingParams  $pagingParams
     *
     * @return PreacherResponse
     */
    public static function paging(PagingParams $pagingParams): PreacherResponse
    {
        $model = AdminRole::query();

        return Crush::response(
            builder: $model,
            pagingParams: $pagingParams
        );
    }

    /**
     * 管理员角色选项
     *
     * @return PreacherResponse
     */
    public static function select(): PreacherResponse
    {
        $model = AdminRole::query();

        $model = Equation::build(
            model: $model,
            columns: [TheTrace::ID, TheTrace::NAME],
            aliases: [TheTrace::ID => 'value', TheTrace::NAME => 'label']
        );

        $model = $model->export()->get($model->getColumns());

        return Preacher::rows($model->toArray());
    }

    /**
     * 新增管理员角色信息
     *
     * @param  string  $name
     * @param  string  $explain
     *
     * @return PreacherResponse
     * @todo 需要更改
     *
     */
    public static function append(string $name, string $explain): PreacherResponse
    {
        $model = AdminRole::query();

        $model = $model->create([
            TheTrace::NAME => $name,
            TheTrace::EXPLAIN => $explain,
        ]);

        return Preacher::allow(
            $model->save(),
            Preacher::msg('新增成功'),
            Preacher::msgCode(
                PreacherResponse::RESP_CODE_FAIL,
                '新增失败'
            ),
        );
    }

    /**
     * 修改管理员角色信息
     *
     * @param  int     $id
     * @param  string  $name
     * @param  string  $explain
     *
     * @return PreacherResponse
     */
    public static function modify(
        int $id,
        string $name,
        string $explain
    ): PreacherResponse {
        $model = AdminRole::query()->find($id);

        $column = TheTrace::NAME;
        $model->$column = $name;
        $column = TheTrace::EXPLAIN;
        $model->$column = $explain;

        return Preacher::allow(
            $model->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(
                PreacherResponse::RESP_CODE_FAIL,
                '修改失败'
            ),
        );
    }

    /**
     * 设置角色能力
     *
     * @param  int  $id
     *
     * @return PreacherResponse
     */
    public static function ability(int $id): PreacherResponse
    {
        $model = AdminRole::query()->find($id);

        $abilities = $model->abilities()->pluck(
            AbilityTrace::TABLE . '.' . AbilityTrace::ID
        )->all();

//        $abilities = $model->abilities()->get([
//            AbilityTrace::TABLE . '.' . AbilityTrace::ID,
//            AbilityTrace::TABLE . '.' . AbilityTrace::PARENT_ID,
//            AbilityTrace::TABLE . '.' . AbilityTrace::NAME,
//            AbilityTrace::TABLE . '.' . AbilityTrace::EXPLAIN,
//        ])->all();

        return Preacher::rows($abilities);
    }

}
