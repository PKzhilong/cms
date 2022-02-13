<?php


namespace Modules\System\Http\Controllers\Admin;


use App\Http\Controllers\MyAdminController;

class DiyPageController extends MyAdminController
{
    public $model = 'Modules\System\Models\DiyPage';

    public $request = 'Modules\System\Http\Requests\DiyPageRequest';

    public $view = 'admin.diy_page.';
}
