<?php

namespace App\Http\Service\DevOps\Admin;

use App\Cascade\Models\Admin\RoleModel as AdminRole;
use App\Cascade\Summaries\Admin\AbilitySummary;
use App\Cascade\Summaries\Admin\RoleSummary as TheSummary;
use App\Experimental\Crush\Crush;
use App\Experimental\Crush\Params\Paging as PagingParams;
use Handyfit\Framework\Preacher\PreacherResponse;
use Handyfit\Framework\Support\Facades\Preacher;
use Kaneki\Diverse\Equation\Equation;

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
     * @param PagingParams $pagingParams
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
            columns: [TheSummary::ID, TheSummary::NAME],
            aliases: [TheSummary::ID => 'value', TheSummary::NAME => 'label']
        );

        $model = $model->export()->get($model->getColumns());

        return Preacher::rows($model->toArray());
    }

    /**
     * 新增管理员角色信息
     *
     * @param string $name
     * @param string $explain
     *
     * @return PreacherResponse
     *
     * @todo 需要更改
     */
    public static function append(string $name, string $explain): PreacherResponse
    {
        $model = AdminRole::query();

        $model = $model->create([
            TheSummary::NAME => $name,
            TheSummary::EXPLAIN => $explain,
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
     * @param int    $id
     * @param string $name
     * @param string $explain
     *
     * @return PreacherResponse
     */
    public static function modify(
        int $id,
        string $name,
        string $explain
    ): PreacherResponse {
        $model = AdminRole::query()->find($id);

        $column = TheSummary::NAME;
        $model->$column = $name;
        $column = TheSummary::EXPLAIN;
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
     * @param int $id
     *
     * @return PreacherResponse
     */
    public static function ability(int $id): PreacherResponse
    {
        $model = AdminRole::query()->find($id);

        $abilities = $model->abilities()->pluck(
            AbilitySummary::TABLE . '.' . AbilitySummary::ID
        )->all();

        //        $abilities = $model->abilities()->get([
        //            AbilitySummary::TABLE . '.' . AbilitySummary::ID,
        //            AbilitySummary::TABLE . '.' . AbilitySummary::PARENT_ID,
        //            AbilitySummary::TABLE . '.' . AbilitySummary::NAME,
        //            AbilitySummary::TABLE . '.' . AbilitySummary::EXPLAIN,
        //        ])->all();

        return Preacher::rows($abilities);
    }

}
