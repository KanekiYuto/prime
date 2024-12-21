<?php

namespace App\Experimental\Crush\Params;

/**
 * 分页参数
 *
 * @author KanekiYuto
 */
class Paging
{

    /**
     * 页码
     *
     * @var int
     */
    protected int $page;

    /**
     * 每页数量
     *
     * @var int
     */
    protected int $prePage;

    /**
     * 排序顺序
     *
     * @var string
     */
    protected string $oderBy;

    /**
     * 排序字段
     *
     * @var string
     */
    protected string $order;

    /**
     * 查询参数
     *
     * @var array
     */
    protected array $query;

    /**
     * 构造一个分页参数实例
     *
     * @param  int     $page
     * @param  int     $prePage
     * @param  string  $oderBy
     * @param  string  $order
     * @param  array   $query
     *
     * @return void
     */
    public function __construct(int $page, int $prePage, string $oderBy, string $order, array $query)
    {
        $this->page = $page;
        $this->prePage = $prePage;
        $this->oderBy = $oderBy;
        $this->order = $order;
        $this->query = $query;
    }

    /**
     * @return string
     */
    public function getOderBy(): string
    {
        return $this->oderBy;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPrePage(): int
    {
        return $this->prePage;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

}
