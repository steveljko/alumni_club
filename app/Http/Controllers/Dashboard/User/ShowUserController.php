<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class ShowUserController extends Controller
{
    public function __invoke(User $user): View
    {
        [$postCount, $commentCount] = Redis::hmget('user_stats:'.$user->id, ['posts', 'comments']);

        return view('resources.dashboard.users.show', compact('user', 'postCount', 'commentCount'));
    }
}
