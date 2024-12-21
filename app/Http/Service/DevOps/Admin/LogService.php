<?php

namespace App\Http\Service\DevOps\Admin;

use Kaneki\Diverse\Equation\Equation;
use Kaneki\Diverse\Equation\Formulas;
use Kaneki\Diverse\PagingQuery\PagingQuery;
use Handyfit\Framework\Preacher\PreacherResponse;
use App\Cascade\Models\Admin\LogModel as AdminLog;

/**
 * 管理员日志服务类
 *
 * @author KanekiYuto
 */
class LogService
{

	/**
	 * 分页查询管理员日志信息
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
		$model = AdminLog::query();

		$like = function (mixed $value) {
			return "%$value%";
		};

		$whereDateBetween = function (string $value) {
			return [strtotime("$value 00:00:00"), strtotime("$value 23:59:59")];
		};

		$model = Equation::build(model: $model)->where(
			(new Formulas($query))
				->formula('id')
				->formula('admin_id')
		);

		$model = $model->where(
			(new Formulas($query))
				->formula(column: 'api', value: $like)
				->formula(column: 'ipaddress', value: $like),
			'like'
		);

		$model = $model->whereBetween(
			(new Formulas($query))
				->formula(column: 'updated_at', value: $whereDateBetween)
				->formula(column: 'created_at', value: $whereDateBetween)
		);

		$columns = $model->getColumns();
		$model = $model->export();

		$model = $model->with('admin');

		return PagingQuery::response(
			model: $model,
			page: $page,
			prePage: $prePage,
			oderBy: $oderBy,
			order: $order,
			columns: $columns
		);
	}

}
