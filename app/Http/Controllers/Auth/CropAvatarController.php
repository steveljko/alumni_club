<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class CropAvatarController extends Controller
{
    public function __invoke(Request $request): View
    {
        $file = $request->avatar;

        $imageData = base64_encode(file_get_contents($file->getRealPath()));
        $imageType = $file->getClientOriginalExtension();

        $image = 'data:image/'.$imageType.';base64,'.$imageData;

        return view('resources.auth.crop_avatar', compact('image'));
    }
}
