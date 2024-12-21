<?php

namespace Database\Seeders;

use App\Cascade\Models\Admin\AbilityModel;
use App\Cascade\Models\Admin\InfoModel as AdminInfo;
use App\Cascade\Models\Admin\RoleModel;
use App\Cascade\Models\AdminRole\AbilityModel as AdminRoleAbilityModel;
use App\Cascade\Summaries\Admin\InfoSummary as TheSummary;
use App\Cascade\Summaries\Admin\RoleSummary;
use App\Cascade\Summaries\AdminRole\AbilitySummary as AdminRoleAbilityTrace;
use App\Seeders\Ability;
use Handyfit\Framework\Preacher\PreacherResponse;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Support\Timestamp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * 管理员信息初始化
 *
 * @author KanekiYuto
 */
class AdminInitSeeder extends Seeder
{

    /**
     * 运行数据库迁移
     *
     * @return void
     */
    public function run(): void
    {
        DB::beginTransaction();

        $runRole = $this->runRole();

        if (!$runRole->isSucceed()) {
            DB::rollBack();
            return;
        }

        $runAbility = $this->runAbility();

        if (!$runAbility->isSucceed()) {
            DB::rollBack();
            return;
        }

        $runAbilityRole = $this->runAbilityRole(
            $runRole->getReceipt()->id,
            $runAbility->getRows()
        );

        if (!$runAbilityRole->isSucceed()) {
            DB::rollBack();
            return;
        }

        $runInfo = $this->runInfo($runRole->getReceipt()->id);

        if (!$runInfo->isSucceed()) {
            DB::rollBack();
            return;
        }

        DB::commit();
    }

    /**
     * 创建角色
     *
     * @return PreacherResponse
     */
    public function runRole(): PreacherResponse
    {
        $id = Timestamp::millisecond();

        $result = RoleModel::query()->create([
            RoleSummary::ID => $id,
            RoleSummary::NAME => '超级管理员',
            RoleSummary::EXPLAIN => '拥有平台所有权限',
        ]);

        return Preacher::allow(
            $result->save(),
            Preacher::msgCode(
                PreacherResponse::RESP_CODE_SUCCEED,
                '角色创建成功'
            )->setReceipt((object) [
                'id' => $id,
            ]),
            Preacher::msgCode(PreacherResponse::RESP_CODE_FAIL, '角色创建失败')
        );
    }

    /**
     * 创建能力角色关联
     *
     * @param int   $roleId
     * @param array $abilityStack
     *
     * @return PreacherResponse
     */
    public function runAbilityRole(int $roleId, array $abilityStack): PreacherResponse
    {
        foreach ($abilityStack as $stack) {
            $id = Ability::createId();

            $result = AdminRoleAbilityModel::query()->create([
                AdminRoleAbilityTrace::ID => $id,
                AdminRoleAbilityTrace::ROLE_ID => $roleId,
                AdminRoleAbilityTrace::ABILITY_ID => $stack['id'],
            ]);

            if (!$result->save()) {
                return Preacher::msgCode(
                    PreacherResponse::RESP_CODE_FAIL,
                    '能力角色关联创建失败'
                );
            }
        }

        return Preacher::msgCode(
            PreacherResponse::RESP_CODE_SUCCEED,
            '能力角色关联创建成功'
        );
    }

    /**
     * 创建管理员信息
     *
     * @param int $roleId
     *
     * @return PreacherResponse
     */
    public function runInfo(int $roleId): PreacherResponse
    {
        $stack = collect()->push([
            TheSummary::ACCOUNT => 'phpunit@master',
            TheSummary::PASS => Hash::make('phpunit@pass'),
            TheSummary::EMAIL => 'phpunit-master@rubust.com',
            TheSummary::ADMIN_ROLE_ID => $roleId,
        ])->push([
            TheSummary::ACCOUNT => 'KanekiYuto',
            TheSummary::PASS => Hash::make('KanekiYuto@pass'),
            TheSummary::EMAIL => 'kaneki.yuto.404@gmail.com',
            TheSummary::ADMIN_ROLE_ID => $roleId,
        ]);

        foreach ($stack as $item) {
            $result = AdminInfo::query()->create($item);

            if (!$result->save()) {
                return Preacher::msgCode(
                    PreacherResponse::RESP_CODE_FAIL,
                    '管理员信息创建失败'
                );
            }
        }

        return Preacher::msgCode(
            PreacherResponse::RESP_CODE_SUCCEED,
            '管理员信息创建成功'
        );
    }

    /**
     * 创建能力信息
     *
     * @return PreacherResponse
     */
    private function runAbility(): PreacherResponse
    {
        $parentId = Ability::createId();

        $stack = Ability::create(
            0,
            '管理员相关',
            $parentId,
            'group'
        )->appendChildren(function (int $parentId) {
            // 管理员信息相关能力
            return Ability::menu(
                '信息相关',
                $parentId
            )->setClientRouting('admin-info-manage')->appendChildren(function (int $parentId) {
                return Ability::ability('新增', $parentId)->setServerRouting([
                    'dev-ops.admin.info:append',
                ])->setOperation([
                    'admin-info-append' => 'button',
                ]);
            })->appendChildren(function (int $parentId) {
                return Ability::ability('查询', $parentId)->setServerRouting([
                    'dev-ops.admin.info:paging',
                ]);
            })->appendChildren(function (int $parentId) {
                return Ability::ability('修改', $parentId)->setServerRouting([
                    'dev-ops.admin.info:modify',
                    'dev-ops.admin.role:select',
                ])->setOperation([
                    'admin-info-modify' => 'button',
                ]);
            });
        })->appendChildren(function (int $parentId) {
            return Ability::menu(
                '角色相关',
                $parentId
            )->setClientRouting('admin-role-manage')->appendChildren(function (int $parentId) {
                return Ability::ability('新增', $parentId)->setServerRouting([
                    'dev-ops.admin.role:append',
                ])->setOperation([
                    'admin-role-append' => 'button',
                ]);
            })->appendChildren(function (int $parentId) {
                return Ability::ability('查询', $parentId)->setServerRouting([
                    'dev-ops.admin.role:paging',
                ]);
            })->appendChildren(function (int $parentId) {
                return Ability::ability('修改', $parentId)->setServerRouting([
                    'dev-ops.admin.role:modify',
                ])->setOperation([
                    'admin-role-modify' => 'button',
                ]);
            })->appendChildren(function (int $parentId) {
                return Ability::ability('能力配置', $parentId)->setServerRouting([
                    'dev-ops.ability:abilities',
                    'dev-ops.ability:groups',
                    'dev-ops.admin.role:ability',
                ]);
            });
        })->appendChildren(function (int $parentId) {
            return Ability::menu(
                '日志相关',
                $parentId
            )->setClientRouting('admin-log-manage')->appendChildren(function (int $parentId) {
                return Ability::ability('查询', $parentId)->setServerRouting([
                    'dev-ops.admin.log:paging',
                    'dev-ops.admin.info:select',
                ]);
            });
        })->toArray();

        foreach ($stack as $item) {
            $result = AbilityModel::query()->create($item);

            if (!$result) {
                return Preacher::msgCode(
                    PreacherResponse::RESP_CODE_FAIL,
                    '能力创建失败'
                );
            }
        }

        return Preacher::msgCode(
            PreacherResponse::RESP_CODE_SUCCEED,
            '能力创建成功'
        )->setRows($stack);
    }

}
