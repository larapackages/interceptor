<?php

namespace Larapackages\Tests\Unit\Services\InterceptorService;

use Illuminate\Support\LazyCollection;
use Larapackages\Interceptor\Services\InterceptorService;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;
use Larapackages\Tests\Unit\Services\InterceptorService\Interceptors\TestInterceptor;

/**
 * Class GetInterceptorsPathTest.
 */
class GetInterceptorsPathTest extends TestCase
{
    use ReflectionTrait;

    public function testGetInterceptorsPath()
    {
        config()->set('interceptor.paths', __DIR__.'/Interceptors');

        $service = new InterceptorService();

        $interceptors = $service->getInterceptors();
        $this->assertInstanceOf(LazyCollection::class, $interceptors);
        $this->assertCount(1, $interceptors);
        $this->assertContains(TestInterceptor::class, $interceptors);
    }
}
