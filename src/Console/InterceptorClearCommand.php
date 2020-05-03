<?php

namespace Larapackages\Interceptor\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InterceptorClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'interceptor:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the interceptor cache file';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        File::delete(config('interceptor.cache_file'));

        $this->info('Interceptor cache cleared!');
    }
}
