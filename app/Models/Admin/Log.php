<?php

namespace App\Models\Admin;

use App\Cascade\Models\AdminInfoModel;
use Illuminate\Database\Eloquent\Model;
use App\Cascade\Summaries\AdminLogSummary;
use App\Cascade\Summaries\AdminInfoSummary;
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
            AdminInfoModel::class,
            AdminInfoSummary::ID,
            AdminLogSummary::ADMIN_ID
        );
    }

}
