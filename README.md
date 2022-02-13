
## 项目介绍
## 站点地址

## 优秀案例
## 系统功能
* 后台基础功能
    * 权限管理
    * 内容管理
    * 商品管理
    * 会员管理
    * 插件管理
    * 辅助属性
    * 自定义页面
* 前台功能实现
    * 首页
    * 文章分类页
    * 文章搜索页
    * 文章标签页
    * 文章详情页
    * 文章评论
    * 商品列表页
    * 商品详情页
    * 会员登录/注册
    * 会员中心
* API接口
    * 签名加密
    * 系统时间接口
    * 系统辅助属性接口
    * 省市县地区接口
    * 文章分类列表接口
    * 文章分类详情接口
    * 文章列表接口
    * 文章详情接口
    * 文章评论列表接口
    * 文章评论发布接口
    * 商品分类列表接口
    * 商品分类详情接口
    * 商品列表接口
    * 商品详情接口
    * 会员登录接口
    * 会员注册接口
    * 会员等级接口
    
## 系统特性
* 简易安装程序
* 支持Swoole加速
* 后台一键升级更新
* 简洁优雅、灵活可扩展
* 完善的插件安装/卸载机制
* 对SEO优化友好的URL模式
* 公共函数埋点更好拓展系统
* 更具拓展性的路由监听功能
* 更优雅、符合SEO优化的分页
* 基础缓存功能及数据库索引建立
* 简单易用的模板函数、制作模板更方便

## 快速安装
1. 下载源码 / 上传源码到服务器
2. 将网站运行目录设置为 `/public`
3. 访问 `http://xxx.xxx/install` 根据安装向导进行在线配置

## 性能提升
* 使用opcache加速性能
* 缓存路由信息 `php artisan route:cache`
* 关闭调试模式 `APP_DEBUG=false`
* 缓存配置信息 `php artisan config:cache`
* 使用 `Swoole` 版本

## Swoole版本
目前最新版本`v1.3.2+`已经加入 `Swoole` 支持。
使用新版本的用户直接安装后按以下配置即可。

使用旧版本的用户则需要先安装 `composer require swooletw/laravel-swoole`。
在 `config/app.php` 服务提供者数组添加该服务提供者。

```php
[
    'providers' => [
        SwooleTW\Http\LaravelServiceProvider::class,
    ],
]
```

## Nginx配置

```nginx
map $http_upgrade $connection_upgrade {
    default upgrade;
    ''      close;
}
server {
    listen 80;
    server_name your.domain.com;
    root /path/to/laravel/public;
    index index.php;

    location = /index.php {
        # Ensure that there is no such file named "not_exists"
        # in your "public" directory.
        try_files /not_exists @swoole;
    }
    # any php files must not be accessed
    #location ~* \.php$ {
    #    return 404;
    #}
    location / {
        try_files $uri $uri/ @swoole;
    }

    location @swoole {
        set $suffix "";

        if ($uri = /index.php) {
            set $suffix ?$query_string;
        }

        proxy_http_version 1.1;
        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header SERVER_PORT $server_port;
        proxy_set_header REMOTE_ADDR $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection $connection_upgrade;

        # IF https
        # proxy_set_header HTTPS "on";

        proxy_pass http://127.0.0.1:1215$suffix;
    }
}

```

## Swoole运行
`php artisan swoole:http start`

|  命令 | 说明  |
|---|---|
|  start | 开启  |
|  stop | 停止  |
|  restart | 重启  |
|  reload | 重载  |
|  infos | 信息  |
## 插件清单


|  名称 | 简介  |类型　　|状态　　|价格　　|
|---|---|---|---|---|
|系统记录|后台操作记录|插件|完成|免费|
|百度推送|百度资源推送，加速页面收录|插件|完成|免费|
|SEO设置|自定义设置标题，关键词，描述|插件|完成|免费|
|友情链接|友情链接|插件|完成|免费|
|网站地图|生成网站XML地图|插件|完成|免费|
|广告管理|广告管理|插件|完成|免费|
|网址导航|网址导航|插件|完成|免费|
|后台更新|后台一键更新升级|插件|完成|免费|
|织梦插件|织梦数据导入|插件|完成|免费|
|SEO优化（URL）|SEO优化（URL）|插件|完成|授权|
|阿里云OSS|阿里云OSS|插件|完成|授权|
|Sql转换|Sql转Laravel数据库迁移|插件|完成|授权|
|在线制作海报|拖拽在线制作海报|插件|完成|授权|
|语音合成|在线文字转语音|插件|完成|授权|
|QQ登录|QQ登录|插件|完成|授权|
|模板管理|快速生成模板|插件|完成|授权|
|阿里云短信|阿里云短信|插件|完成|授权|
|支付宝支付|个人版（当面付）|插件|完成|授权|
|采集爬虫|采集爬虫|插件|完成|授权|
|付费专栏|付费专栏|插件|完成|授权|
|活码+|活码插件|插件|完成|授权|
