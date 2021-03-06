<?php


namespace Modules\System\Database\Seeders;


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createdTime = Carbon::now()->toDateTimeString();
        DB::table('my_system_menu')->insert([
            [
                'pid' => 0,
                'title' => '系统模块',
                'icon' => 'fa fa-windows',
                'url' => '',
                'target' => '',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 0,
                'title' => '会员模块',
                'icon' => 'fa fa-users',
                'url' => '',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 0,
                'title' => 'CMS模块',
                'icon' => 'fa fa-bandcamp',
                'url' => '',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 0,
                'title' => '商城模块',
                'icon' => 'fa fa-shopping-bag',
                'url' => '',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],
            [
                'pid' => 1,
                'title' => '系统配置',
                'icon' => 'fa fa-cog',
                'url' => '/system/config',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],
            [
                'pid' => 1,
                'title' => '管理员管理',
                'icon' => 'fa fa-user',
                'url' => '/system/admin',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],
            [
                'pid' => 1,
                'title' => '角色管理',
                'icon' => 'fa fa-bitbucket-square',
                'url' => '/system/role',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 1,
                'title' => '菜单管理',
                'icon' => 'fa fa-bars',
                'url' => '/system/menu',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 1,
                'title' => '插件管理',
                'icon' => 'fa fa-plus-square',
                'url' => '/system/addon',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 1,
                'title' => '辅助属性',
                'icon' => 'fa fa-arrows-alt',
                'url' => '/system/attr',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 1,
                'title' => '自定义页面',
                'icon' => 'fa fa-paste',
                'url' => '/system/diy-page',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 2,
                'title' => '会员管理',
                'icon' => 'fa fa-users',
                'url' => '/user/admin/',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 2,
                'title' => '会员等级',
                'icon' => 'fa fa-address-card',
                'url' => '/user/admin/rank',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 2,
                'title' => '余额明细',
                'icon' => 'fa fa-money',
                'url' => '/user/admin/balance',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 2,
                'title' => '积分明细',
                'icon' => 'fa fa-database',
                'url' => '/user/admin/point',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 3,
                'title' => '文章分类',
                'icon' => 'fa fa-arrows-alt',
                'url' => '/article/admin/category',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 3,
                'title' => '文章列表',
                'icon' => 'fa fa-list',
                'url' => '/article/admin',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 3,
                'title' => '文章标签',
                'icon' => 'fa fa-tags',
                'url' => '/article/admin/tag',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 3,
                'title' => '文章评论',
                'icon' => 'fa fa-commenting-o',
                'url' => '/article/admin/comment',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 4,
                'title' => '商品分类',
                'icon' => 'fa fa-list',
                'url' => '/shop/admin/category',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 4,
                'title' => '商品列表',
                'icon' => 'fa fa-shopping-bag',
                'url' => '/shop/admin/goods',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ],[
                'pid' => 4,
                'title' => '支付流水',
                'icon' => 'fa fa-money',
                'url' => '/shop/admin/pay/logs',
                'target' => '_self',
                'sort' => 0,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ]
        ]);
    }
}
