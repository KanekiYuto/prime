<?php

namespace Database\Seeders;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Cascade\Models\Admin\AbilityModel;
use App\Cascade\Trace\Eloquent\Admin\AbilityTrace;

/**
 * 管理员信息初始化
 *
 * @author KanekiYuto
 */
class AdminInitSeeder extends Seeder
{

    /**
     * 能力参数
     *
     * @var array
     */
    public array $params = [];


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uuid = Str::uuid()->toString();

        $this->ability(
            name: '管理员相关',
            parentUuid: $uuid,
            children: function (string $uuid) {
                // 管理员信息
                $this->ability(
                    name: '信息相关',
                    parentUuid: $uuid,
                    children: function (string $uuid) {
                        $this->ability(name: '新增', parentUuid: $uuid, serverRouting: [
                            'backstage.admin.info:append',
                        ], operation: [
                            'admin-info-append' => 'button',
                        ], type: 'ability');

                        $this->ability(name: '查询', parentUuid: $uuid, serverRouting: [
                            'backstage.admin.info:paging',
                        ], type: 'ability');

                        $this->ability(name: '修改', parentUuid: $uuid, serverRouting: [
                            'backstage.admin.info:modify',
                            'backstage.admin.role:select',
                        ], operation: [
                            'admin-info-modify' => 'button',
                        ], type: 'ability');
                    },
                    clientRouting: 'admin-info-manage',
                    type: 'menu'
                );

                // 管理员角色
                $this->ability(
                    name: '日志相关',
                    parentUuid: $uuid,
                    children: function (string $uuid) {
                        $this->ability(name: '新增', parentUuid: $uuid, serverRouting: [
                            'backstage.admin.role:append',
                        ], operation: [
                            'admin-role-append' => 'button',
                        ], type: 'ability');

                        $this->ability(name: '查询', parentUuid: $uuid, serverRouting: [
                            'backstage.admin.role:paging',
                        ], type: 'ability');

                        $this->ability(name: '修改', parentUuid: $uuid, serverRouting: [
                            'backstage.admin.role:modify',
                        ], operation: [
                            'admin-role-modify' => 'button',
                        ], type: 'ability');

                        $this->ability(name: '能力配置', parentUuid: $uuid, serverRouting: [
                            'backstage.ability:abilities',
                            'backstage.ability:groups',
                            'backstage.admin.role:ability',
                        ], type: 'ability');
                    },
                    clientRouting: 'admin-role-manage',
                    type: 'menu'
                );

                // 管理员日志
                $this->ability(
                    name: '信息相关',
                    parentUuid: $uuid,
                    children: function (string $uuid) {
                        $this->ability(name: '查询', parentUuid: $uuid, serverRouting: [
                            'backstage.admin.log:paging',
                            'backstage.admin.info:select',
                        ], type: 'ability');
                    },
                    clientRouting: 'admin-log-manage',
                    type: 'menu'
                );
            }
        );

        collect($this->params)->map(function (array $item) {
            AbilityModel::query()->create($item);
        });
    }

    /**
     * 构建能力参数
     *
     * @param  string        $name
     * @param  string        $parentUuid
     * @param  Closure|null  $children
     * @param  string        $clientRouting
     * @param  array         $serverRouting
     * @param  array         $operation
     * @param  string        $type
     *
     * @return void
     */
    private function ability(
        string $name,
        string $parentUuid,
        Closure $children = null,
        string $clientRouting = '',
        array $serverRouting = [],
        array $operation = [],
        string $type = 'group',
    ): void {
        $currentUuid = Str::uuid()->toString();

        $this->params[] = [
            AbilityTrace::NAME => $name,
            AbilityTrace::CURRENT_UUID => $currentUuid,
            AbilityTrace::PARENT_UUID => $parentUuid,
            AbilityTrace::CLIENT_ROUTING => $clientRouting,
            AbilityTrace::SERVER_ROUTING => $serverRouting,
            AbilityTrace::OPERATION => $operation,
            AbilityTrace::TYPE => $type,
        ];

        if (!is_null($children)) {
            $children($currentUuid);
        }
    }

}
