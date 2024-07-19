<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use App\Services\FilterModel;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;

class GetUsersController extends Controller
{
  public function __invoke(
    Request $request,
    FilterModel $filterModel
  ): JsonResponse
  {
    $users = User::filter(
      query: $request->query(),
      allowedParams: [
        'name' => ['eq'],
        '(details_uni_start_year)' => ['eq', 'gte', 'lte'],
        '(details_uni_finish_year)' => ['eq', 'gte', 'lte'],
      ]
    )
      ->with('details')
      ->get();

    $count = count($users);

    // TODO: Localize all messages
    if ($count <= 0) {
      return $this->sendFailResponse(
        message: "Kriterijum nije zadovoljen.",
        status: Response::HTTP_NOT_FOUND
      );
    }

    return $this->sendResponse(
      message: "{$count} pronađenih korisnika.",
      data: UserResource::collection($users)
    );
  }
}
