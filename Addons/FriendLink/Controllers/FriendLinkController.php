<?php


namespace Addons\FriendLink\Controllers;


use App\Http\Controllers\MyAdminController;

class FriendLinkController extends MyAdminController
{

    public $model = 'Addons\FriendLink\Models\FriendLink';

    public $request = 'Addons\FriendLink\Requests\FriendLinkRequest';

    /**
     * 配置页
     */
    public function config()
    {
        $config = system_config([],'friend_link');
        return $this->view('admin.config',compact('config'));
    }

    /**
     * 保存配置
     */
    public function storeCfg()
    {
        $show = $this->request('friend_link_show');

        $result = system_config_store(['friend_link_show' => $show], 'friend_link');

        return $this->result($result);
    }

}
