<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Models\ArticleComment;
use Modules\Shop\Models\PayLog;
use Nwidart\Modules\Json;

/**
 * 将数组拼接成字符串
 */
if (!function_exists('join_data')) {
    function join_data($array, $separator = ''): string
    {
        $collect = array_map(function ($item) {
            return "'{$item}'";
        }, $array);

        return join($separator, $collect);
    }
}

/**
 * 插件地址
 */
if (!function_exists('addon_path')) {
    function addon_path($name, $path = ''): string
    {
        return base_path('Addons/' . $name . $path);
    }
}

/**
 * 获取系统配置
 */
if (!function_exists('system_config')) {
    function system_config($cfgKey = [], $group = 'system')
    {
        $config = system_config_cache($cfgKey, $group);

        if ($config === false) {

            try {
                $config = (new \Modules\System\Models\Config())->group($group)->getConfig(
                    is_string($cfgKey) ? [$cfgKey] : $cfgKey
                );
            } catch (Exception $e) {

            }
        }

        return is_string($cfgKey) && is_array($config) ?
            ($config[$cfgKey] ?? false) :
            $config;

    }
}

/**
 * 从缓存中获取系统配置
 */
if (!function_exists('system_config_cache')) {
    function system_config_cache($cfgKey, $group)
    {
        if (file_exists(base_path('bootstrap/cache/system_config.php'))) {

            if (config('system_config') == null) {
                $config = include base_path('bootstrap/cache/system_config.php');
            } else {
                $config = config('system_config');
            }

            $systemConfig = $config[$group] ?? [];

            if (empty($systemConfig)) {
                return is_string($cfgKey) ? '' : [];
            }

            if (is_string($cfgKey)) {
                return $systemConfig[$cfgKey] ?? '';
            }

            $array = [];
            foreach ($systemConfig as $key => $item) {
                if (empty($cfgKey) || in_array($key, $cfgKey)) {
                    $array[$key] = $item;
                }
            }

            return $array;
        }

        return false;
    }
}

/**
 * 更新系统配置缓存
 */
if (!function_exists('update_system_config_cache')) {
    function update_system_config_cache()
    {

        $configs = \Modules\System\Models\Config::get();

        $formatConfig = [];

        foreach ($configs as $config) {
            $config = $config->toArray();
            $formatConfig[$config['cfg_group']][$config['cfg_key']] = $config['cfg_val'];
        }

        \Illuminate\Support\Facades\Storage::disk('root')->put(
            'bootstrap/cache/system_config.php',
            "<?php \n\rreturn " . var_export($formatConfig, true) . ";"
        );

    }
}


/**
 * 保存系统配置
 */
if (!function_exists('system_config_store')) {
    function system_config_store($data, $group)
    {
        $cfg = Modules\System\Models\Config::whereIn('cfg_key', array_keys($data))
            ->get()->toArray();

        $newConfigs = array_diff(
            array_keys($data),
            array_column($cfg, 'cfg_key')
        );

        foreach ($newConfigs as $cfg) {
            if ($data[$cfg] !== null) {
                (new Modules\System\Models\Config())->store([
                    'cfg_key' => $cfg,
                    'cfg_val' => $data[$cfg],
                    'cfg_group' => $group,
                ]);
            }
        }

        $result = (new Modules\System\Models\Config())->batchUpdate([
            'cfg_val' => ['cfg_key' => $data]
        ], "cfg_group = '{$group}'");

        update_system_config_cache();

        return $result;
    }
}


/**
 * 获取当前域名
 */
if (!function_exists('system_http_domain')) {
    function system_http_domain(): string
    {
        return (env('IS_HTTPS') ? 'https://' : 'http://') . request()->server('HTTP_HOST');
    }
}

/**
 * 获取图片链接
 */
if (!function_exists('system_image_url')) {
    function system_image_url($path): string
    {
        $disk = system_config('site_upload_disk');

        if ($disk == 'oss') {

            $url = Storage::url($path);
            $url = str_replace('https://', '', $url);
            return 'https://' . $url;
        }

        return str_replace('public/', '/', $path);
    }
}

/**
 * 获取资源链接
 */
