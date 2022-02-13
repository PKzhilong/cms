<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

if (!function_exists('bing_submit_url')) {
    function bing_submit_url($url)
    {
        $key = system_config('bing_api_key', 'bing_submit_url');

        if ($key) {

            $api = "https://ssl.bing.com/webmaster/api.svc/json/SubmitUrlbatch?apikey={$key}";

            $list = !is_array($url) ? explode("\n", $url) : $url;

            $http = new Client(['verify' => false]);

            try {

                $res = $http->request('POST', $api, [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=utf-8',
                        'Host' => 'ssl.bing.com',
                    ],
                    'body' => json_encode([
                        'siteUrl' => system_config('site_url'),
                        'urlList' => $list,
                    ])
                ]);

                $response = $res->getBody()->getContents();

            } catch (ClientException $exception) {
                $response = $exception->getResponse()->getBody()->getContents();
            }

            $data = [];
            $dateTime = date('Y-m-d H:i:s');

            foreach ($list as $item) {

                $data[] = [
                    'admin_name' => auth()->guard('admin')->user()->name ?? 'system',
                    'url' => $item,
                    'response' => $response,
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime,
                ];
            }

            \Addons\BingSubmitUrl\Models\BingSubmitLog::insertAll($data);
        }

    }
}
