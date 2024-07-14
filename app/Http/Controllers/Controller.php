<?php

namespace App\Http\Controllers;

// TODO: Try to make sanctum cookie auth work in Swagger UI

/**
 * @OA\Info(
 *  title="Alumni Club API",
 *  version="0.1",
 *
 *  @OA\Contact(
 *    email="steveljko@proton.me"
 *  ),
 *
 *  @OA\SecurityScheme(
 *    securityScheme="sanctum",
 *    type="apiKey",
 *    in="cookie",
 *    name="XSRF-TOKEN",
 *    description="Use the XSRF-TOKEN cookie for CSRF protection"
 *  ),
 *
 *  @OA\Server(
 *    description="Test",
 *    url="http://localhost:8000/api/"
 *  )
 * )
 */
abstract class Controller
{
  //
}
