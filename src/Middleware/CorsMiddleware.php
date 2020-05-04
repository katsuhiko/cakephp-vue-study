<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CorsMiddleware implements MiddlewareInterface
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        // ローカル開発モードのときのみ CORS に対応する
        if (filter_var(env('SERVER', false))) {
            return $response;
        }

        $response = $response->withHeader('Access-Control-Allow-Origin', '*');
        $response = $response->withHeader('Access-Control-Allow-Methods', '*');
        $response = $response->withHeader('Access-Control-Allow-Headers', 'Content-Type, X-Api-User-Local');
        $response = $response->withHeader('Access-Control-Max-Age', '172800');

        return $response;
    }
}
