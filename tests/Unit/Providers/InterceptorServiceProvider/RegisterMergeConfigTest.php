<?php

namespace Larapackages\Tests\Unit\Providers\InterceptorServiceProvider;

use Larapackages\Interceptor\Providers\InterceptorServiceProvider;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;

/**
 * Class RegisterMergeConfigTest
 *
 * @package Larapackages\Tests\Unit\Providers\InterceptorServiceProvider
 */
class RegisterMergeConfigTest extends TestCase
{
    use ReflectionTrait;

    public function testBootEmptyPaths()
    {
        $provider = new InterceptorServiceProvider($this->app);

        $this->assertNull(config('interceptor'));
        $provider->register();
        $this->assertNotNull(config('interceptor'));
    }
}