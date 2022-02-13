<?php

use Addons\UrlFormat\Models\UrlFormat;

/**
 * 生成路由缓存
 */
if (!function_exists('url_format_route_cache')) {
    function url_format_route_cache()
    {
        $route = "<?php \n\r";
        $route .= "Route::group(['namespace' => 'Addons\UrlFormat\Controllers'], function () {\n\r";

        $route .= "\tRoute::get('/tag/{name}', 'UrlFormatController@tag');\n";

        $formats = UrlFormat::where('model_type', 'category')->get();

        if ($formats) {

            $route .= "\tRoute::group(['tag'=>'url_format.single'],function () {\n";

            foreach ($formats as $format) {
                $route .= "\t\tRoute::get('/{$format->alias}/{single}.html', 'UrlFormatController@single');\n";
            }

            $route .= "\t});\n";

            foreach ($formats as $format) {
                $route .= "\tRoute::get('/{$format->alias}', 'UrlFormatController@category');\n";
                $route .= "\tRoute::get('/{$format->alias}/page/{page}', 'UrlFormatController@category')->where('page', '[0-9]+');\n";
            }

        }

        $route .= "\n});";

        \Illuminate\Support\Facades\Storage::disk('root')
            ->put('/Addons/UrlFormat/Routes/format.php', $route);

    }
}

/**
 * 生成别名
 * @param $id
 * @param $name
 * @param $type [single,category,tag]
 */
if (!function_exists('url_format_alias_store')) {
    function url_format_alias_store($id, $name, $type, $auto = false): bool
    {
        $alias = $auto === false ? $name : pinyin($name);

        $result = UrlFormat::insert([
            'model_type' => $type,
            'alias' => $alias,
            'foreign_id' => $id,
        ]);

        url_format_route_cache();

        return $result;
    }
}

/**
 * 更新别名
 * @param $id
 * @param $name
 * @param $type [single,category,tag]
 */
if (!function_exists('url_format_alias_update')) {
    function url_format_alias_update($id, $name, $type, $auto = false): bool
    {
        $alias = $auto === false ? $name : pinyin($name);

        if (url_format_alias_for_id($id, $type)) {

            $result = UrlFormat::modify([
                ['model_type', '=', $type],
                ['foreign_id', '=', $id],
            ], ['alias' => $alias]);
        } else {

            $result = url_format_alias_store($id, $name, $type, $auto);
        }

        url_format_route_cache();

        return $result;
    }
}

/**
 * 根据ID获取别名
 * @param $id
 * @param $type [single,category,tag]
 */
if (!function_exists('url_format_alias_for_id')) {
    function url_format_alias_for_id($id, $type)
    {
        $result = UrlFormat::where([
            ['model_type', '=', $type],
            ['foreign_id', '=', $id],
        ])->first();

        return $result->alias ?? false;
    }
}

/**
 * 根据别名获取ID
 * @param $id
 * @param $type [single,category,tag]
 */
if (!function_exists('url_format_alias_for_alias')) {
    function url_format_alias_for_alias($alias, $type)
    {
        $result = UrlFormat::where([
            ['model_type', '=', $type],
            ['alias', '=', $alias],
        ])->first();

        return $result->foreign_id ?? false;
    }
}
