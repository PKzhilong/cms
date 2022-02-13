<?php


namespace Modules\Shop\Service;


use App\Service\MyService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Shop\Models\Goods;
use Modules\Shop\Models\GoodsAlbums;
use Modules\Shop\Models\GoodsCategory;
use Modules\Shop\Models\GoodsCategoryMeta;
use Modules\Shop\Models\GoodsMeta;
use Modules\Shop\Models\PayLog;

class StoreService extends MyService
{

    /**
     * 分类树形结构数据
     * @return array|mixed
     */
    public function categoryTree()
    {
        $data = GoodsCategory::toTree();
        return $this->tree($data);
    }

    /**
     * 分类树形结构数据（用于下拉框）
     * @return array
     */
    public function categoryTreeForSelect(): array
    {
        $data = GoodsCategory::toTree();
        return $this->treeForSelect($data);
    }

    /**
     * 子分类ID
     * @return array|int[]
     */
    public function categoryChildIds($pid = 0): array
    {
        $data = GoodsCategory::toTree();
        return $this->childIds($data, $pid, true);
    }

    /**
     * 分类详情
     * @param $id
     * @return mixed
     */
    public function categoryInfo($id)
    {
        return GoodsCategory::find($id);
    }

    /**
     * 商品列表
     * @param $page
     * @param $limit
     * @param $orderBy
     * @param $sort
     * @return LengthAwarePaginator
     */
    public function goodsList($page = 1, $limit = 10, $orderBy = 'id', $sort = 'desc'): LengthAwarePaginator
    {
        return Goods::with('category:id,name')
            ->orderBy($orderBy, $sort)
            ->paginate($limit, '*', 'page', $page);
    }


    /**
     * 搜素商品
     * @param $keyword
     * @param $page
     * @param $limit
     * @param $orderBy
     * @param $sort
     * @return LengthAwarePaginator
     */
    public function search($keyword, $page = 1, $limit = 10, $orderBy = 'id', $sort = 'desc'): LengthAwarePaginator
    {
        return Goods::with('category:id,name')
            ->where('goods_name', 'like', '%' . $keyword . '%')
            ->orderBy($orderBy, $sort)
            ->paginate($limit, '*', 'page', $page);
    }


    /**
     * 商品详情
     * @param $id
     * @return mixed
     */
    public function goods($id)
    {
        $goods = Goods::with('category:id,name')->find($id);
        $goods && $goods->goods_albums = $this->goodsAlbums($id);

        return $goods;
    }

    /**
     * 分类商品列表
     * @param $categoryId
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @param string $sort
     * @return LengthAwarePaginator
     */
    public function goodsForCategory($categoryId, $page = 1, $limit = 10, $orderBy = 'id', $sort = 'desc'): LengthAwarePaginator
    {
        $childIds = $this->categoryChildIds($categoryId);

        return Goods::with('category:id,name')
            ->orderBy($orderBy, $sort)
            ->whereIn('category_id', $childIds)
            ->paginate($limit, '*', 'page', $page);
    }

    /**
     * @param $attr
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @return bool|LengthAwarePaginator
     */
    public function goodsForAttr($attr, $page = 1, $limit = 10, $orderBy = 'id')
    {
        $metas = GoodsMeta::where('meta_key', $attr)
            ->orderBy('goods_id', 'desc')
            ->select(['goods_id'])
            ->get()->toArray();

        if ($metas > 0) {

            $goodsId = array_column($metas, 'goods_id');

            return Goods::with("category:id,name")
                ->orderBy($orderBy, 'desc')
                ->whereIn('id', $goodsId)
                ->paginate($limit, '*', 'page', $page);
        }

        return false;
    }

    /**
     * 根据交易号获取支付记录
     * @param $tradeNo
     * @return mixed
     */
    public function payLogForTradeNo($tradeNo)
    {
        return PayLog::where('trade_no', $tradeNo)->fisrt();
    }

    /**
     * 商品增加浏览数
     * @param $id
     * @return void
     */
    public function goodsAddView($id)
    {
        Goods::where('id', $id)->update([
            'view' => DB::raw('view + 1'),
        ]);
    }

    /**
     * 获取分类拓展
     * @param $id
     * @param array $exclude
     * @return mixed
     */
    public function categoryMeta($id, $exclude = [])
    {
        $meta = GoodsCategoryMeta::where('category_id', $id);

        $meta = $exclude ? $meta->whereNotIn('meta_key', $exclude) : $meta;

        return $meta->get();
    }

    /**
     * 获取商品拓展
     * @param $id
     * @param array $exclude
     * @return mixed
     */
    public function goodsMeta($id, $exclude = [])
    {
        $meta = GoodsMeta::where('goods_id', $id);

        $meta = $exclude ? $meta->whereNotIn('meta_key', $exclude) : $meta;

        return $meta->get();
    }

    /**
     * 商品相册
     * @param $id
     * @param bool $join
     * @return mixed
     */
    public function goodsAlbums($id, bool $join = false)
    {
        $albums = GoodsAlbums::where('goods_id', $id)->orderBy('id', 'asc')->get();

        return $join === false
            ? $albums
            : join("|", array_column($albums->toArray(), "goods_image"));
    }
}
