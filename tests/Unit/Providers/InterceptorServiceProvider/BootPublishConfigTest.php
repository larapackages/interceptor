<?php

namespace Larapackages\Tests\Unit\Providers\InterceptorServiceProvider;

use Larapackages\Interceptor\Providers\InterceptorServiceProvider;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;

/**
 * Class BootPublishConfigTest
 *
 * @package Larapackages\Tests\Unit\Providers\InterceptorServiceProvider
 */
class BootPublishConfigTest extends TestCase
{
    use ReflectionTrait;

    public function testBootPublishConfig()
    {
        $provider = new InterceptorServiceProvider($this->app);

        $provider->boot();

        $interceptor_config_path = str_replace('vendor/orchestra/testbench-core/laravel', '',base_path());
        $interceptor_config_path .= 'src/Providers/../../config/interceptor.php';

        $this->assertArrayHasKey(InterceptorServiceProvider::class, $provider::$publishes);
        $this->assertEquals([
            $interceptor_config_path => config_path('interceptor.php')
        ], $provider::$publishes[InterceptorServiceProvider::class]);
    }
}