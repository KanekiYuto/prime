<?php

namespace App\Http\Service\DevOps\Admin;

use Illuminate\Support\Facades\Hash;
use Kaneki\Diverse\Equation\Equation;
use Kaneki\Diverse\Equation\Formulas;
use Kaneki\Diverse\PagingQuery\PagingQuery;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;
use App\Cascade\Models\Admin\InfoModel as AdminInfo;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace as TheTrace;

/**
 * 管理员信息服务类
 *
 * @author KanekiYuto
 */
class InfoService
{

	/**
	 * 分页查询管理员信息
	 *
	 * @param  int     $page
	 * @param  int     $prePage
	 * @param  string  $oderBy
	 * @param  string  $order
	 * @param  array   $query
	 *
	 * @return PreacherResponse
	 */
	public static function paging(
		int $page,
		int $prePage,
		string $oderBy,
		string $order,
		array $query
	): PreacherResponse {
		$model = AdminInfo::query();

		$model = Equation::build(model: $model)->where(
			(new Formulas($query))->formula(column: 'id')
		);

		$columns = $model->getColumns();
		$model = $model->export();
		$model = $model->with('role');

		return PagingQuery::response(
			model: $model,
			page: $page,
			prePage: $prePage,
			oderBy: $oderBy,
			order: $order,
			columns: $columns
		);
	}

	/**
	 * 获取管理员信息选项
	 *
	 * @return PreacherResponse
	 */
	public static function select(): PreacherResponse
	{
		$model = AdminInfo::query();

		$model = Equation::build(
			model: $model,
			columns: [TheTrace::ID, TheTrace::ACCOUNT],
			aliases: [TheTrace::ID => 'value', TheTrace::ACCOUNT => 'label']
		);

		$model = $model->export()->get($model->getColumns());

		return Preacher::rows($model->toArray());
	}

	/**
	 * 新增管理员信息
	 *
	 * @param  string  $account
	 * @param  string  $email
	 * @param  string  $pass
	 * @param  string  $role_id
	 *
	 * @return PreacherResponse
	 */
	public static function append(
		string $account,
		string $email,
		string $pass,
		string $role_id
	): PreacherResponse {
		$sole = self::sole($account, $email);
		if (!$sole->isSucceed()) {
			return $sole;
		}

		$model = AdminInfo::query();

		$model = $model->create([
			TheTrace::ACCOUNT => $account,
			TheTrace::EMAIL => $email,
			TheTrace::PASS => Hash::make($pass),
			TheTrace::ADMIN_ROLE_ID => $role_id,
		]);

		return Preacher::allow(
			$model->save(),
			Preacher::msg('新增成功'),
			Preacher::msgCode(
				PreacherResponse::RESP_CODE_FAIL,
				'新增失败'
			),
		);
	}

	/**
	 * 唯一性验证
	 *
	 * @param  string    $account
	 * @param  string    $email
	 * @param  int|null  $id
	 *
	 * @return PreacherResponse
	 */
	public static function sole(
		string $account,
		string $email,
		int|null $id = null
	): PreacherResponse {
		$model = AdminInfo::query();
		$model = $model->where(TheTrace::ACCOUNT, $account);

		if (!empty($id)) {
			$model = $model->where(TheTrace::ID, '<>', $id);
		}

		if ($model->exists()) {
			return Preacher::msgCode(
				PreacherResponse::RESP_CODE_WARN,
				'账号已存在'
			);
		}

		$model = AdminInfo::query();
		$model = $model->where(TheTrace::EMAIL, $email);

		if (!empty($id)) {
			$model = $model->where(TheTrace::ID, '<>', $id);
		}

		if ($model->exists()) {
			return Preacher::msgCode(
				PreacherResponse::RESP_CODE_WARN,
				'郵箱已存在'
			);
		}

		return Preacher::base();
	}

	/**
	 * 修改管理员信息
	 *
	 * @param  int     $id
	 * @param  string  $account
	 * @param  string  $email
	 * @param  int     $role_id
	 *
	 * @return PreacherResponse
	 */
	public static function modify(
		int $id,
		string $account,
		string $email,
		int $role_id
	): PreacherResponse {
		$sole = self::sole($account, $email, $id);
		if (!$sole->isSucceed()) {
			return $sole;
		}

		$model = AdminInfo::query()->find($id);

		$column = TheTrace::ACCOUNT;
		$model->$column = $account;
		$column = TheTrace::EMAIL;
		$model->$column = $email;
		$column = TheTrace::ADMIN_ROLE_ID;
		$model->$column = $role_id;

		return Preacher::allow(
			$model->save(),
			Preacher::msg('修改成功'),
			Preacher::msgCode(
				PreacherResponse::RESP_CODE_FAIL,
				'修改失败'
			),
		);
	}

}
