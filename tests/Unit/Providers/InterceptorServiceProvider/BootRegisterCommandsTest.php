<?php

namespace Larapackages\Tests\Unit\Providers\InterceptorServiceProvider;

use Illuminate\Contracts\Console\Kernel;
use Larapackages\Interceptor\Providers\InterceptorServiceProvider;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;

/**
 * Class BootRegisterCommandsTest.
 */
class BootRegisterCommandsTest extends TestCase
{
    use ReflectionTrait;

    public function testBootRegisterCommands()
    {
        config()->set('interceptor.paths', __DIR__.'/Interceptors');

        $provider = new InterceptorServiceProvider($this->app);

        $provider->boot();

        $consoleApplication = $this->getClassMethod($this->app[Kernel::class], 'getArtisan');
        $commands = $this->getClassMethod($consoleApplication, 'all');
        $this->assertArrayHasKey('interceptor:cache', $commands);
        $this->assertArrayHasKey('interceptor:clear', $commands);
    }
}
