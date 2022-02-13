<?php


namespace Modules\System\Http\Controllers\Admin;


use App\Http\Controllers\MyAdminController;

class AttrController extends MyAdminController
{

    public $model = 'Modules\System\Models\Attr';

    public $request = 'Modules\System\Http\Requests\AttrRequest';

    public $view = 'admin.attr.';

}
