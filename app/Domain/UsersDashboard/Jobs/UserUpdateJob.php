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


class UserUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $attributes;
    protected $user;

    public function __construct(User $user, $request)
    {
        $this->attributes = $request;
        $this->user = $user;
    }

    public function handle()
    {
        return $this->user->update([
            'name' => $this->attributes['name'],
            'email' => $this->attributes['email'],
            'role_id' => $this->attributes['role_id'],
            'password' => $this->attributes['password'] ? bcrypt($this->attributes['password']) : $this->user->password
        ]);

    }
}
