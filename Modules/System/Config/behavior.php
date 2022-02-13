<?php
return [

    'url:system/login:POST:200' => [
        '\Modules\System\Events\AdminLoginEvent',
    ],

    'url:system/diy-page/create:POST:200' => [
        '\Modules\System\Events\DiyPageRouteCacheEvent',
    ],

    'url:system/diy-page/edit:POST:200' => [
        '\Modules\System\Events\DiyPageRouteCacheEvent',
    ],

    'url:system/diy-page/destroy:POST:200' => [
        '\Modules\System\Events\DiyPageRouteCacheEvent',
    ],
];
