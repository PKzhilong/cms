<?php

namespace Modules\Cms\Repositories\Article;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Modules\Cms\Models\Article;

class Articles
{

    public function __construct()
    {

    }

    /**
     * 获取分页数据
     *
     * @param Request $request
     */
    public function getPage(Request $request)
    {
        $query = Article::query()->with(['tags', 'category']);
        $title = $request->get('title', '');
        if ($title) {
            $query->where('title', 'like', $title . '%');
        }
        $tags = $request->get('tags', []);
        if ($tags) {
            $query->with(['tags' => function(Builder $query) use ($tags){
                $query->whereIn('id', $tags);
            }]);
        }
        $categories = $request->get('categories', []);
        if ($categories) {
            $query->with(['' => function(Builder $query) use ($tags){
                $query->whereIn('id', $tags);
            }]);
        }
        return $query->paginate($request->get('pageCount', 20));
    }

    public function getInfo($articleId)
    {
        $info = Article::query()->where('status', 1)
            ->with(['tags', 'category'])
            ->select(['id', 'title', 'video_url', 'q', 'description', 'category_id', 'img', 'content', 'view', 'created_at', 'updated_at'])
            ->find($articleId);
        return $info;
    }


}
