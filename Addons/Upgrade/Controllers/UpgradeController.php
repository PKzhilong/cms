<?php


namespace Addons\Upgrade\Controllers;


use Addons\Upgrade\Models\UpgradeLog;
use App\Http\Controllers\MyController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class UpgradeController extends MyController
{

    public function index()
    {
        if (request()->ajax() && request()->wantsJson()) {
            $category = UpgradeLog::orderBy('id', 'desc')
                ->paginate($this->request('limit', 'intval'))->toArray();

            return $this->jsonSuc($category);
        }

        return $this->view('admin.index');
    }

    public function version()
    {
        $files = $response = [];
        $version = config('app.version') ?? '';
        $status = [
            'modified' => '修改',
            'added' => '增加',
        ];

        if ($version) {

            $client = new Client(['verify' => false, 'http_errors' => false]);
            $checkUrl = config('upgrade.version_url') . "?version={$version}";

            $res = $client->get($checkUrl);

            $response = json_decode($res->getBody()->getContents(), true);
            $response['code'] == 200 && $files = json_decode($response['result']['files'], true);
        }

        return $this->view('admin.version', compact('response', 'version', 'files', 'status'));

    }

    public function update()
    {

        if ($package = $this->request('upgrade_package')) {

            $client = new Client(['verify' => false, 'http_errors' => false]);
            $res = $client->get($package);
            Storage::put(basename($package), $res->getBody()->getContents());

            $zip = new \ZipArchive();
            $zip->open(storage_path("app/" . basename($package)));

            $zip->extractTo(base_path());
            $zip->close();

            UpgradeLog::insert([
                'before_version' => config('app.version'),
                'after_version' => $this->request('upgrade_version'),
            ]);

            return $this->result(true);
        }

        return $this->result(false);
    }

}
