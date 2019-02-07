<?php namespace professionalweb\IntegrationHub\IntegrationHub\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models\Request as IRequest;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Repositories\UserRepository;

class Authenticate
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /** @var Request $request */
        $token = $request->header(IRequest::TOKEN_HEADER_NAME);
        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);

        $user = !empty($token) ? $userRepository->getByToken($token) : null;
        if ($user === null) {
            throw new UnauthorizedException();
        }

        \Auth::setUser($user);

        return $next($request);
    }
}
