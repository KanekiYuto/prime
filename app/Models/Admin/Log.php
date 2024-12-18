<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Cascade\Models\Admin\InfoModel;
use App\Cascade\Trace\Eloquent\Admin\LogTrace;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace;
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
			InfoTrace::ID,
			LogTrace::ADMIN_ID
		);
	}

}
