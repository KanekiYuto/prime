<?php

namespace App\Models\Admin;

use Laravel\Passport\HasApiTokens;
use App\Cascade\Models\AdminRoleModel;
use Illuminate\Notifications\Notifiable;
use App\Cascade\Summaries\AdminInfoSummary;
use App\Cascade\Summaries\AdminRoleSummary;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Info extends Model
{

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * 绑定管理员权限表 [一对一关联]
     *
     * @return HasOne
     */
    public function role(): HasOne
    {
        return $this->hasOne(
            AdminRoleModel::class,
            AdminRoleSummary::ID,
            AdminInfoSummary::ADMIN_ROLE_ID
        );
    }

}
