<?php

namespace App\Http\Controllers\User;

use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Enums\FilterOperators;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;

#[Group('User')]
#[QueryParam("name[eq]", "Only support eq (equals).", required: false, example: "John Doe")]
#[QueryParam("details.uni_start_year[gte]", "Support eq (equals), gte (grater than equals) and lte (less than equals).", required: false, example: "2020")]
#[QueryParam("details.uni_finish_year[lte]", "Support eq (equals), gte (grater than equals) and lte (less than equals).", required: false, example: "2023")]
#[QueryParam("page", "Page number", required: false, example: "1")]
class GetUsersController extends Controller
{
  /**
   * Get users
   *
   * This endpoint is used for filtering user's from database.
   *
   * @var \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function __invoke(
    Request $request,
  ): JsonResponse
  {
    $result =
      User::filterWithPagination(
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
