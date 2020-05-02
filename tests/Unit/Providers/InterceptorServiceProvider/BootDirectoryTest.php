<?php

namespace Larapackages\Tests\Unit\Providers\InterceptorServiceProvider;

use Larapackages\Interceptor\Providers\InterceptorServiceProvider;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;
use Larapackages\Tests\Unit\Providers\InterceptorServiceProvider\Interceptors\TestInterceptor;
use Larapackages\Tests\Unit\Providers\InterceptorServiceProvider\Interceptors\TestOtherClass;

/**
 * Class BootDirectoryTest
 *
 * @package Larapackages\Tests\Unit\Providers\InterceptorServiceProvider
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
        $this->assertArrayNotHasKey(TestOtherClass::class, $extenders);
    }
}