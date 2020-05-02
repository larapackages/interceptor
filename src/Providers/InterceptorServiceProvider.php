<?php

namespace Larapackages\Interceptor\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Larapackages\Interceptor\Interceptor;
use Larapackages\Interceptor\InterceptorInterface;
use Symfony\Component\Finder\Finder;

class InterceptorServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../../config/interceptor.php';
        $this->mergeConfigFrom($configPath, 'interceptor');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/interceptor.php' => config_path('interceptor.php'),
        ], 'config');

        $paths = array_unique(Arr::wrap($this->app['config']->get('interceptor.paths', [])));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return;
        }

        foreach ((new Finder)->in($paths)->files() as $class) {
            $class = $this->getFullNamespace($class);

            if (is_null($class)) {
                continue;
            }

            if (in_array(InterceptorInterface::class, class_implements($class))) {
                $this->app->extend($class, function ($class) {
                    return new Interceptor($class);
                });
            }
        }
    }

    /**
     * @param $filename
     *
     * @return string|null
     */
    private function getFullNamespace($filename)
    {
        $namespace = $this->getClassNamespace($filename);

        if ($namespace === null) {
            return null;
        }

        return $this->getClassNamespace($filename) . '\\' . $this->getClassName($filename);
    }

    /**
     * @param $filename
     *
     * @return mixed
     */
    private function getClassNamespace($filename)
    {
        $lines         = file($filename);
        $namespaceLine = preg_grep('/^namespace /', $lines);
        $namespaceLine = array_shift($namespaceLine);
        $match         = [];
        preg_match('/^namespace (.*);$/', $namespaceLine, $match);

        return array_pop($match);
    }

    /**
     * @param $filename
     *
     * @return mixed|string
     */
    private function getClassName($filename)
    {
        $directoriesAndFilename = explode('/', $filename);
        $filename               = array_pop($directoriesAndFilename);
        $nameAndExtension       = explode('.', $filename);

        return array_shift($nameAndExtension);
    }
}
