<?php

namespace App\Http\Service\Backstage\Admin;

use Kaneki\Diverse\Equation\Equation;
use Kaneki\Diverse\Equation\Formulas;
use Kaneki\Diverse\PagingQuery\PagingQuery;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;
use App\Cascade\Models\Admin\RoleModel as AdminRole;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as TheTrace;

/**
 * 管理员角色服务类
 *
 * @author KanekiYuto
 */
class RoleService
{

	/**
	 * 分页查询管理员角色信息
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
		$model = AdminRole::query();

		$model = Equation::build(model: $model)->where(
			(new Formulas($query))->formula(column: 'id')
		);

		return PagingQuery::response(
			model: $model->export(),
			page: $page,
			prePage: $prePage,
			oderBy: $oderBy,
			order: $order,
			columns: $model->getColumns()
		);
	}

	/**
	 * 管理员角色选项
	 *
	 * @return PreacherResponse
	 */
	public static function select(): PreacherResponse
	{
		$model = AdminRole::query();

		$model = Equation::build(
			model: $model,
			columns: [TheTrace::ID, TheTrace::NAME],
			aliases: [TheTrace::ID => 'value', TheTrace::NAME => 'label']
		);

		$model = $model->export()->get($model->getColumns());

		return Preacher::rows($model->toArray());
	}

	/**
	 * 新增管理员角色信息
	 *
     * @todo 需要更改
     *
	 * @param  string  $name
	 * @param  string  $explain
	 *
	 * @return PreacherResponse
	 */
	public static function append(string $name, string $explain): PreacherResponse
	{
		$model = AdminRole::query();

		$model = $model->create([
			TheTrace::NAME => $name,
			TheTrace::EXPLAIN => $explain,
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
	 * 修改管理员角色信息
	 *
	 * @param  int     $id
	 * @param  string  $name
	 * @param  string  $explain
	 *
	 * @return PreacherResponse
	 */
	public static function modify(
		int $id,
		string $name,
		string $explain
	): PreacherResponse {
		$model = AdminRole::query()->find($id);

		$column = TheTrace::NAME;
		$model->$column = $name;
		$column = TheTrace::EXPLAIN;
		$model->$column = $explain;

		return Preacher::allow(
			$model->save(),
			Preacher::msg('修改成功'),
			Preacher::msgCode(
				PreacherResponse::RESP_CODE_FAIL,
				'修改失败'
			),
		);
	}

	/**
	 * 设置角色能力
	 *
	 * @param  int    $id
	 * @param  array  $abilities
     * @todo 需要更改
	 *
	 * @return PreacherResponse
	 */
	public static function ability(int $id, array $abilities): PreacherResponse
	{
		return Preacher::allow(
			true,
			Preacher::msg('修改成功'),
			Preacher::msgCode(
				PreacherResponse::RESP_CODE_FAIL,
				'修改失败'
			),
		);
	}

}
