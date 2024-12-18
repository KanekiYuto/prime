<?php

namespace App\Ability;

use Illuminate\Support\Collection;

/**
 * 注册器
 *
 * @author KanekiYuto
 */
class Ability
{

    /**
     * 唯一标识
     *
     * @var string
     */
    public string $uuid;

    /**
     * 能力(组)名称
     *
     * @var string
     */
    public string $name;

    /**
     * 组回调函数
     *
     * @var array
     */
    public array $group;

    /**
     * 依赖信息
     *
     * @var string|null
     */
    public string|null $rely = null;

    /**
     * 能力(组)描述
     *
     * @var string|null
     */
    public string|null $description;

    /**
     * 能力(组)绑定的接口路由
     *
     * @var array
     */
    public array $apiRoutes;

    /**
     * 能力(组)绑定的前端路由
     *
     * @var array
     */
    public array $frontEndRoutes;

    /**
     * 能力(组)绑定的功能
     *
     * @var array
     */
    public array $functionality;

    /**
     * 信息堆栈
     *
     * @var array
     */
    public static array $stacks = [];

    /**
     * 能力信息
     *
     * @var Collection
     */
    private static Collection $abilities;

    /**
     * 能力组信息
     *
     * @var Collection
     */
    private static Collection $groups;

    /**
     * 注册一个新的能力(组)
     *
     * @param  string  $uuid
     * @param  string|null  $name
     * @param  array  $group
     * @return Ability
     */
    public static function register(
        string $uuid,
        string|null $name = null,
        array $group = []
    ): Ability {
        return new self($uuid, $name, $group);
    }

    /**
     * 使用能力组信息
     *
     * @return void
     * @todo 未完成名称和描述的国际化要求
     *
     */
    public static function use(): void
    {
        self::$stacks = [];

        /* 构建能力信息 */
        self::register('admin', '管理员相关', [

            self::register('info', '信息相关', [

                self::register(
                    'paging', '查询'
                )->setApiRoutes([
                    'backstage.admin.info:paging',
                ])->setFrontEndRoutes([
                    'admin-info-manage',
                ]),

                self::register(
                    'append', '新增'
                )->setApiRoutes([
                    'backstage.admin.info:append',
                ])->setFunctionality('button', [
                    'admin-info-append'
                ]),

                self::register(
                    'modify', '修改'
                )->setApiRoutes([
                    'backstage.admin.info:modify',
                    'backstage.admin.role:select',
                ])->setFunctionality('button', [
                    'admin-info-modify'
                ]),

            ]),

            self::register('role', '角色相关', [

                self::register(
                    'paging', '查询'
                )->setApiRoutes([
                    'backstage.admin.role:paging',
                ])->setFrontEndRoutes([
                    'admin-role-manage',
                ]),

                self::register(
                    'append', '新增'
                )->setApiRoutes([
                    'backstage.admin.role:append',
                ])->setFunctionality('button', [
                    'admin-role-append'
                ]),

                self::register(
                    'modify', '修改'
                )->setApiRoutes([
                    'backstage.admin.role:modify',
                ])->setFunctionality('button', [
                    'admin-role-modify'
                ]),

                self::register(
                    'ability', '能力配置'
                )->setApiRoutes([
                    'backstage.ability:abilities',
                    'backstage.ability:groups',
                    'backstage.admin.role:ability',
                ]),

            ]),

            self::register('log', '日志相关', [

                self::register(
                    'paging', '查询'
                )->setApiRoutes([
                    'backstage.admin.log:paging',
                    'backstage.admin.info:select',
                ])->setFrontEndRoutes([
                    'admin-log-manage'
                ]),

            ]),

        ])->push();

        // 导出能力信息
        self::$abilities = (new AbilityParser())->abilities(self::$stacks);

        // 导出组信息
        self::$groups = (new AbilityParser())->groups(self::$stacks);
    }

