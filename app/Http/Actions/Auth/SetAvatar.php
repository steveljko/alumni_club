<?php

namespace App\Http\Actions\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class SetAvatar
{
    public function execute(Request $request, User $user): bool
    {
        $name = Str::random(15).'.jpg';
        $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('avatar_url')));

        Storage::disk('public')->put('/images/'.$name, $file);

        return $user->update(['avatar' => $name]);
    }
}
