<?php

namespace Larapackages\Tests\Unit\Services\InterceptorService;

use Larapackages\Interceptor\Services\InterceptorService;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;

/**
 * Class GetCacheInterceptorsFileNotExistsTest.
 */
class GetCacheInterceptorsFileNotExistsTest extends TestCase
{
    use ReflectionTrait;

    public function testGetCacheInterceptorsFileNotExists()
    {
        config()->set('interceptor.cache_file', __DIR__.'/interceptors.php');

        $service = new InterceptorService();

        $interceptors = $service->getCacheInterceptors();
        $this->assertNull($interceptors);
    }
}
