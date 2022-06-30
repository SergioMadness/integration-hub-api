<?php namespace professionalweb\IntegrationHub\IntegrationHub\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use professionalweb\IntegrationHub\IntegrationHub\Services\RequestValidation;
use professionalweb\IntegrationHub\IntegrationHub\Http\Middleware\CorsMiddleware;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Services\RequestValidation as IRequestValidation;

class IntegrationHubProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
    }

    public function boot(Router $router): void
    {
        $router->pushMiddlewareToGroup('api', CorsMiddleware::class);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'IntegrationHub');
    }
}