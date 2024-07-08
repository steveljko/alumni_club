<?php

namespace App\Http\Controllers;

use App\Services\SetNewPassword;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(ChangePasswordRequest $request, SetNewPassword $service): JsonResponse
    {
        $service(Auth::user(), $request);

        return new JsonResponse('asd');
    }
}
