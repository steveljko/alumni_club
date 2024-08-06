<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;
use App\Traits\Concerns\Enums\FilterOperators;

#[Group('User')]
#[QueryParam('name[eq]', 'Only support eq (equals).', required: false, example: 'John Doe')]
#[QueryParam('details.uni_start_year[gte]', 'Support eq (equals), gte (grater than equals) and lte (less than equals).', required: false, example: '2020')]
#[QueryParam('details.uni_finish_year[lte]', 'Support eq (equals), gte (grater than equals) and lte (less than equals).', required: false, example: '2023')]
#[QueryParam('page', 'Page number', required: false, example: '1')]
class GetUsersController extends Controller
{
    /**
     * Get users
     *
     * This endpoint is used for filtering user's from database.
     *
     * @var \Illuminate\Http\Request
     */
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $result = User::filterWithPagination(
            allowedParams: [
                'name' => [FilterOperators::EQUALS],
                'details' => [
                    'uni_start_year' => [
                        FilterOperators::EQUALS,
                        FilterOperators::GRATER_THAN_EQUALS,
                        FilterOperators::LESS_THAN_EQUALS,
                    ],
                    'uni_finish_year' => [
                        FilterOperators::EQUALS,
                        FilterOperators::GRATER_THAN_EQUALS,
                        FilterOperators::LESS_THAN_EQUALS,
                    ],
                ],
            ],
            with: ['details'],
            resource: UserResource::class,
        );

        if ($result->empty()) {
            return $this->sendFailResponse(
                message: __('additional.users.find_fail'),
                status: Response::HTTP_NOT_FOUND
            );
        }

        return $this->sendResponse(
            message: trans_choice(__('additional.users.find_success'), $result->getCount()),
            data: $result->getData(),
        );
    }
}