if (!function_exists('system_resource_url')) {
    function system_resource_url($path): string
    {
        return system_image_url($path);
    }
}

/**
 * 调用插件函数
 */
if (!function_exists('call_hook_function')) {
    function call_hook_function($name, ...$arg)
    {
        if (function_exists($name)) {
            return call_user_func($name, ...$arg);
        }
        return false;
    }
}

/**
 * 统计模型记录数
 */
if (!function_exists('system_model_count')) {
    function system_model_count(\App\Models\MyModel $model, $where = [])
    {
        return $model::where($where)->count();
    }
}

/**
 * 统计模型模型某个字段的总数
 */
if (!function_exists('system_model_sum')) {
    function system_model_sum(\App\Models\MyModel $model, $fields, $where = [])
    {
        if (is_string($fields)) {
            return $model::where($where)->sum($fields);
        }

        if (is_array($fields)) {
            $raws = array_map(function ($item) {
                return "SUM({$item}) as {$item}_sum";
            }, $fields);
            return $model::select(\Illuminate\Support\Facades\DB::raw(join(",", $raws)))->where($where)->first();
        }
    }
}

/**
 * 判断是否为手机端
 */
if (!function_exists("is_mobile")) {
    function is_mobile(): bool
    {

        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }

        $client = [
            'mobile', 'nokia', 'sony', 'ericsson', 'mot', 'samsung',
            'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic',
            'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu',
            'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm',
            'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap'
        ];

        if ($userAgent = request_user_agent()) {

            if (preg_match("/(" . implode('|', $client) . ")/i", $userAgent)) {

                return true;
            }
        }

        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== FALSE) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === FALSE || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }

        return false;
    }
}

/**
 * 参数过滤
 */
if (!function_exists('paramFilter')) {
    function paramFilter($value)
    {
        if (preg_match("/['\\\"]+/", $value)) {
            return false;
        }
        $value = str_replace("&#x", "& # x", $value);    //过滤一些不安全字符
        $value = preg_replace("/eval/i", "eva l", $value);    //过滤不安全函数
        return addslashes($value);
    }
}

/**
 * 获取客户端真实IP
 */
if (!function_exists('get_client_ip')) {
    function get_client_ip()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            return explode(",", $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }

        if (isset(request()->header()['x-forwarded-for'])) {
            return explode(",", request()->header()['x-forwarded-for'][0])[0];
        }

        return request()->getClientIp();
    }
}

/**
 * 获取图片文件格式
 */
if (!function_exists('get_img_suffix')) {
    function get_img_suffix($name)
    {
        $info = getimagesize($name);

        $suffix = false;

        if ($mime = $info['mime']) {
            $suffix = explode('/', $mime)[1];
        }

        return $suffix;
    }
}

/**
 * 获取资源的http地址
 */
if (!function_exists('get_resource_http_path')) {
    function get_resource_http_path($src, $url)
    {

        if (substr($src, 0, 4) == 'http' || substr($src, 0, 2) == '//') {
            $imgUrl = $src;
        } else {
            $http = parse_url($url);
            $imgUrl = (
                substr($src, 0, 1) == '/'
                    ? $http['scheme'] . "://" . $http['host']
                    : dirname($url) . "/"
                ) . $src;
        }

        return $imgUrl;
    }
}


/**
 * 创建支付订单记录
 */
if (!function_exists('create_pay_log')) {
    function create_pay_log($userId, $total, $goodsId, $goodsName, $tradeType, $payType = 'dmf')
    {
        do {
            $tradeNo = date("YmdHi") . mt_rand(1111, 9999) . date("s");
            $log = PayLog::where('trade_no', $tradeNo)->first();
        } while ($log);

        $data = [
            'trade_no' => $tradeNo,
            'trade_type' => $tradeType,
            'user_id' => $userId,
            'goods_id' => $goodsId,
            'goods_name' => $goodsName,
            'total_amount' => $total,
            'pay_type' => $payType,
        ];

        $result = (new PayLog)->store($data);

        return $result ? $tradeNo : false;
    }
}

/**
 * 完成支付订单
 */
