<?php

namespace Larapackages\Interceptor\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Larapackages\Interceptor\Services\InterceptorService;

class InterceptorCacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'interceptor:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a interceptor cache file for faster interceptors registration';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('interceptor:clear');

        File::put(
            config('interceptor.cache_file'), $this->buildInterceptorsCacheFile()
        );

        $this->info('Interceptors cached successfully!');
    }

    /**
     * Build the route cache file.
     *
     * @return string
     */
    private function buildInterceptorsCacheFile()
    {
        $interceptors = resolve(InterceptorService::class);
        $interceptors = $interceptors->getInterceptors()->map(function($class) {
            return "\t".$class.'::class,'.PHP_EOL;
        });

        $interceptors = PHP_EOL.$interceptors->implode('');

        return str_replace(
            '{{interceptors}}',
            $interceptors,
            File::get(__DIR__.'/stubs/interceptors.stub')
        );
    }
}
