<?php

namespace App\Seeders;

use Closure;
use Illuminate\Support\Collection;
use Handyfit\Framework\Support\Timestamp;
use App\Cascade\Trace\Eloquent\Admin\AbilityTrace;

/**
 * 能力信息
 *
 * @author KanekiYuto
 */
class Ability
{

    /**
     * 主键 - ID
     *
     * @var int
     */
    private int $id;

    /**
     * 父级 - ID
     *
     * @var int
     */
    private int $parentId;

    /**
     * 名称
     *
     * @var string
     */
    private string $name;

    /**
     * 客户端路由
     *
     * @var string
     */
    private string $clientRouting;

    /**
     * 服务端路由
     *
     * @var array
     */
    private array $serverRouting;

    /**
     * 操作
     *
     * @var array
     */
    private array $operation;

    /**
     * 能力类型
     *
     * @var string
     */
    private string $type;

    /**
     * 子项信息
     *
     * @var static[]
     */
    private array $children;

    /**
     * 构造一个能力实例
     *
     * @param  int     $id
     * @param  int     $parentId
     * @param  string  $name
     * @param  string  $type
     */
    private function __construct(int $id, int $parentId, string $name, string $type)
    {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->name = $name;
        $this->type = $type;
        $this->clientRouting = '';
        $this->serverRouting = [];
        $this->operation = [];
        $this->children = [];
    }

    /**
     * 创建 ability 类型能力
     *
     * @param  string  $name
     * @param  int     $parentId
     *
     * @return static
     */
    public static function ability(string $name, int $parentId): static
    {
        return static::create(static::createId(), $parentId, $name, 'ability');
    }

    /**
     * 静态方法创建
     *
     * @param  int     $id
     * @param  int     $parentId
     * @param  string  $name
     * @param  string  $type
     *
     * @return static
     */
    public static function create(int $id, int $parentId, string $name, string $type): static
    {
        return new static($id, $parentId, $name, $type);
    }

    /**
     * 创建一个 ID
     *
     * @return string
     */
    public static function createId(): string
    {
        // 毫秒级时间戳
        $timestamp = Timestamp::millisecond();

        // 四位随机整数
        $random = mt_rand(1000, 9999);

        return $timestamp . $random;
    }

    /**
     * 创建 group 类型能力
     *
     * @param  string  $name
     * @param  int     $parentId
     *
     * @return static
     */
    public static function group(string $name, int $parentId): static
    {
        return static::create(static::createId(), $parentId, $name, 'group');
    }

    /**
     * 菜单类型能力
     *
     * @param  string  $name
     * @param  int     $parentId
     *
     * @return static
     */
    public static function menu(string $name, int $parentId): static
    {
        return new static(static::createId(), $parentId, $name, 'menu');
    }

    /**
     * 新增能力信息
     *
     * @param  Closure  $callable
     *
     * @return static
     */
    public function appendChildren(Closure $callable): static
    {
        $this->children[] = $callable($this->id);

        return $this;
    }

    public function toArray(): array
    {
        $stack = collect()->push([
            AbilityTrace::ID => $this->getId(),
            AbilityTrace::NAME => $this->getName(),
            AbilityTrace::PARENT_ID => $this->getParentId(),
            AbilityTrace::CLIENT_ROUTING => $this->getClientRouting(),
            AbilityTrace::SERVER_ROUTING => $this->getServerRouting(),
            AbilityTrace::OPERATION => $this->getOperation(),
            AbilityTrace::TYPE => $this->getType(),
        ]);

        return $this->recursion($stack, $this->children)->toArray();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParentId(): int
    {
        return $this->parentId;
    }

    public function getClientRouting(): string
    {
        return $this->clientRouting;
    }

    /**
     * 设置客户端路由
     *
     * @param  string  $value
     *
     * @return static
     */
    public function setClientRouting(string $value): static
    {
        $this->clientRouting = $value;

        return $this;
    }

    public function getServerRouting(): array
    {
        return $this->serverRouting;
    }

    /**
     * 设置服务端路由
     *
     * @param  array  $value
     *
     * @return static
     */
    public function setServerRouting(array $value): static
    {
        $this->serverRouting = $value;

        return $this;
    }

    public function getOperation(): array
    {
        return $this->operation;
    }

    /**
     * 设置操作
     *
     * @param  array  $value
     *
     * @return static
     */
    public function setOperation(array $value): static
    {
        $this->operation = $value;

        return $this;
    }

    /**
     * 能力类型
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * 递归
     *
     * @param  Collection  $stack
     * @param  static[]    $children
     *
     * @return Collection
     */
    private function recursion(Collection $stack, array $children): Collection
    {
        foreach ($children as $child) {
            $stack->push([
                AbilityTrace::ID => $child->getId(),
                AbilityTrace::NAME => $child->getName(),
                AbilityTrace::PARENT_ID => $child->getParentId(),
                AbilityTrace::CLIENT_ROUTING => $child->getClientRouting(),
                AbilityTrace::SERVER_ROUTING => $child->getServerRouting(),
                AbilityTrace::OPERATION => $child->getOperation(),
                AbilityTrace::TYPE => $child->getType(),
            ]);

            if (!empty($child->getChildren())) {
                $this->recursion($stack, $child->getChildren());
            }
        }

        return $stack;
    }

    /**
     * 获取与所有子项
     *
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

}
