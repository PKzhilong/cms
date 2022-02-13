<?php


namespace Modules\Shop\Models;


use App\Models\MyModel;

class Goods extends MyModel
{

    protected $table = 'my_shop_goods';

    public function __get($key)
    {
        $meta = GoodsMeta::where([
            'goods_id' => $this->getAttribute('id'),
            'meta_key' => $key
        ])->first();

        return $meta ? $meta->meta_value : parent::__get($key);
    }

    public function category()
    {
        return $this->hasOne('Modules\Shop\Models\GoodsCategory', 'id', 'category_id');
    }

}
