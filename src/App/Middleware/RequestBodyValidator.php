<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class RequestBodyValidator
{
    /**
     * Validate that the given $request contains a body, and that body is valid JSON.
     *
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return mixed \Slim\Http\Response or callable
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        if (($size = $request->getBody()->getSize()) && $size > 0) {
            if ($body = $request->getParsedBody()) {
                return $next($request, $response);
            }
        }

        return $response->withStatus(400);
    }
}
