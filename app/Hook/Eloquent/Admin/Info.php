<?php

namespace App\Hook\Eloquent\Admin;

use Handyfit\Framework\Summary\Summary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Cascade\Summaries\Admin\InfoSummary as TheSummary;
use Handyfit\Framework\Foundation\Hook\Eloquent as EloquentHook;

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
     * @param  Model               $model
     * @param  Builder             $query
     * @param  TheSummary|Summary  $summary
     *
     * @return bool
     */
    public function performInsert(Model $model, Builder $query, TheSummary|Summary $summary): bool
    {
        if (!parent::performInsert($model, $query, $summary)) {
            return false;
        }

        $isExist = $model->newQuery()
            ->where($summary::ACCOUNT, $model->getAttribute($summary::ACCOUNT))
            ->orWhere($summary::EMAIL, $model->getAttribute($summary::EMAIL))
            ->exists();

        if ($isExist) {
            return false;
        }

        return true;
    }

    /**
     * 模型更新前的操作
     *
     * @param  Model    $model
     * @param  Builder  $query
     * @param  Summary  $summary
     *
     * @return bool
     */
    public function performUpdate(Model $model, Builder $query, Summary $summary): bool
    {
        if (!parent::performUpdate($model, $query, $summary)) {
            return false;
        }

        return true;
    }

}
