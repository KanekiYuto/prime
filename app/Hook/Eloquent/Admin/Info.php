<?php

namespace App\Hook\Eloquent\Admin;

use App\Cascade\Trace\Eloquent\Admin\InfoTrace;
use Handyfit\Framework\Foundation\Hook\Eloquent as EloquentHook;
use Handyfit\Framework\Trace\EloquentTrace;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 管理员信息
 *
 * @author KanekiYuto
 */
class Info extends EloquentHook
{

    /**
     * 模型插入前的操作
     *
     * @param Model                   $model
     * @param Builder                 $query
     * @param InfoTrace|EloquentTrace $eloquentTrace
     *
     * @return bool
     */
    public function performInsert(Model $model, Builder $query, InfoTrace|EloquentTrace $eloquentTrace): bool
    {
        if (!parent::performInsert($model, $query, $eloquentTrace)) {
            return false;
        }

        $isExist = $model->newQuery()
            ->where($eloquentTrace::ACCOUNT, $model->getAttribute($eloquentTrace::ACCOUNT))
            ->orWhere($eloquentTrace::EMAIL, $model->getAttribute($eloquentTrace::EMAIL))
            ->exists();

        if ($isExist) {
            return false;
        }

        return true;
    }

    /**
     * 模型更新前的操作
     *
     * @param Model         $model
     * @param Builder       $query
     * @param EloquentTrace $eloquentTrace
     *
     * @return bool
     */
    public function performUpdate(Model $model, Builder $query, EloquentTrace $eloquentTrace): bool
    {
        if (!parent::performUpdate($model, $query, $eloquentTrace)) {
            return false;
        }

        return true;
    }

}
