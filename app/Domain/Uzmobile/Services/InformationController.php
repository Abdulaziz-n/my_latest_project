<?php

namespace App\Domain\Uzmobile\Services;

use App\Http\Controllers\Controller;
use App\Services\AuthTokenService;
use App\Services\InformationService;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function getSubscriber(Request $request)
    {
        $msisdn = $request->input('msisdn');

        $subscriber = (new InformationService())->getSubcriber($msisdn);

        return $subscriber;
    }

    public function getPersonalCustomerId(Request $request)
    {
        $subscribeId = $request->input('subscribeId');

        $customer = (new InformationService())->customerId($subscribeId);

        return $customer;
    }

    public function getRtBalance(Request $request)
    {
        $personalAccountCustomerId = $request->input('personalAccountCustomerId');

        $balance = (new InformationService())->getRtBalance($personalAccountCustomerId);

        return $balance;

    }

    public function activateService(Request $request)
    {
        $subscribeId = $request->input('subscribeId');
        $serviceId = $request->input('serviceId');

        $activate = (new InformationService())->activateService($subscribeId, $serviceId);

        return $activate;
    }

    public function deactivateService(Request $request)
    {
        $subscribeId = $request->input('subscribeId');
        $serviceId = $request->input('serviceId');

        $deactivate = (new InformationService())->deactivateService($subscribeId, $serviceId);

        return $deactivate;
    }

    public function checkService(Request $request)
    {
        $subscribeId = $request->input('subscribeId');
        $serviceId = $request->input('serviceId');

        $chek = (new InformationService())->checkService($subscribeId, $serviceId);

        return $chek;

    }

    public function activatePack(Request $request)
    {
        $pack_id = $request->input('pack_id');
        $comment = $request->input('comment');
        $subscriberId = $request->input('subscriber_id');

        $pack = (new InformationService())->activePack($subscriberId,$pack_id, $comment);

        return $pack;
    }

    public function getPack(Request $request)
    {
        $subscribeId = $request->input('subscribeId');

        $getPack = (new InformationService())->getPacks($subscribeId);

        return $getPack;
    }

    public function checkPack(Request $request)
    {
        $subscribeId = $request->input('subscribeId');
        $pack_id = $request->input('pack_id');

        $check = (new InformationService())->checkPack($subscribeId, $pack_id);

        return $check;
    }

    public function getPersonal()
    {

    }

}
