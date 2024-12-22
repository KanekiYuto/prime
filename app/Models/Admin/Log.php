<?php

namespace App\Models\Admin;

use App\Cascade\Models\Admin\InfoModel;
use App\Cascade\Summaries\Admin\InfoSummary;
use App\Cascade\Summaries\Admin\LogSummary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Log extends Model
{

    /**
     * 绑定管理员信息 [一对一关联]
     *
     * @return HasOne
     */
    public function admin(): HasOne
    {
        return $this->hasOne(
            InfoModel::class,
            InfoSummary::ID,
            LogSummary::ADMIN_ID
        );
    }

}
