<?php

namespace Usoft\Uzmobile\Services;

use App\Services\InformationService;
use http\Env\Response;
use Usoft\Exceptions\UzmobileErrorException;
use Usoft\RabbitMq\Services\SendService;
use Usoft\Resources\ErrorResources;

class PersonalSubscriberService
{

    public function subscriber($userSubscriber)
    {
        $phone = substr($userSubscriber->phone, 3);

        try {
            $subscriber = (new InformationService())->getSubcriber($phone);
        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {

                (new SendService())->queue_declare('logger', [
                    'user_id' => $userSubscriber->id,
                    'phone' => $phone,
                    'action' => 'get_user_personal_info',
                    'data' => [
                        'message' => $exception->getMessage(),
                    ]
                ]);

                return \response()->json([
                    'code' => $exception->getCode(),
                    'message' => 'User not found, please check phone number'
                ])->setStatusCode(404);

            } else
                return new ErrorResources($exception);
        }

//        return $subscriber;

        $information = [
            'msisdn' => $phone,
            'subscriber_id' => $subscriber['subscriberId'],
            'tariff' => [
                'id' => $subscriber['ratePlan']['ratePlanId'],
                'name' => $subscriber['ratePlan']['name']
            ]
        ];
        return $information;
    }

    public function checkService($userSubscriber)
    {
        $check_service = (new InformationService())->checkService($userSubscriber->subscriber_id);

        if (!empty($check_service['status'])) {
            if ($check_service['status']['serviceStatusId'] == 6)
                $status = 'deactive';
            else if ($check_service['status']['serviceStatusId'] == 4)
                $status = 'active';
        } else {
//            if ($check_service['status'] == null)
                $status = 'never';
        }

        $service = [
            'service_id' => $check_service['serviceId'],
            'status' => $status
        ];

        return $service;
    }

    public function customer($userSubscriber)
    {
        $customer = (new InformationService())->customerId($userSubscriber->subscriber_id);
        if (!empty($customer['items']))

            if ($customer['items'][0]['personalAccountStatus']['personalAccountStatusId'] == 2)
                $account_type = 'business';
        if ($customer['items'][0]['personalAccountStatus']['personalAccountStatusId'] == 1)
            $account_type = 'private';

        $customer = [
            'customer_id' => $customer['items'][0]['personalAccountCustomerId'],
            'full_name' => $customer['items'][0]['personalAccountCustomerName'],
            'account_status' => $account_type,
            'account_type' => $customer['items'][0]['accountType'],
            'budget_type' => $customer['items'][0]['personalBudgetType'],
            'current_balance' => $customer['items'][0]['balance']['currentBalance']
        ];

        return $customer;
    }

    public function rtBalance($userSubscriber)
    {
        $rt_balance = (new InformationService())->getRtBalance($userSubscriber->personal_accountCustomer_id);
        $balance = [
            'rt_balance' => $rt_balance['balances']['rtBalance']
        ];

        return $balance;
    }


}
