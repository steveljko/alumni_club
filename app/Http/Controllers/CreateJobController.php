<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\CreateJobRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateJobController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return ['auth:sanctum'];
  }

    /**
     * @OA\Post(
     *  path="/api/job/create",
     *  summary="Create a job",
     *  description="Create a new job for the authenticated user.",
     *  tags={"Job"},
     *  security={{"sanctum": {}}},
     *
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *      required={"company_name", "position", "start_date", "end_date"},
     *      @OA\Property(property="company_name", type="string", example="Example Company"),
     *      @OA\Property(property="position", type="string", example="Software Engineer"),
     *      @OA\Property(property="start_date", type="string", format="date", example="2024-01-01"),
     *      @OA\Property(property="end_date", type="string", format="date", example="2024-12-31"),
     *      @OA\Property(property="desc", type="string", example="Job description")
     *    ),
     *  ),
     *
     *  @OA\Response(
     *    response=201,
     *    description="Job successfully created",
     *    @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example=true),
     *      @OA\Property(property="job", type="object",
     *        @OA\Property(property="id", type="integer", example=1),
     *        @OA\Property(property="company_name", type="string", example="Example Company"),
     *        @OA\Property(property="position", type="string", example="Software Engineer"),
     *        @OA\Property(property="start_date", type="string", format="date", example="2024-01-01"),
     *        @OA\Property(property="end_date", type="string", format="date", example="2024-12-31"),
     *        @OA\Property(property="desc", type="string", example="Job description")
     *      )
     *    )
     *  ),
     *
     *  @OA\Response(
     *    response=422,
     *    description="Laravel validation error",
     *    @OA\JsonContent(
     *      @OA\Property(property="message", type="string"),
     *      @OA\Property(property="errors", type="object")
     *    )
     *  )
     * )
     */
  public function __invoke(CreateJobRequest $request): JsonResponse
  {
    $createdJob = Auth::user()
      ->jobs
      ->create($request->validated());

    return new JsonResponse([
      'success' => true,
      'job' => $createdJob
    ], Response::HTTP_CREATED);
  }
}
