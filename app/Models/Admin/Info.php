<?php

namespace App\Models\Admin;

use App\Cascade\Models\Admin\RoleModel;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

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
            RoleModel::class,
            RoleTrace::ID,
            InfoTrace::ADMIN_ROLE_ID
        );
    }

}