if (!function_exists('finish_pay_order')) {
    function finish_pay_order($tradeNo)
    {
        PayLog::where('trade_no', $tradeNo)->update(['status' => 1, 'pay_time' => time()]);

        $payLog = app('store')->payLogForTradeNo($tradeNo);

        if (function_exists("{$payLog->trade_type}_finish_order")) {
            call_user_func("{$payLog->trade_type}_finish_order", $tradeNo);
        }
    }
}

/**
 * 获取系统已安装的插件
 */
if (!function_exists('system_addons')) {
    /**
     * @throws Exception
     */
    function system_addons()
    {
        $addons = Json::make(base_path('addons_statuses.json'))->getAttributes();
        return array_keys($addons);
    }

}

/**
 * 管道处理通用方法
 */

if (!function_exists('pipeline_func')) {
    function pipeline_func($value, $ident)
    {
        $pipes = config('pipeline')[$ident] ?? [];

        if ($pipes) {

            return app(Pipeline::class)
                ->send($value)
                ->through($pipes)
                ->then(function ($value) {
                    return $value;
                });
        }

        return $value;
    }
}

/**
 * 页面标题
 */
if (!function_exists('page_title')) {
    function page_title()
    {
        $title = session('page_title');
        $pageIdent = session('the_page');

        if (function_exists("the_{$pageIdent}_title")) {
            $title = call_user_func("the_{$pageIdent}_title");
        }

        $title = pipeline_func($title, 'page_title');


        return $title ?: system_config('site_name');

    }
}

/**
 * 页面标题
 */
if (!function_exists('page_keyword')) {
    function page_keyword()
    {
        $keyword = session('page_keyword');
        $pageIdent = session('the_page');

        if (function_exists("the_{$pageIdent}_keyword")) {
            $keyword = call_user_func("the_{$pageIdent}_keyword");
        }

        $keyword = pipeline_func($keyword, 'page_keyword');

        return $keyword ?: '';
    }
}

/**
 * 页面描述
 */
if (!function_exists('page_description')) {
    function page_description()
    {
        $description = session('page_description');
        $pageIdent = session('the_page');

        if (function_exists("the_{$pageIdent}_description")) {
            $description = call_user_func("the_{$pageIdent}_description");
        }

        $description = pipeline_func($description, 'page_description');

        return $description ?: '';
    }
}

/**
 * 通用列表
 */
if (!function_exists('page_list')) {
    function page_list($type, $page = 1, $limit = 10, $tag = '', $params = [])
    {
        $tag = $tag ?: the_page();

        if (function_exists($tag . "_" . $type)) {

            $params[$tag . "_id"] = $params[$tag . "_id"] ?? the_page_id();
            $values = call_user_func($tag . "_" . $type, $page, $limit, $params);

            return pipeline_func($values, $tag . "_" . $type);
        }

        return false;
    }
}

/**
 * 文章详情
 */
if (!function_exists('article')) {
    function article($id, $meta = false)
    {
        return app('cms')->article($id, $meta);
    }
}

/**
 * 文章列表
 */
if (!function_exists('articles')) {
    function articles($page = 1, $limit = 10, $tag = '', $params = [])
    {
        return page_list('articles', $page, $limit, $tag, $params);
    }
}

/**
 * 最新文章列表
 */
if (!function_exists('home_articles')) {

    function home_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return new_articles($page, $limit, $params);
    }
}

/**
 * 最新文章列表
 */
if (!function_exists('new_articles')) {

    function new_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('cms')->articlesForSort($page, $limit);
    }
}

/**
 * 热门文章列表
 */
if (!function_exists('hot_articles')) {

    function hot_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('cms')->articlesForSort($page, $limit, 'view');
    }
}

/**
 * 分类最新文章列表
 */
if (!function_exists('category_articles')) {

    function category_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('cms')->articleForCategory($params['category_id'], $page, $limit);
    }
}


/**
 * 分类最热文章列表
 */
if (!function_exists('category_hot_articles')) {

    function category_hot_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('cms')->articleForCategory($params['category_id'], $page, $limit, 'view');
    }
}


/**
 * 标签最新文章列表
 */
