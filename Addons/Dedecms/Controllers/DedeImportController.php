<?php


namespace Addons\Dedecms\Controllers;


use Addons\Dedecms\Models\Dedecms;
use App\Http\Controllers\MyController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Models\Article;
use Modules\Cms\Models\ArticleCategory;
use Modules\Cms\Models\ArticleMeta;
use Modules\Cms\Models\ArticleTag;
use Modules\Cms\Models\ArticleTagRel;
use Modules\Shop\Models\Goods;
use Modules\Shop\Models\GoodsCategory;
use Modules\Shop\Models\GoodsMeta;

class DedeImportController extends MyController
{

    private $lowerName = 'dedecms';

    private $config;

    private $connection;

    public function __construct()
    {
        $this->config = system_config([], $this->lowerName);

        if (!isset($this->config['database']) || empty($this->config['database'])) {

            return $this->result(false, ['msg' => '请填写好数据库配置后操作']);
        }

        $dedeConnection = array_merge([
            'driver' => 'mysql',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => $this->config['dede_prefix'],
        ], $this->config);

        config(['database.connections.dedecms' => $dedeConnection]);

        $this->connection = DB::connection('dedecms');
    }

    /**
     * 导入文章
     */
    public function article(): JsonResponse
    {
        $date = date('Y-m-d H:i:s');
        $lastId = Storage::exists("dede_article_last_id") ? Storage::get("dede_article_last_id") : 0;

        $articles = $this->connection
            ->table('archives')
            ->leftJoin('addonarticle', 'aid', '=', 'id')
            ->where([
                ['channel', '=', 1],
                ['id', '>', $lastId],
            ])->limit($this->config['batch_number'])->get();

        $importLog = [];
        $catArray = $this->articleCategory();

        foreach ($articles as $article) {

            $aid = Article::insert([
                'category_id' => $catArray[$article->typeid],
                'title' => $article->title,
                'content' => $article->body,
                'description' => $article->description,
                'img' => $article->litpic,
                'author' => $article->writer,
                'view' => $article->click,
                'created_at' => date('Y-m-d H:i:s', $article->senddate),
                'updated_at' => date('Y-m-d H:i:s', $article->pubdate),
            ]);

            if ($article->shorttitle) {

                $meta = [
                    'article_id' => $aid,
                    'meta_key' => 'short_title',
                    'meta_value' => $article->shorttitle,
                ];

                ArticleMeta::insert($meta);
            }

            $lastId = $article->id;

            $tagIds = (new ArticleTag)->insertTags(explode(",", trim($article->keywords, ",")));
            (new ArticleTagRel)->insertRel($aid, $tagIds);

            $importLog[] = [
                'type' => '文章',
                'oid' => $article->id,
                'mid' => $aid,
                'title' => $article->title,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }

        Dedecms::insertAll($importLog);

        Storage::put("dede_article_last_id", $lastId);

        return $this->result(true);
    }


    /**
     * 导入商品
     */
    public function goods()
    {
        $date = date('Y-m-d H:i:s');

        $lastId = Storage::exists("dede_goods_last_id") ? Storage::get("dede_goods_last_id") : 0;

        $articles = $this->connection
            ->table('archives')
            ->leftJoin('addonshop', 'aid', '=', 'id')
            ->where([
                ['channel', '=', 6],
                ['id', '>', $lastId],
            ])->limit($this->config['batch_number'])->get();

        $importLog = [];
        $catArray = $this->goodsCategory();

        foreach ($articles as $article) {

            $aid = Goods::insert([
                'category_id' => $catArray[$article->typeid],
                'goods_name' => $article->title,
                'content' => $article->body,
                'description' => $article->description,
                'goods_image' => $article->litpic,
                'view' => $article->click,
                'shop_price' => $article->trueprice ?: $article->price,
                'market_price' => $article->price,
                'created_at' => date('Y-m-d H:i:s', $article->senddate),
                'updated_at' => date('Y-m-d H:i:s', $article->pubdate),
            ]);

            if ($article->shorttitle) {

                $meta = [
                    'goods_id' => $aid,
                    'meta_key' => 'short_title',
                    'meta_value' => $article->shorttitle,
                ];

                GoodsMeta::insert($meta);
            }

            $lastId = $article->id;

            $importLog[] = [
                'type' => '商品',
                'oid' => $article->id,
                'mid' => $aid,
                'title' => $article->title,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }

        Dedecms::insertAll($importLog);

        Storage::put("dede_goods_last_id", $lastId);

        return $this->result(true);
    }


    /**
     * @return array|mixed
     */
    public function articleCategory()
    {
        if (!Storage::exists("dede_article_category")) {

            //导入分类
            $categories = $this->connection
                ->table('arctype')->get();

            $catArray = $catParentArray = [];

            foreach ($categories as $category) {

                $cid = ArticleCategory::insert([
                    'pid' => 0,
                    'name' => $category->typename,
                ]);

                $catArray[$category->id] = $cid;
                $catParentArray[$cid] = $category->topid;
            }

            foreach ($catParentArray as $key => $value) {

                if ($value > 0) {

                    $ac = ArticleCategory::find($key);
                    $ac->pid = $catArray[$value];
                    $ac->save();
                }
            }

            Storage::put("dede_article_category", json_encode($catArray));

        } else {

            $catArray = json_decode(Storage::get("dede_article_category"), true);
        }

        return $catArray;
    }

    /**
     * @return array|mixed
     */
    public function goodsCategory()
    {
        if (!Storage::exists("dede_goods_category")) {

            //导入分类
            $categories = $this->connection
                ->table('arctype')->get();

            $catArray = $catParentArray = [];

            foreach ($categories as $category) {

                $cid = GoodsCategory::insert([
                    'pid' => 0,
                    'name' => $category->typename,
                ]);

                $catArray[$category->id] = $cid;
                $catParentArray[$cid] = $category->topid;
            }

            foreach ($catParentArray as $key => $value) {

                if ($value > 0) {

                    $gc = GoodsCategory::find($key);
                    $gc->pid = $catArray[$value];
                    $gc->save();
                }
            }

            Storage::put("dede_goods_category", json_encode($catArray));

        } else {

            $catArray = json_decode(Storage::get("dede_goods_category"), true);
        }

        return $catArray;
    }
}
