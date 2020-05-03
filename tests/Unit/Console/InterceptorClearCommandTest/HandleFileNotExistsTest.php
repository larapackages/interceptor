<?php

namespace Larapackages\Tests\Unit\Console\InterceptorClearCommandTest;

use Illuminate\Support\Facades\File;
use Larapackages\Interceptor\Providers\InterceptorServiceProvider;
use Larapackages\Tests\TestCase;

/**
 * Class HandleFileNotExistsTest.
 */
class HandleFileNotExistsTest extends TestCase
{
    public function testHandleFileNotExists()
    {
        $file = __DIR__.'/file_not_exists.txt';

        config()->set('interceptor.cache_file', $file);

        $this->artisan('interceptor:clear')
            ->expectsOutput('Interceptor cache cleared!');

        $this->assertFalse(File::exists($file));
    }

    protected function getPackageProviders($app)
    {
        return [InterceptorServiceProvider::class];
    }
}