if (!function_exists('tag_articles')) {

    function tag_articles($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('cms')->articleForTag($params['tag_id'], $page, $limit);
    }
}


/**
 * 搜索最新文章列表
 */
if (!function_exists('search_articles')) {

    function search_articles($page = 1, $limit = 10, $params = [])
    {
        return app('cms')->articleForSearch($params['search'] ?? '', $page, $limit);
    }
}

/**
 * 属性最新文章列表
 */
if (!function_exists('attr_articles')) {

    function attr_articles($page = 1, $limit = 10, $params = [])
    {
        return app('cms')->articleForAttr($params['name'] ?? '', $page, $limit);
    }
}

/**
 * 分类列表
 */
if (!function_exists('categories')) {
    function categories()
    {
        $values = app('cms')->categoryTree();
        return pipeline_func($values, 'categories');
    }
}

/**
 * 标签列表
 */
if (!function_exists('tags')) {
    function tags($limit = 10)
    {
        $values = app('cms')->tags($limit);
        return pipeline_func($values, 'tags');
    }
}

/**
 * 文章标签列表
 */
if (!function_exists('article_tags')) {
    function article_tags($articleId = false)
    {
        $articleId = $articleId ?: the_page_id();

        $values = app('cms')->tagForArticle($articleId);
        return pipeline_func($values, 'article_tags');
    }
}

/**
 * 文章标签文本
 */
if (!function_exists('article_tags_text')) {
    function article_tags_text($articleId = false): string
    {
        $articleId = $articleId ?: the_page_id();
        $tags = article_tags($articleId);

        if ($tags) {

            return join(
                ',',
                array_column($tags->toArray(), 'tag_name')
            );
        }

        return '';
    }
}

/**
 * 文章评论列表
 */
if (!function_exists('article_comments')) {
    function article_comments($articleId, $rootId = 0, $page = 1, $limit = 10)
    {
        $values = app('cms')->commentForArticle($articleId, $rootId, $page, $limit);
        return pipeline_func($values, 'article_comments');
    }
}

/**
 * 单条评论
 */
if (!function_exists('comment')) {
    function comment($id, $singleId = 0)
    {
        $param = [
            ['id', '=', $id],
            ['status', '=', 1],
        ];

        $singleId && $param[] = ['single_id', '=', $singleId];
        $comment = ArticleComment::where($param)->first();

        return pipeline_func($comment, 'comment');
    }
}

/**
 * 商品列表
 */
if (!function_exists('goods')) {
    function goods($page = 1, $limit = 10, $tag = '', $params = [])
    {
        return page_list('goods', $page, $limit, $tag, $params);
    }
}

/**
 * 首页商品列表
 */
if (!function_exists('home_goods')) {

    function home_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return new_goods($page, $limit, $params);
    }
}

/**
 * 商城首页商品列表
 */
if (!function_exists('store_goods')) {

    function store_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return new_goods($page, $limit, $params);
    }
}

/**
 * 最新商品列表
 */
if (!function_exists('new_goods')) {

    function new_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('store')->goodsList($page, $limit);
    }
}

/**
 * 热门商品列表
 */
if (!function_exists('hot_goods')) {

    function hot_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('store')->goodsList($page, $limit, 'view');
    }
}

/**
 * 搜索商品
 */
if (!function_exists('search_goods')) {

    function search_goods($page = 1, $limit = 10, $params = [])
    {
        return app('store')->search($params['search'] ?? '', $page, $limit);
    }
}

/**
 * 属性商品列表
 */
if (!function_exists('attr_goods')) {

    function attr_goods($page = 1, $limit = 10, $params = [])
    {
        return app('store')->goodsForAttr($params['name'] ?? '', $page, $limit);
    }
}

/**
 * 分类最新商品列表
 */
if (!function_exists('store_category_goods')) {

    function store_category_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('store')->goodsForCategory($params['store_category_id'], $page, $limit);
    }
}

/**
 * 分类最新商品列表
 */
if (!function_exists('store_category_hot_goods')) {

    function store_category_hot_goods($page = 1, $limit = 10, $params = []): LengthAwarePaginator
    {
        return app('store')->goodsForCategory($params['store_category_id'], $page, $limit,'view');
    }
}

