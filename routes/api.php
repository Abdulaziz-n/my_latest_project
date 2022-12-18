<?php

use App\Domain\Uzmobile\Services\InformationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Gifts\CategoryController;
use App\Http\Controllers\Gifts\GiftController;
use App\Http\Controllers\Gifts\OfferController;
use App\Http\Controllers\Gifts\UsersGiftController;
use App\Http\Controllers\Informations\GuideController;
use App\Http\Controllers\Informations\PolicyController;
use App\Http\Controllers\Informations\PrizeController;
use App\Http\Controllers\Informations\SocialController;
use App\Http\Controllers\Levels\LevelController;
use App\Http\Controllers\Levels\LevelsGiftController;
use App\Http\Controllers\Levels\LevelsScoreController;
use App\Http\Controllers\Levels\LevelsUserController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Transactions\TransactionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Charge\ChargeController;
use App\Http\Controllers\Questionnaire\OrganizationController;
use App\Http\Controllers\Questionnaire\SurveysController;
use App\Http\Controllers\Questionnaire\QuestionController;
use App\Http\Controllers\Questionnaire\InputTypeController;
use App\Http\Controllers\PaynetController;
use App\Http\Controllers\PaynetServiceController;
use App\Http\Controllers\NewsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::get('auth/uzmobile/login', [AuthController::class, 'uzmobileLogin'])->name('ulogin');

