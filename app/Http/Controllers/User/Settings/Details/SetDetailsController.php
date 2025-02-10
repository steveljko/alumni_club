<?php

namespace App\Http\Controllers\User\Settings\Details;

use App\Http\Actions\Auth\SetDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\SetDetailsRequest;
use Illuminate\Http\Response;

final class SetDetailsController extends Controller
{
    public function __invoke(SetDetailsRequest $request, SetDetails $setDetails): Response
    {
        $ok = $setDetails->execute($request);

        if (! $ok) {
            return $this->toast(__('setup.step2.try_again'));
        }

        return $this->redirectWithToast(
            route: 'auth.setup.step.3',
            message: __('setup.step2.success'),
        );
    }
}