/**
 * 商品分类列表
 */
if (!function_exists('store_category')) {

    function store_category()
    {
        return app('store')->categoryTree();
    }
}


/**
 * 格式化日期
 */
if (!function_exists('created_at_date')) {
    function created_at_date($dateTime, $format = 'Y-m-d')
    {
        return date($format, strtotime($dateTime));
    }
}

/**
 * 获取友情链接
 */
if (!function_exists('friend_link')) {
    function friend_link()
    {
        return pipeline_func([], 'friend_link');
    }
}

/**
 * 获取导航
 */
if (!function_exists('navs')) {
    function navs()
    {
        return pipeline_func([], 'navs');
    }
}

/**
 * 获取广告
 */
if (!function_exists('ad')) {
    function ad($code)
    {
        return pipeline_func($code, 'ad');
    }
}

/**
 * 扫描系统内模板
 */
if (!function_exists('system_themes')) {
    function system_themes(): array
    {
        $directories = Storage::disk('root')
            ->directories('Template');

        return array_map(function ($item) {
            if (file_exists(base_path($item . '/theme.json'))) {
                $info = \Illuminate\Support\Facades\Storage::disk('root')
                    ->get($item . '/theme.json');
                return json_decode($info, true);
            }
        }, $directories);
    }
}

/**
 * API参数签名加密
 */
if (!function_exists('api_param_sign')) {
    function api_param_sign($params): string
    {
        ksort($params);

        $string = '';
        foreach ($params as $key => $param) {
            if ($key != env('API_SIGN_NAME')) {
                $string .= "{$key}={$param}&";
            }
        }

        $string = trim($string, "&") . env('API_KEY');

        return md5($string);
    }
}

/**
 * 下载资源 CURL
 */
if (!function_exists('curl_download_get')) {
    function curl_download_get($url)
    {
        $header = [
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36'
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $data = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($code != 200) {
            return false;
        } else {
            curl_close($curl);
            return $data;
        }
    }
}

/**
 * 获取 User-Agent
 */
if (!function_exists('request_user_agent')) {
    function request_user_agent($toLower = true)
    {
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {

            return $toLower ? strtolower($_SERVER['HTTP_USER_AGENT']) : $_SERVER['HTTP_USER_AGENT'];
        }

        if (isset(request()->header()['user-agent'])) {

            return $toLower ? strtolower(request()->header()['user-agent'][0]) : request()->header()['user-agent'][0];
        }

        return false;
    }
}

/**
 * 是否为PC客户端
 */
if (!function_exists('is_pc')) {
    function is_pc(): bool
    {
        return !is_mobile();
    }
}

/**
 * 是否为安卓客户端
 */
if (!function_exists('is_android')) {
    function is_android(): bool
    {
        return strpos(request_user_agent(), 'android');
    }
}

/**
 * 是否为苹果客户端
 */
if (!function_exists('is_ios')) {
    function is_ios(): bool
    {
        return (strpos(request_user_agent(), 'iphone') || strpos(request_user_agent(), 'ipad'));
    }
}

/**
 * 是否为微信打开
 */
if (!function_exists('is_wechat')) {
    function is_wechat(): bool
    {
        return strpos(request_user_agent(), 'micromessenger');
    }
}

/**
 * 是否为支付宝打开
 */
if (!function_exists('is_alipay')) {
    function is_alipay(): bool
    {
        return strpos(request_user_agent(), 'alipayclient');
    }
}

/**
 * 是否为QQ打开
 */
if (!function_exists('is_qq')) {
    function is_qq(): bool
    {
        return strpos(request_user_agent(), 'qq') && !is_wechat();
    }
}

/**
 * 是否为云闪付打开
 */
if (!function_exists('is_unionpay')) {
    function is_unionpay(): bool
    {
        return strpos(request_user_agent(), 'unionpay');
    }
}

/**
 * 获取商品相册函数
 */
if (!function_exists('goods_albums')) {
    function goods_albums($goodsId)
    {
        return app('store')->goodsAlbums($goodsId);
    }
}
