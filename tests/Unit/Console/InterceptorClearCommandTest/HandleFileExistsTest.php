<?php

namespace Larapackages\Tests\Unit\Console\InterceptorClearCommandTest;

use Illuminate\Support\Facades\File;
use Larapackages\Interceptor\Providers\InterceptorServiceProvider;
use Larapackages\Tests\TestCase;

/**
 * Class HandleFileExistsTest.
 */
class HandleFileExistsTest extends TestCase
{
    public function testHandleFileExists()
    {
        $file = __DIR__.'/file_exists.txt';
        File::put($file, 'test');

        $this->assertTrue(File::exists($file));

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