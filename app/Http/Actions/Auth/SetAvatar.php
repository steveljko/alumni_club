<?php

namespace App\Http\Actions\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

final class SetAvatar
{
    public function execute(Request $request, User $user): bool
    {
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $time = Carbon::now()->format('Ymd_His');
            $rand = Str::random();
            $extension = $file->getClientOriginalExtension();
            $name = "{$time}_{$rand}.{$extension}";

            $file->storeAs('images', $name, 'public');

            return $user->update(['avatar' => $name]);
        }
    }
}
