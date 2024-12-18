<?php

namespace App\Ability;

use Illuminate\Support\Collection;

/**
 * 能力解析器
 *
 * @author KanekiYuto
 */
class AbilityParser
{

    /**
     * 能力递归构建
     *
     * @param  array  $stacks
     * @param  array  $uuid
     * @param  Collection  $arrays
     * @return Collection
     */
    public function abilities(
        array $stacks = [],
        array $uuid = [],
        Collection $arrays = new Collection([]),
    ): Collection {
        foreach ($stacks as $stack) {
            if (!($stack instanceof Ability)) {
                continue;
            }

            if (!empty($stack->group)) {
                $this->abilities(
                    $stack->group,
                    array_merge($uuid, [$stack->uuid]),
                    $arrays
                );
                continue;
            }

            $arrays->push(collect([
                'uuid' => implode('.', $uuid).':'.$stack->uuid,
                'name' => $stack->name,
                'description' => $stack->description,
                'rely' => implode('.', $uuid),
                'apiRoutes' => $stack->apiRoutes,
                'frontEndRoutes' => $stack->frontEndRoutes,
                'functionality' => $stack->functionality,
            ]));
        }

        return $arrays;
    }

    /**
     * 能力组递归构建
     *
     * @param  array  $stacks
     * @param  array  $uuid
     * @param  Collection  $arrays
     * @return Collection
     */
    public function groups(
        array $stacks = [],
        array $uuid = [],
        Collection $arrays = new Collection([]),
    ): Collection {
        foreach ($stacks as $stack) {
            if (!($stack instanceof Ability)) {
                continue;
            }

            if (empty($stack->group)) {
                continue;
            }

            $this->groups(
                $stack->group,
                array_merge($uuid, [$stack->uuid]),
                $arrays
            );

            $arrays->push(collect([
                'uuid' => implode(
                    '.',
                    array_merge($uuid, [$stack->uuid])
                ),
                'name' => $stack->name,
                'description' => $stack->description,
                'rely' => implode('.', $uuid),
            ]));
        }

        return $arrays;
    }

}
