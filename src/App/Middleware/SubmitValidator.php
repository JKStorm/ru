<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class SubmitValidator
{
    /**
     * Validate that the given $request contains the required properties of a Submit action.
     *
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return mixed \Slim\Http\Response or callable
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        $requiredProperties = [
            'competition',
            'match_id',
            'season',
            'sport',
            'feed_file',
        ];

        $body = $request->getParsedBody();

        foreach ($requiredProperties as $requiredProperty) {
            if (!array_key_exists($requiredProperty, $body) || !$body[$requiredProperty]) {
                return $response->withStatus(400);
            }
        }

        $body['id'] = $body['match_id'];
        $body['teams'] = json_encode($body['teams']);

        $request = $request->withAttribute('parsedBody', $body);

        return $next($request, $response);
    }
}
