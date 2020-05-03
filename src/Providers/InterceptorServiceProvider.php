<?php

namespace Larapackages\Interceptor\Providers;

use Illuminate\Support\ServiceProvider;
use Larapackages\Interceptor\Console\InterceptorCacheCommand;
use Larapackages\Interceptor\Console\InterceptorClearCommand;
use Larapackages\Interceptor\Interceptor;
use Larapackages\Interceptor\Services\InterceptorService;

class InterceptorServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__.'/../../config/interceptor.php';
        $this->mergeConfigFrom($configPath, 'interceptor');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerCommands();
        $this->registerInterceptors();
    }

    /**
     * @return void
     */
    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InterceptorCacheCommand::class,
                InterceptorClearCommand::class,
            ]);
        }
    }

    /**
     * @return void
     */
    private function registerInterceptors(): void
    {
        $this->publishes([
            __DIR__.'/../../config/interceptor.php' => config_path('interceptor.php'),
        ], 'config');

        $interceptorService = resolve(InterceptorService::class);

        $interceptors = $interceptorService->getCacheInterceptors();
        if ($interceptors === null) {
            $interceptors = $interceptorService->getInterceptors();
        }

        $interceptors->each(function ($class) {
            $this->app->extend($class, function ($class) {
                return new Interceptor($class);
            });
        });
    }
}
