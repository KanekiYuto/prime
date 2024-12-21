<?php

namespace App\Experimental\Crush;

use App\Experimental\Crush\Params\Paging;
use Closure;
use Handyfit\Framework\Preacher\PreacherResponse;
use Handyfit\Framework\Support\Facades\Preacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Crush
{

    /**
     * 分页查询参数标记
     *
     * @var string
     */
    public const PAGING_PARAMS_MARK = 'query_';

    /**
     * 处理请求部分
     *
     * @param Request $request
     * @param string  $class
     * @param string  $method
     * @param array   $orderBy
     * @param array   $queryRule
     *
     * @return PreacherResponse
     */
    public static function request(
        Request $request,
        string $class,
        string $method = 'paging',
        array $orderBy = [],
        array $queryRule = []
    ): PreacherResponse {
        // 验证请求参数
        $requestParams = $request::validate(array_merge([
            'page' => ['required', 'integer'],
            'prePage' => ['required', 'integer'],
            'orderBy' => ['required', Rule::in($orderBy)],
            'order' => ['required', Rule::in(['asc', 'desc'])],
        ], self::pagingParamsEncode($queryRule)));

        $pagingParams = new Params\Paging(
            $requestParams['page'],
            $requestParams['prePage'],
            $requestParams['orderBy'],
            $requestParams['order'],
            self::pagingParamsDecode($requestParams)
        );

        // 回调对应的服务类方法
        $callback = call_user_func(
            [$class, $method],
            $pagingParams
        );

        if ($callback === false) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_FAIL,
                '回调函数不存在'
            );
        }

        if (!($callback instanceof PreacherResponse)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_FAIL,
                '返回值错误'
            );
        }

        return $callback;
    }

    /**
     * 处理响应部分
     *
     * @param Builder<static> $builder
     * @param Paging          $pagingParams
     * @param array           $columns
     * @param Closure|null    $callable
     *
     * @return PreacherResponse
     */
    public static function response(
        Builder $builder,
        Params\Paging $pagingParams,
        array $columns = ['*'],
        Closure $callable = null
    ): PreacherResponse {
        $builder = $builder->orderBy(
            $pagingParams->getOderBy(),
            $pagingParams->getOrder()
        )->paginate(
            perPage: $pagingParams->getPrePage(),
            columns: $columns,
            page: $pagingParams->getPage(),
        );

        $items = $builder->items();

        if (is_callable($callable)) {
            $items = $callable($items);
        }

        return Preacher::paging(
            $builder->currentPage(),
            $builder->perPage(),
            $builder->total(),
            $items
        );
    }

    /**
     * 为分页查询参数编码（加上数组键前缀）
     *
     * @param array $params
     *
     * @return array
     */
    private static function pagingParamsEncode(array $params): array
    {
        $stack = collect();

        collect($params)->map(function (array $item, string $key) use ($stack) {
            $stack->put(static::PAGING_PARAMS_MARK . $key, $item);
        });

        return $stack->all();
    }

    /**
     * 为分页查询参数解码（解除数组键前缀）
     *
     * @param array $params
     *
     * @return array
     */
    private static function pagingParamsDecode(array $params): array
    {
        $stack = collect();

        collect($params)->map(function (mixed $item, string $key) use ($stack) {
            // 过滤无关参数
            if (!Str::startsWith($key, static::PAGING_PARAMS_MARK)) {
                return;
            }

            $stack->put(Str::of($key)->chopStart(static::PAGING_PARAMS_MARK), $item);
        });

        return $stack->all();
    }

}
