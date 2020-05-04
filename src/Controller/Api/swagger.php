<?php
declare(strict_types=1);

/**
 * @OA\Info(
 *   title="CakePHP Vue Study",
 *   description="CakePHP Vue Study API List",
 *   version="1.0.0",
 * )
 */

/**
 * @OA\Server(
 *   description="localhost",
 *   url="http://localhost",
 * ),
 */

/**
 * @see https://github.com/zircote/swagger-php/issues/598
 * @OA\SecurityScheme(
 *   securityScheme="api_user_local",
 *   type="apiKey",
 *   in="header",
 *   name="X-Api-User-Local",
 *   description="ローカルで実行した場合のユーザー情報 ({""sub"":""DUMMY""})",
 * ),
 * @OA\OpenApi(
 *   security={
 *     {
 *       "api_user_local":{}
 *     },
 *   },
 * ),
 */
