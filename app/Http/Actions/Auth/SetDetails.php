<?php

namespace App\Http\Actions\Auth;

use App\Http\Requests\SetDetailsRequest;

final class SetDetails
{
    public function execute(SetDetailsRequest $request): bool
    {
        return auth()->user()->setDetails(
            $request->only([
                'uni_start_year',
                'uni_finish_year',
                'bio',
            ])
        );
    }
}
