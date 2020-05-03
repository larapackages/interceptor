<?php

namespace Larapackages\Tests\Unit\Providers\InterceptorServiceProvider;

use Larapackages\Interceptor\Interceptor;
use Larapackages\Interceptor\Providers\InterceptorServiceProvider;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;
use Larapackages\Tests\Unit\Providers\InterceptorServiceProvider\Interceptors\TestInterceptor;

/**
 * Class BootDirectoryTest.
 */
class BootDirectoryTest extends TestCase
{
    use ReflectionTrait;

    public function testBootDirectory()
    {
        config()->set('interceptor.paths', __DIR__.'/Interceptors');

        $provider = new InterceptorServiceProvider($this->app);

        $provider->boot();

        $extenders = $this->getClassProperty($this->app, 'extenders');
        $this->assertArrayHasKey(TestInterceptor::class, $extenders);

        $this->assertInstanceOf(Interceptor::class, resolve(TestInterceptor::class));
    }
}
