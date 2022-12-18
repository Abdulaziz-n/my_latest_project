<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use App\Policies\ActivePackPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\GiftPolicy;
use App\Policies\GuidePolicy;
use App\Policies\LevelsGiftsPolicy;
use App\Policies\LevelsPolicy;
use App\Policies\OfferPolicy;
use App\Policies\PolicyPolicy;
use App\Policies\PrizePolicy;
use App\Policies\PrizesPolicy;
use App\Policies\RolePolicy;
use App\Policies\SocialPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Usoft\Categories\Models\Category;
use Usoft\Gifts\Models\Gift;
use Usoft\Guide\Models\Guide;
use Usoft\Levels\Models\LevelsGift;
use Usoft\Levels\Models\LevelsScore;
use Usoft\Offers\Models\Offer;
use Usoft\Policy\Models\Policy;
use Usoft\Prize\Models\Prize;
use Usoft\Social\Models\Social;
use Usoft\Levels\Models\Level;
use Usoft\UserSubscribers\Models\UserSubscriber;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Policy::class => PolicyPolicy::class,
        Guide::class => GuidePolicy::class,
        Role::class => RolePolicy::class,
        Social::class => SocialPolicy::class,
        Category::class => CategoryPolicy::class,
        Gift::class => GiftPolicy::class,
        Offer::class => OfferPolicy::class,
        Level::class => LevelsPolicy::class,
        Prize::class => PrizePolicy::class,
        LevelsGift::class => LevelsGiftsPolicy::class,
        LevelsScore::class => LevelsGiftsPolicy::class,
        UserSubscriber::class => ActivePackPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
