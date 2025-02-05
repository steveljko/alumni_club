<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

final class DeleteUserController extends Controller
{
    public function __invoke(User $user): View
    {
        return view('resources.dashboard.users.delete', compact('user'));
    }
}
