<?php


namespace Modules\Shop\Models;


use App\Models\MyModel;

class GoodsCategory extends MyModel
{

    protected $table = 'my_shop_goods_category';

    public function __get($key)
    {
        $meta = GoodsCategoryMeta::where([
            'category_id' => $this->getAttribute('id'),
            'meta_key' => $key
        ])->first();

        return $meta ? $meta->meta_value : parent::__get($key);
    }

    public static function toTree()
    {
        $category = self::orderBy('id', 'asc')->get();

        collect($category)->each(function ($item) use (&$result){
            $result[$item['pid']][] = $item;
        });

        return $result;
    }

    public function parent()
    {
        return $this->hasOne('Modules\Shop\Models\GoodsCategory', 'id', 'pid');
    }

}
