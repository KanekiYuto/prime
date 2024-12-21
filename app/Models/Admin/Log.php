<?php

namespace App\Models\Admin;

use App\Cascade\Models\Admin\InfoModel;
use Illuminate\Database\Eloquent\Model;
use App\Cascade\Summaries\Admin\LogSummary;
use App\Cascade\Summaries\Admin\InfoSummary;
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