    /**
     * 获取所有能力信息(受限)
     *
     * @param  string  $rely
     * @return array
     */
    public static function abilities(string $rely): array
    {
        $abilities = collect();

        self::$abilities->each(function (Collection $item) use (
            $abilities,
            $rely
        ) {
            if ($item->get('rely') !== $rely) {
                return;
            }

            $abilities->push([
                'uuid' => $item->get('uuid'),
                'name' => $item->get('name'),
                'description' => $item->get('description')
            ]);
        });

        return $abilities->all();
    }

    /**
     * 获取所有能力组
     *
     * @param  string  $rely
     * @return array
     */
    public static function groups(string $rely): array
    {
        $abilities = collect();

        self::$groups->each(function (Collection $item) use (
            $abilities,
            $rely
        ) {
            $groupRely = $item->get('rely');

            if (empty($groupRely) && empty($rely)) {
                $abilities->push([
                    'uuid' => $item->get('uuid'),
                    'name' => $item->get('name'),
                    'description' => $item->get('description')
                ]);
                return;
            }

            if ($item->get('rely') !== $rely) {
                return;
            }

            $abilities->push([
                'uuid' => $item->get('uuid'),
                'name' => $item->get('name'),
                'description' => $item->get('description')
            ]);
        });

        return $abilities->all();
    }

    /**
     * 获取所有的许可(关于此能力的)
     *
     * @param  array  $abilities
     * @return array
     */
    public static function permission(array $abilities = []): array
    {
        $permission = collect();

        $abilities = self::$abilities->whereIn('uuid', $abilities);
        $abilities->each(function (Collection $item) use ($permission) {
            $frontEndRoutes = $item->get('frontEndRoutes');
            $functionality = $item->get('functionality');

            foreach ($frontEndRoutes as $route) {
                $permission->push("@route:$route");
            }

            foreach ($functionality as $value) {
                $permission->push("@$value[0]:$value[1]");
            }
        });

        return $permission->all();
    }

    /**
     * 验证接口路由是否可以被允许
     *
     * @param  string  $name
     * @param  array  $abilities
     * @return bool
     */
    public static function apiRoute(string $name, array $abilities = []): bool
    {
        $abilities = self::$abilities->whereIn('uuid', $abilities);
        $abilities = $abilities->filter(function (Collection $value) use ($name) {
            return in_array($name, $value->get('apiRoutes'));
        });

        $abilities = $abilities->count();

        return $abilities === 1;
    }

    /**
     * 获取所有唯一标识
     *
     * @return array
     */
    public static function uuid(): array
    {
        $abilities = collect();

        self::$abilities->each(function (Collection $item) use ($abilities) {
            $abilities->push($item->get('uuid'));
        });

        return $abilities->all();
    }

    /**
     * 构造基础信息
     *
     * @param  string  $uuid
     * @param  string|null  $name
     * @param  array  $group
     * @param  string|null  $description
     * @param  array  $apiRoutes
     * @param  array  $frontEndRoutes
     * @param  array  $functionality
     */
    public function __construct(
        string $uuid,
        string|null $name,
        array $group,
        string|null $description = null,
        array $apiRoutes = [],
        array $frontEndRoutes = [],
        array $functionality = []
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->group = $group;
        $this->description = $description;
        $this->apiRoutes = $apiRoutes;
        $this->frontEndRoutes = $frontEndRoutes;
        $this->functionality = $functionality;
    }

    /**
     * 设置接口路由信息
     *
     * @param  array  $routes
     * @return self
     */
    public function setApiRoutes(array $routes): self
    {
        $this->apiRoutes = $routes;

        return $this;
    }

    /**
     * 设置前端路由信息
     *
     * @param  array  $routes
     * @return self
     */
    public function setFrontEndRoutes(array $routes): self
    {
        $this->frontEndRoutes = $routes;

        return $this;
    }

    /**
     * 设置功能信息
     *
     * @param  string  $type
     * @param  array  $functionality
     * @return self
     */
    public function setFunctionality(string $type, array $functionality): self
    {
        $list = [];

        foreach ($functionality as $value) {
            $list[] = [$type, $value];
        }

        $this->functionality = $list;

        return $this;
    }

    /**
     * 入栈
     *
     * @return void
     */
    public function push(): void
    {
        self::$stacks[] = $this;
    }

}