Route::group([
    'middleware' => ['auth:api', 'cors'],
], function () {

    Route::group(['prefix' => 'auth'], function () {

        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);

    });

    // Roles

    Route::group(['prefix' => 'roles',], function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/permissions', [RoleController::class, 'permissions']);
        Route::post('', [RoleController::class, 'store']);
        Route::put('/{role}', [RoleController::class, 'update']);
        Route::get('/{role}', [RoleController::class, 'update']);
        Route::delete('/{role}', [RoleController::class, 'destroy']);
    });

    // Users

    Route::group(['prefix' => 'users',], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('', [UserController::class, 'store']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::get('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    // Policies

    Route::group(['prefix' => 'policies'], function () {

        Route::get('/', [PolicyController::class, 'index']);
        Route::put('/{policy}', [PolicyController::class, 'update']);

    });

    // Prize

    Route::group(['prefix' => 'prizes'], function () {

        Route::get('/', [PrizeController::class, 'index']);
        Route::post('/', [PrizeController::class, 'store']);

    });

    // Social

    Route::group(['prefix' => 'socials'], function () {

        Route::get('/', [SocialController::class, 'index']);
        Route::post('/', [SocialController::class, 'store']);
        Route::put('/{social}', [SocialController::class, 'update']);
        Route::post('/{social}', [SocialController::class, 'updatePosition']);
        Route::get('/{social}', [SocialController::class, 'update']);
        Route::delete('/{social}', [SocialController::class, 'destroy']);
    });

    // Guides

    Route::group(['prefix' => 'guides'], function () {

        Route::get('/', [GuideController::class, 'index']);
        Route::post('/', [GuideController::class, 'store']);
        Route::get('/{guide}', [GuideController::class, 'update']);
        Route::post('/{guide}', [GuideController::class, 'update']);
        Route::put('/{guide}', [GuideController::class, 'updatePosition']);
        Route::delete('/{guide}', [GuideController::class, 'destroy']);
    });

    // Gifts

    Route::group(['prefix' => 'gifts'], function () {

        Route::get('/', [GiftController::class, 'index']);
        Route::post('/', [GiftController::class, 'store']);
        Route::get('/{gift}', [GiftController::class, 'update']);
        Route::put('/{gift}', [GiftController::class, 'update']);
        Route::delete('/{gift}', [GiftController::class, 'destroy']);
    });

    // Offer

    Route::group(['prefix' => 'offers'], function () {

        Route::get('/', [OfferController::class, 'index']);
        Route::post('/', [OfferController::class, 'store']);
        Route::get('/{offer}', [OfferController::class, 'update']);
        Route::put('/{offer}', [OfferController::class, 'update']);
        Route::delete('/{offer}', [OfferController::class, 'destroy']);
    });

    // Category

    Route::group([
        'prefix' => 'categories'
    ], function () {

        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::get('/{category}', [CategoryController::class, 'update']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::delete('/{category}', [CategoryController::class, 'destroy']);
    });

    // Levels

    Route::group(['prefix' => 'levels'], function () {

        Route::get('/', [LevelController::class, 'index']);
        Route::post('/', [LevelController::class, 'store']);
        Route::get('/gifts', [LevelsGiftController::class, 'index']);
        Route::get('/scores', [LevelsScoreController::class, 'index']);

        Route::group(['prefix' => '{level}'], function () {
            Route::get('/', [LevelController::class, 'update']);
            Route::put('/', [LevelController::class, 'update']);
            Route::delete('/', [LevelController::class, 'destroy']);

            Route::group(['prefix' => 'gifts'], function () {
                Route::get('/', [LevelsGiftController::class, 'index']);
                Route::post('/', [LevelsGiftController::class, 'store']);

                Route::group(['prefix' => '{levelsGift}'], function () {
                    Route::get('/', [LevelsGiftController::class, 'update']);
                    Route::post('/', [LevelsGiftController::class, 'update']);
                    Route::put('/', [LevelsGiftController::class, 'updatePosition']);
                    Route::delete('/', [LevelsGiftController::class, 'destroy']);
                    Route::put('/probability', [LevelsGiftController::class, 'updateProbability']);
                });
            });

            Route::group(['prefix' => 'score'], function () {
                Route::get('/', [LevelsScoreController::class, 'index']);
                Route::post('/', [LevelsScoreController::class, 'store']);
                Route::get('/{levelsScore}', [LevelsScoreController::class, 'update']);
                Route::put('/{levelsScore}', [LevelsScoreController::class, 'update']);
                Route::delete('/{levelsScore}', [LevelsScoreController::class, 'destroy']);
            });
        });

    });


    Route::group(['prefix' => 'get'], function () {

        Route::get('/subscribers/', [InformationController::class, 'getSubscriber']);
        Route::get('/user/', [InformationController::class, 'getPersonalCustomerId']);
        Route::get('/rtbalance/', [InformationController::class, 'getRtBalance']);
        Route::post('/activate/', [InformationController::class, 'activateService']);
        Route::get('/deactivate/', [InformationController::class, 'deactivateService']);
        Route::get('/checkservice/', [InformationController::class, 'checkService']);
        Route::get('/activatepack/', [InformationController::class, 'activatePack']);
        Route::get('/getpack/', [InformationController::class, 'getPack']);
        Route::get('/checkpack/', [InformationController::class, 'checkPack']);

    });

    // Subscribers (single page)

    Route::group(['prefix' => 'subscribers'], function () {
        Route::get('/', [UserSubscriberController::class, 'index']);
        Route::get('/filter-fields', [UserSubscriberController::class, 'filterFields']);
        Route::get('/{userSubscriber}', [UserSubscriberController::class, 'view']);
        Route::get('/{userSubscriber}/logs', [UserSubscriberController::class, 'log']);
        Route::get('/{userSubscriber}/gifts/', [UsersGiftController::class, 'index']);
        Route::get('/{userSubscriber}/transactions', [TransactionsController::class, 'index']);
        Route::get('/{userSubscriber}/levels/statistics', [TransactionsController::class, 'total']);
        Route::get('/{userSubscriber}/levels', [LevelsUserController::class, 'singleLevel']);
        Route::get('/{userSubscriber}/personal', [UserSubscriberController::class, 'personal']);
        Route::post('/{userSubscriber}/packet', [UserSubscriberController::class, 'packet']);
        Route::get('/{userSubscriber}/filter-fields', [UserSubscriberController::class, 'packet']);
        Route::post('/{userSubscriber}/set-by-user', [UserSubscriberController::class, 'setByUser']);


        Route::put('/{userSubscriber}/activate', [UserSubscriberController::class, 'activate']);

    });

    Route::get('winners', [LevelsUserController::class, 'index']);


    //testing
    Route::get('subscriber/store', [ChargeController::class, 'store']);


    Route::get('charges', [ChargeController::class, 'store']);

    //statistics
    Route::get('charges/schedule/{tariff}', [ChargeController::class, 'scheduleInsert']);

    Route::group(['prefix' => 'statistics'], function () {

        Route::get('gifts', [UsersGiftController::class, 'statistics']);
        Route::get('paynet', [PaynetController::class, 'rpcDeposit']);
        Route::get('paynet/count', [PaynetController::class, 'totalCount']);
        Route::get('paynet/count/failed', [PaynetController::class, 'failedTotalCount']);
        Route::get('paynet/amount', [PaynetController::class, 'totalAmount']);
        Route::get('paynet/amount/failed', [PaynetController::class, 'failedTotalAmount']);
        Route::get('paynet/transactions', [PaynetController::class, 'transactions']);
        Route::get('paynet/get/apps', [PaynetController::class, 'appList']);
        Route::get('paynet/test', [PaynetServiceController::class, 'uzmobile']);
        Route::get('charges/{tariff}', [ChargeController::class, 'monthlyStatistics']);
        Route::get('charges/daily/{tariff}', [ChargeController::class, 'dailyStatistics']);
        Route::get('/invoice', [ChargeController::class, 'invoice']);
        Route::get('/profits', [ChargeController::class, 'profit']);
//        Route::get('/profits/csv', [ChargeController::class, 'profit_excel']);
        Route::get('/profits/total', [ChargeController::class, 'profit_total']);
        Route::get('/profits/expense', [ChargeController::class, 'profit_expense']);
        Route::get('/profits/revenue', [ChargeController::class, 'profit_revenue']);

            Route::group(['prefix' => 'subscribers'], function () {

                Route::get('/daily', [UserSubscriberController::class, 'daily']);
                Route::get('/total', [UserSubscriberController::class, 'total']);
                Route::get('/monthly', [UserSubscriberController::class, 'monthly']);
                Route::get('/verification', [UserSubscriberController::class, 'verified']);
            });
    });

    // Paynet Service CRUD

    Route::group(['prefix' => 'paynet'], function () {

        Route::get('', [PaynetServiceController::class, 'index']);
        Route::post('', [PaynetServiceController::class, 'store']);
        Route::get('/{service}/', [PaynetServiceController::class, 'update']);
        Route::put('/{service}/', [PaynetServiceController::class, 'update']);
        Route::delete('/{service}/', [PaynetServiceController::class, 'destroy']);
    });

    // News Crud

    Route::group(['prefix' => 'news'], function () {

        Route::get('', [NewsController::class, 'index']);
        Route::post('', [NewsController::class, 'store']);
        Route::get('/{news}/', [NewsController::class, 'update']);
        Route::post('/{news}/', [NewsController::class, 'update']);
        Route::delete('/{news}/', [NewsController::class, 'destroy']);
    });
    //Activity Log

    Route::group([
        'prefix' => 'log'
    ], function () {
//        Route::post('/', [LogController::class, 'store']);
        Route::get('/', [LogController::class, 'index']);
        Route::get('/actions', [LogController::class, 'actions']);
    });

    // Questionnaire

    Route::group(['prefix' => 'organizations'], function () {
        Route::get('/', [OrganizationController::class, 'index']);
        Route::post('/', [OrganizationController::class, 'store']);
        Route::group(['prefix' => '{organization}'], function(){
            Route::put('/', [OrganizationController::class, 'update']);
            Route::get('/', [OrganizationController::class, 'update']);
            Route::delete('/', [OrganizationController::class, 'destroy']);

            Route::group(['prefix' => 'surveys'], function () {
                Route::get('/', [SurveysController::class, 'index']);
                Route::post('/', [SurveysController::class, 'store']);
                Route::group(['prefix' => '{survey}'], function (){
                    Route::put('/', [SurveysController::class, 'update']);
                    Route::get('/', [SurveysController::class, 'update']);
                    Route::delete('/', [SurveysController::class, 'destroy']);

                    Route::group(['prefix' => 'questions'], function (){
                        Route::get('/', [QuestionController::class, 'index']);
                        Route::post('/', [QuestionController::class, 'store']);
                        Route::put('/{question}/', [QuestionController::class, 'update']);
                        Route::put('/{question}/position', [QuestionController::class, 'updatePosition']);
                        Route::get('/{question}', [QuestionController::class, 'update']);
                        Route::delete('/{question}', [QuestionController::class, 'destroy']);
                        Route::delete('/{question}/answers/{answer}', [QuestionController::class, 'deleteAnswer']);
                    });
                });
            });
        });
    });



        Route::group(['prefix' => 'input-types'], function () {
            Route::get('/', [InputTypeController::class, 'index']);
            Route::post('/', [InputTypeController::class, 'store']);
            Route::put('/{inputType}', [InputTypeController::class, 'update']);
            Route::get('/{inputType}', [InputTypeController::class, 'update']);
            Route::delete('/{inputType}', [InputTypeController::class, 'destroy']);
        });

    Route::get('/mobile/question', [\App\Http\Controllers\Questionnaire\MobileApiController::class, 'question']);

});
Route::delete('transaction-delete', [\App\Http\Controllers\Controller::class, 'del']);
Route::get('questionnaire',[\App\Http\Controllers\Questionnaire\MobileApiController::class, 'answer']);
Route::get('questionnaire/get',[\App\Http\Controllers\Questionnaire\MobileApiController::class, 'question']);
Route::post('questionnaire',[\App\Http\Controllers\Questionnaire\MobileApiController::class, 'answerUser']);
Route::get('/mobile/mock-api', [\App\Http\Controllers\Questionnaire\MobileApiController::class, 'mockApi']);
