<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use PHPUnit\Exception;
use Usoft\Exceptions\UzmobileErrorException;

class InformationService
{
    protected $url;
    protected $serviceId = 100;

    public function __construct()
    {
        $this->url = env('API_HOST');
//        $this->http = Http::baseUrl($this->url)

    }

    public function token()
    {
        return (new ApiAuthService())->getToken();
    }

    public function getSubcriber($msisdn)
    {
        try {
            $subscriber = Http::withHeaders(['authToken' => $this->token()])->get($this->url . '/openapi/v1/subscribers/msisdn:' . $msisdn)->throw()->json();
            return $subscriber;
        } catch (\Exception $exception) {
            throw new UzmobileErrorException('Subscribers msisdn error, Exception:' . $exception->getMessage(), $exception->getCode());
        }

    }

    public function customerId($subscribeId)
    {
        try {
            $customer = Http::withHeaders(['authToken' => $this->token()])->get($this->url . '/openapi/v1/subscribers/' . $subscribeId . '/personalAccounts')->throw()->json();
            return $customer;
        } catch (\Exception $exception) {
            throw new UzmobileErrorException('Personal Account subscriber error, subscribeId Exception:' . $exception->getMessage(), $exception->getCode());
        }
    }

    public function getRtBalance($personalAccountCustomerId)
    {
        try {
            $balance = Http::withHeaders(['authToken' => $this->token()])->get($this->url . '/openapi/v1/customers/' . $personalAccountCustomerId . '?fields=balances(rtBalance)')->throw()->json();
            return $balance;
        } catch (\Exception $exception) {
            throw new UzmobileErrorException('Rt Balance error, Exception:' . $exception->getMessage(), $exception->getCode());
        }
    }

    public function activateService($subscribeId)
    {
        try {
            $activate = Http::withHeaders(['authToken' => $this->token()])->asForm()->post($this->url . '/openapi/v1/subscribers/' . $subscribeId . '/services/activate?serviceId=' . $this->serviceId)->throw()->json();
            return $activate;
        } catch (\Exception $exception) {
            throw new UzmobileErrorException('Activate service error, Exception:' . $exception->getMessage(), $exception->getCode());
        }

    }

    public function deactivateService($subscribeId)
    {

        try {
            $deactivate = Http::withHeaders(['authToken' => $this->token()])->asForm()->post("{$this->url}/openapi/v1/subscribers/{$subscribeId}/services/{$this->serviceId}/deactivate")->throw()->json();
//            return $deactivate;
        } catch (\Exception $exception) {
            throw new UzmobileErrorException('Deactivate error, Exception:' . $exception->getMessage(), $exception->getCode());
        }

        return $deactivate;
    }

    public function checkService($subscribeId)
    {
        try {
            $chek = Http::withHeaders(['authToken' => $this->token()])->get($this->url . '/openapi/v1/subscribers/' . $subscribeId . '/services/' . $this->serviceId . '?fields=serviceId,name,status')->throw()->json();
            return $chek;
        } catch (\Exception $exception) {
            throw new UzmobileErrorException('Check service error, Exception:' . $exception->getMessage(), $exception->getCode());
        }
    }

    public function activePack($subscribeId, $pack_id, $comment)
    {
        try {
            $pack = Http::withHeaders(['authToken' => $this->token()])->asForm()->post($this->url . '/openapi/v1/subscribers/' . $subscribeId . '/packs/activate?packId=' . $pack_id . '&comment=' . $comment)->throw()->json();
        } catch (\Exception $exception) {
//            return response([
//                'code' => $exception->getCode(),
//                'message' => $exception->getMessage()
//            ], 403);
            throw new UzmobileErrorException('Activate pack error, Exception:' . $exception->getMessage(), $exception->getCode());
        }

        return $pack;
    }

    public function getPacks($subscribeId)
    {
        try {
            $getPack = Http::withHeaders(['authToken' => $this->token()])->get($this->url . '/openapi/v1/subscribers/' . $subscribeId . '/packs')->throw()->json();
            return $getPack;
        } catch (\Exception $exception) {
            throw new UzmobileErrorException('Get packs error, Exception:' . $exception->getMessage(), $exception->getCode());
        }
    }

    public function checkPack($subscribeId, $pack_id)
    {
        try {
            $check = Http::withHeaders(['authToken' => $this->token()])->get($this->url . '/openapi/v1/subscribers/' . $subscribeId . '/packs?packIds=' . $pack_id)->throw()->json();
            return $check;
        } catch (\Exception $exception) {
            throw new UzmobileErrorException('Check pack_id returned with error, Exception:' . $exception->getMessage(), $exception->getCode());
        }
    }
}
