<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\HtmxResponse;
use App\Http\Actions\Auth\SetDetails;
use App\Http\Requests\SetDetailsRequest;
use Illuminate\Http\Response;

final class SetDetailsController
{
    public function __invoke(SetDetailsRequest $request, SetDetails $setDetails): Response
    {
        $ok = $setDetails->execute($request);

        if ($ok) {
            return (new HtmxResponse)
                ->redirectTo('home')
                ->toast('You are all set!')
                ->send();
        }
    }
}
