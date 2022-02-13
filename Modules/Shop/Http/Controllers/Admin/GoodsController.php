<?php


namespace Modules\Shop\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Modules\Shop\Http\Requests\GoodsRequest;
use Modules\Shop\Models\Goods;
use Modules\Shop\Models\GoodsAlbums;
use Modules\Shop\Models\GoodsMeta;

class GoodsController extends MyController
{

    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {

            $where = [];
            if ($json = $request->input('filter')) {
                $filters = json_decode($json, true);
                foreach ($filters as $name => $filter) {
                    $where[] = [$name, $name == 'goods_name' ? 'like' : '=', $name == 'goods_name' ? "%{$filter}%" : $filter];
                }
            }

            $goods = Goods::with('category:id,name')->orderBy('id', 'desc')
                ->where($where)
                ->paginate($this->request('limit', 'intval'))->toArray();

            return $this->jsonSuc($goods);
        }
        return $this->view('admin.goods.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = app('store')->categoryTreeForSelect();
        $attributes = app('system')->attributes();

        return $this->view('admin.goods.create', compact('categories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GoodsRequest $request, Goods $goods)
    {
        $data = $request->validated();
        $result = $goods->store($data);

        if ($result) {

            $this->updateMeta($goods->id);
            $this->updateAlbums($goods->id);
        }

        return $this->result($result);
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $id = $this->request('id', 'intval');
        $categories = app('store')->categoryTreeForSelect();

        $goods = Goods::find($id);
        $goods && $goods->goods_albums = app('store')->goodsAlbums($id, true);

        $attributes = app('system')->attributes();

        $meta = app('store')->goodsMeta($id,
            array_merge(
                ['short_title'],
                array_column($attributes, 'ident')
            )
        );

        return $this->view('admin.goods.edit', compact('categories', 'goods', 'attributes', 'meta'));
    }

    /**
     * 更新
     */
    public function update(GoodsRequest $request, Goods $goods)
    {

        if ($id = $this->request('id', 'intval')) {

            $data = $request->validated();
            $data['id'] = $id;
            $result = $goods->up($data);

            if ($result) {

                $this->updateMeta($id);
                $this->updateAlbums($id);
            }

            return $this->result($result);
        }

        return $this->result(false);
    }

    /**
     * 删除
     */
    public function destroy()
    {
        $result = Goods::destroy($this->request('id', 'intval'));
        return $this->result($result);
    }


    /**
     * 更新拓展信息
     * @param $id
     */
    protected function updateMeta($id)
    {
        $attr = $this->request('attr');
        GoodsMeta::where('goods_id', $id)->delete();

        foreach ($attr['ident'] as $key => $ident) {

            if ($ident && isset($attr['value'][$key])) {

                $meta = [
                    'goods_id' => $id,
                    'meta_key' => $ident,
                    'meta_value' => $attr['value'][$key],
                ];

                GoodsMeta::insert($meta);
            }

        }
    }


    /**
     * 更新商品相册
     * @param $id
     */
    protected function updateAlbums($id)
    {
        $albums = $this->request('goods_albums');
        GoodsAlbums::where('goods_id', $id)->delete();

        if ($albums) {

            $data = [];
            $albums = explode("|", $albums);

            foreach ($albums as $album) {

                $data[] = [
                    'goods_id' => $id,
                    'goods_image' => $album,
                ];
            }

            GoodsAlbums::insertAll($data);
        }

    }

}
