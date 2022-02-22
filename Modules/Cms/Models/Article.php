<?php


namespace Modules\Cms\Models;


use App\Models\MyModel;

class Article extends MyModel
{

    protected $table = 'my_article';
    protected $fillable = ['view', 'download_times'];

    /**
     * 类型转换
     *
     * @var array
     */
    protected $casts = [
        'img' => 'array',
    ];

    /**
     * 所使用tag
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(ArticleTag::class, 'my_article_tag_rel', 'article_id', 'tag_id');
    }


    public function __get($key)
    {
        $meta = ArticleMeta::where([
            'article_id' => $this->getAttribute('id'),
            'meta_key' => $key
        ])->first();

        return $meta ? $meta->meta_value : parent::__get($key);
    }

    public function category()
    {
        return $this->hasOne('Modules\Cms\Models\ArticleCategory', 'id', 'category_id');
    }


}
