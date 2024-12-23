<?php

namespace App\Http\Service\DevOps\Admin;

use App\Cascade\Models\AdminRoleModel;
use App\Cascade\Summaries\AdminAbilitySummary;
use App\Cascade\Summaries\AdminRoleSummary;
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
        $model = AdminRoleModel::query();

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
        $model = AdminRoleModel::query();

        $model = Equation::build(
            model: $model,
            columns: [AdminRoleSummary::ID, AdminRoleSummary::NAME],
            aliases: [AdminRoleSummary::ID => 'value', AdminRoleSummary::NAME => 'label']
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
        $model = AdminRoleModel::query();

        $model = $model->create([
            AdminRoleSummary::NAME => $name,
            AdminRoleSummary::EXPLAIN => $explain,
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
        $model = AdminRoleModel::query()->find($id);

        $column = AdminRoleSummary::NAME;
        $model->$column = $name;
        $column = AdminRoleSummary::EXPLAIN;
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
        $model = AdminRoleModel::query()->find($id);

        $abilities = $model->abilities()->pluck(
            AdminAbilitySummary::TABLE . '.' . AdminAbilitySummary::ID
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
