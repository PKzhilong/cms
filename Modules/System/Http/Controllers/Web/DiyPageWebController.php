<?php


namespace Modules\System\Http\Controllers\Web;


use App\Http\Controllers\MyController;

class DiyPageWebController extends MyController
{

    public function show()
    {
        $path = request()->path();
        $diyPage = app('system')->diyPage($path);

        if ($diyPage) {

            is_diy_page($diyPage);
            return $this->theme('diy-page', compact('diyPage'));
        }

        abort(404);
    }

}
