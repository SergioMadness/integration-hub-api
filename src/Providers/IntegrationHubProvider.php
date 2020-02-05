<?php namespace professionalweb\IntegrationHub\IntegrationHub\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use professionalweb\IntegrationHub\IntegrationHub\Exceptions\Handler;
use professionalweb\IntegrationHub\IntegrationHub\Services\RequestValidation;
use professionalweb\IntegrationHub\IntegrationHub\Repositories\UserRepository;
use professionalweb\IntegrationHub\IntegrationHub\Http\Middleware\Authenticate;
use professionalweb\IntegrationHub\IntegrationHub\Http\Middleware\CorsMiddleware;
use professionalweb\IntegrationHub\IntegrationHub\Http\Middleware\ApiAuthenticate;
use professionalweb\IntegrationHub\IntegrationHub\Repositories\ApplicationRepository;
use professionalweb\IntegrationHub\IntegrationHubCommon\Interfaces\Exceptions\ExceptionProcessor;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Repositories\UserRepository as IUserRepository;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Services\RequestValidation as IRequestValidation;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Repositories\ApplicationRepository as IApplicationRepository;

class IntegrationHubProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->singleton(ExceptionHandler::class, Handler::class);
        $this->app->singleton(IRequestValidation::class, RequestValidation::class);
        $this->app->singleton(IApplicationRepository::class, ApplicationRepository::class);
        $this->app->singleton(IUserRepository::class, function () {
            return new UserRepository();
        });

        /** @var ExceptionProcessor $exceptionPool */
        $exceptionPool = app(ExceptionProcessor::class);
        $exceptionPool->register([Handler::class, 'register']);
    }

    public function boot(Router $router): void
    {
        $router->pushMiddlewareToGroup('api', CorsMiddleware::class);

        $router->aliasMiddleware('b2bAuth', ApiAuthenticate::class);
        $router->aliasMiddleware('auth', Authenticate::class);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'IntegrationHub');
    }
}