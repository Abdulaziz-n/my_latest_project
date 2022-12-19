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
        $this->url = env('API_HOST');
        $this->login = env('API_LOGIN');
        $this->password = env('API_PASSWORD');
    }

    public function apiLogin()
    {
        Cache::forget('api_token');
        try {
            $value = Cache::remember('api_token', $this->seconds, function () {

                $login_response = Http::get($this->url . '/openapi/v1/tokens-stub/get?login=' . $this->login . '&password=' . $this->password);

                $xml = json_encode(simplexml_load_string($login_response));

                return json_decode($xml);
            });
        }catch ( \Exception $exception){
            throw new UzmobileErrorException('auth api not working now, we can\'t get SESSION_ID',$exception->getCode());
        }

        return $value;
    }

    public function getToken()
    {
        if (Cache::has('api_token')) {

            $token = Cache::get('api_token');

            return $token->SESSION_ID;
        } else
        Cache::forget('api_token');

        $token = $this->apiLogin();

        return $token->SESSION_ID;
    }

}
