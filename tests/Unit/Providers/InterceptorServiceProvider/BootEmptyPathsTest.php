<?php

namespace Larapackages\Tests\Unit\Providers\InterceptorServiceProvider;

use Larapackages\Interceptor\Providers\InterceptorServiceProvider;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;

/**
 * Class BootEmptyPathsTest
 *
 * @package Larapackages\Tests\Unit\Providers\InterceptorServiceProvider
 */
class BootEmptyPathsTest extends TestCase
{
    use ReflectionTrait;

    public function testBootEmptyPaths()
    {
        $provider = new InterceptorServiceProvider($this->app);

        $extenders = $this->getClassProperty($this->app, 'extenders');
        $provider->boot();
        $new_extenders = $this->getClassProperty($this->app, 'extenders');

        $this->assertSame($extenders, $new_extenders);
    }
}