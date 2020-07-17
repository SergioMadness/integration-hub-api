<?php namespace professionalweb\IntegrationHub\IntegrationHub\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * @param Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            app(Router::class)->options($request->path(), function () {
                return response('', 200);
            });
        }

        /** @var Response|\Illuminate\Http\Response $response */
        $response = $next($request);

        $response->headers->add([
            'Access-Control-Allow-Methods'  => 'HEAD, GET, POST, PUT, PATCH, DELETE',
            'Access-Control-Allow-Headers'  => $request->header('Access-Control-Request-Headers', '*'),
            'Access-Control-Allow-Origin'   => '*',
            'access-control-expose-headers' => '*',
        ]);

        return $response;
    }
}