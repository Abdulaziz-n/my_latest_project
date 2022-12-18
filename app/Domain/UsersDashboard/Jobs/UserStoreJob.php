<?php

namespace Usoft\UsersDashboard\Jobs;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\Gifts\Models\Gift;
use Usoft\Gifts\Requests\GiftRequest;

class UserStoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $attributes;

    public function __construct($request)
    {
        $this->attributes = $request;
    }

    public function handle()
    {
        return User::query()->create([
            'name' => $this->attributes->name,
            'email' => $this->attributes->email,
            'role_id' => $this->attributes->role_id,
            'password' => bcrypt($this->attributes->password)
        ]);
    }
}
