<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Post\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

final class DeleteUserController extends Controller
{
    public function __invoke(User $user): Response
    {
        DB::transaction(function () use ($user) {
            $user->posts()->update(['status' => PostStatus::ARCHIVED]);

            $user->delete();
        });

        return $this->toast('Deleted!');
    }
}
