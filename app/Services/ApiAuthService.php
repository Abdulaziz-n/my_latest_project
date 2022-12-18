<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Usoft\Exceptions\UzmobileErrorException;

class ApiAuthService
{
    protected $url;
    protected $seconds = 3600;
    protected $login;
    protected $password;

    public function __construct()
    {
        $this->url = env('UZMOBILE_API_HOST');
        $this->login = env('UZMOBILE_API_LOGIN');
        $this->password = env('UZMOBILE_API_PASSWORD');
    }

    public function apiLogin()
    {
        Cache::forget('uzmobile_api_token');
        try {
            $value = Cache::remember('uzmobile_api_token', $this->seconds, function () {

                $login_response = Http::get($this->url . '/openapi/v1/tokens-stub/get?login=' . $this->login . '&password=' . $this->password);

                $xml = json_encode(simplexml_load_string($login_response));

                return json_decode($xml);
            });
        }catch ( \Exception $exception){
            throw new UzmobileErrorException('Uzmobile auth api not working now, we can\'t get SESSION_ID',$exception->getCode());
        }

        return $value;
    }

    public function getToken()
    {
        if (Cache::has('uzmobile_api_token')) {

            $token = Cache::get('uzmobile_api_token');

            return $token->SESSION_ID;
        } else
        Cache::forget('uzmobile_api_token');

        $token = $this->apiLogin();

        return $token->SESSION_ID;
    }

}
