<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *      title="TMS API Documentation",
 *      version="1.0.0",
 * )
 *
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="",
 * )
 *
 *  @OA\OpenApi(
 *      security={{"bearerAuth": {}}}
 * )
 *
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer",
 *          description="Login with email and password using login API to get the token. Then enter the token below to authorize."
 *     )
 * )
 *
 **/
abstract class Controller
{
    //
}
