<?php

namespace Larapackages\Tests\Unit\Services\InterceptorService;

use Illuminate\Support\LazyCollection;
use Larapackages\Interceptor\Services\InterceptorService;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;

/**
 * Class GetInterceptorEmptyPathTest.
 */
class GetInterceptorEmptyPathTest extends TestCase
{
    use ReflectionTrait;

    public function testGetInterceptorsEmptyPath()
    {
        $service = new InterceptorService();

        $interceptors = $service->getInterceptors();
        $this->assertInstanceOf(LazyCollection::class, $interceptors);
        $this->assertEmpty($interceptors);
    }
}
