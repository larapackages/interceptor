<?php

namespace Larapackages\Interceptor\Services;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\LazyCollection;
use Larapackages\Interceptor\InterceptorInterface;
use Symfony\Component\Finder\Finder;

class InterceptorService extends Command
{
    /**
     * @return LazyCollection|null
     */
    public function getCacheInterceptors(): ?LazyCollection
    {
        $cacheFile = config('interceptor.cache_file');

        if (!File::exists($cacheFile)) {
            return null;
        }

        $interceptors = require $cacheFile;

        return LazyCollection::make(function () use ($interceptors) {
            foreach ($interceptors as $class) {
                if (in_array(InterceptorInterface::class, class_implements($class))) {
                    yield $class;
                }
            }
        });
    }

    /**
     * @return LazyCollection
     */
    public function getInterceptors(): LazyCollection
    {
        $paths = $this->getInterceptorsPaths();

        if (empty($paths)) {
            return new LazyCollection();
        }

        return LazyCollection::make(function () use ($paths) {
            foreach ((new Finder())->in($paths)->files() as $class) {
                $class = $this->getFullNamespace($class);

                if ($class === null) {
                    continue;
                }

                if (in_array(InterceptorInterface::class, class_implements($class))) {
                    yield $class;
                }
            }
        });
    }

    /**
     * @return array
     */
    private function getInterceptorsPaths()
    {
        $paths = array_unique(Arr::wrap(Config::get('interceptor.paths', [])));

        return array_filter($paths, function ($path) {
            return is_dir($path);
        });
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

        return $this->getClassNamespace($filename).'\\'.$this->getClassName($filename);
    }

    /**
     * @param $filename
     *
     * @return mixed
     */
    private function getClassNamespace($filename)
    {
        $lines = file($filename);
        $namespaceLine = preg_grep('/^namespace /', $lines);
        $namespaceLine = array_shift($namespaceLine);
        $match = [];
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
        $filename = array_pop($directoriesAndFilename);
        $nameAndExtension = explode('.', $filename);

        return array_shift($nameAndExtension);
    }
}
