<?php


namespace Modules\Cms\Service;


use App\Service\MyService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Cms\Models\Article;
use Modules\Cms\Models\ArticleCategory;
use Modules\Cms\Models\ArticleCategoryMeta;
use Modules\Cms\Models\ArticleComment;
use Modules\Cms\Models\ArticleMeta;
use Modules\Cms\Models\ArticleTag;
use Modules\Cms\Models\ArticleTagRel;

class CmsService extends MyService
{
    /**
     * 根据排序获取文章
     */
    public function articlesForSort($page = 1, $limit = 10, $orderBy = 'id', $sort = 'desc')
    {
        return Article::with('category:id,name')
            ->orderBy($orderBy, $sort)
            ->paginate($limit, '*', 'page', $page);
    }

    /**
     * 分类树形结构数据
     * @return array
     */
    public function categoryTree(): array
    {
        $data = ArticleCategory::toTree();
        return $this->tree($data);
    }

    /**
     * 分类详情
     * @param $id
     * @return mixed
     */
    public function categoryInfo($id)
    {
        return ArticleCategory::find($id);
    }

    /**
     * 分类树形结构数据（用于下拉框）
     * @return array
     */
    public function categoryTreeForSelect(): array
    {
        $data = ArticleCategory::toTree();
        return $this->treeForSelect($data);
    }

    /**
     * 子分类ID
     * @return array|int[]
     */
    public function categoryChildIds($pid = 0): array
    {
        $data = ArticleCategory::toTree();
        return $this->childIds($data, $pid, true);
    }

    /**
     * 根据ID获取文章详情
     * @param $id
     * @param false $meta
     * @return mixed
     */
    public function article($id, $meta = false)
    {
        $article = Article::with("category:id,name")->find($id);

        if ($article && $meta) {

            $article->meta = ArticleMeta::where('article_id', $id)->get();
        }

        return pipeline_func($article, "article");
    }

    /**
     * 获取分类文章
     * @param $categoryId
     * @param $page
     * @param $limit
     * @param $orderBy
     * @return LengthAwarePaginator
     */
    public function articleForCategory($categoryId, $page = 1, $limit = 10, $orderBy = 'id'): LengthAwarePaginator
    {
        $childIds = $this->categoryChildIds($categoryId);

        return Article::with('category:id,name')
            ->orderBy($orderBy, 'desc')
            ->whereIn('category_id', $childIds)
            ->paginate($limit, '*', 'page', $page);
    }


    /**
     * 根据标签获取文章
     * @param $tagId
     * @param $page
     * @param $limit
     * @return false|LengthAwarePaginator
     */
    public function articleForTag($tagId, $page = 1, $limit = 10)
    {
        $articleIds = $this->articleIdForTag($tagId);

        if ($articleIds) {

            return Article::with("category:id,name")
                ->whereIn('id', $articleIds)
                ->orderBy('id', 'desc')
                ->paginate($limit, '*', 'page', $page);
        }

        return false;
    }

    /**
     * 根据标签获取文章ID
     * @param $tagId
     * @return array|false
     */
    public function articleIdForTag($tagId)
    {
        $result = ArticleTagRel::where('tag_id', $tagId)
            ->select('article_id')->get()
            ->toArray();

        return $result ? array_column($result, 'article_id') : false;
    }

    /**
     * @param $keyword
     * @param $page
     * @param $limit
     * @param $orderBy
     * @return LengthAwarePaginator
     */
    public function articleForSearch($keyword, $page = 1, $limit = 10, $orderBy = 'id'): LengthAwarePaginator
    {
        return Article::with("category:id,name")
            ->orderBy($orderBy, 'desc')
            ->where('title', 'like', '%' . $keyword . '%')
            ->paginate($limit, '*', 'page', $page);
    }

    /**
     * @param $attr
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @return bool|LengthAwarePaginator
     */
    public function articleForAttr($attr, $page = 1, $limit = 10, $orderBy = 'id')
    {
        $metas = ArticleMeta::where('meta_key', $attr)
            ->orderBy('article_id', 'desc')
            ->select(['article_id'])
            ->get()->toArray();

        if ($metas) {

            $articleId = array_column($metas, 'article_id');

            return Article::with("category:id,name")
                ->orderBy($orderBy, 'desc')
                ->whereIn('id', $articleId)
                ->paginate($limit, '*', 'page', $page);
        }

        return false;

    }

    /**
     * 根据标签获取文章ID
     * @param $articleId
     * @return array|false
     */
    public function tagIdForArticle($articleId)
    {
        $result = ArticleTagRel::where('article_id', $articleId)
            ->select('tag_id')->get()
            ->toArray();

        return $result ? array_column($result, 'tag_id') : false;
    }

    /**
     * 文章标签
     * @param $articleId
     * @return array|LengthAwarePaginator
     */
    public function tagForArticle($articleId)
    {
        $tags = $this->tagIdForArticle($articleId);

        if ($tags) {
            return ArticleTag::whereIn('id', $tags)->get();
        }

        return [];
    }

    /**
     * 标签
     * @param $limit
     * @return mixed
     */
    public function tags($limit = 10)
    {
        return ArticleTag::limit($limit)->get();
    }

    /**
     * 文章评论列表
     * @param $articleId
     * @param $rootId
     * @param $page
     * @param $limit
     * @return LengthAwarePaginator
     */
    public function commentForArticle($articleId, $rootId, $page = 1, $limit = 10): LengthAwarePaginator
    {
        return ArticleComment::with('user:id,name,img')
            ->where([
                ['single_id', '=', $articleId],
                ['status', '=', 1],
                ['root_id', '=', $rootId],
            ])
            ->orderBy('id', $rootId == 0 ? 'desc' : 'asc')
            ->paginate($limit, '*', 'page', $page);
    }

    /**
     * 获取分类拓展
     * @param $id
     * @param array $exclude
     * @return mixed
     */
    public function categoryMeta($id, $exclude = [])
    {
        $meta = ArticleCategoryMeta::where('category_id', $id);

        $meta = $exclude ? $meta->whereNotIn('meta_key', $exclude) : $meta;

        return $meta->get();
    }

    /**
     * 获取文章拓展
     * @param $id
     * @param array $exclude
     * @return mixed
     */
    public function articleMeta($id, $exclude = [])
    {
        $meta = ArticleMeta::where('article_id', $id);

        $meta = $exclude ? $meta->whereNotIn('meta_key', $exclude) : $meta;

        return $meta->get();
    }

    /**
     * 文章增加浏览数
     * @param $id
     * @return void
     */
    public function articleAddView($id)
    {
        Article::where('id', $id)->update([
            'view' => DB::raw('view + 1'),
        ]);
    }
}
