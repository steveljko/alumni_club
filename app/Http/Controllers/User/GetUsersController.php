<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Enums\FilterOperators;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;

// TODO: In future filter only user's with student role
class GetUsersController extends Controller
{
  /**
   * Get users endpoint
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
    $page = $request->query('page', 1);

    if ($page < 1)
      return $this->sendFailResponse(
        message: __('additional.pagination.invalid_page_number')
      );

    $users = User::filter(
      query: $request->query(),
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
      ]
    )
      ->with('details')
      ->paginate(10);

    if ($page > $users->lastPage())
      return $this->sendFailResponse(
        message: __('additional.pagination.page_not_found')
      );

    $data = UserResource::collection($users)->response()->getData();

    $count = count($users);

    if ($count <= 0) {
      return $this->sendFailResponse(
        message: __('additional.users.find_fail'),
        status: Response::HTTP_NOT_FOUND
      );
    }

    return $this->sendResponse(
      message: trans_choice(__('additional.users.find_success'), $count),
      data: $data,
    );
  }
}
