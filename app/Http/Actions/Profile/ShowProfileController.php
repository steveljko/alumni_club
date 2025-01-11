<?php

namespace App\Http\Actions\Profile;

use App\Models\User;
use Illuminate\View\View;

final class ShowProfileController
{
    public function __invoke(User $user): View|string
    {
        $user->load(['posts' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        if (request()->hasHeader('HX-Request')) {
            $user->load(['posts' => function ($query) {
                if ($type = request()->query('type')) {
                    $query->where('type', $type);
                }
                $query->orderBy('created_at', 'desc');
            }]);

            return view('profile.show', compact('user'))->fragments(['posts', 'posts-count']);
        }

        return view('profile.show', compact('user'));
    }
}
