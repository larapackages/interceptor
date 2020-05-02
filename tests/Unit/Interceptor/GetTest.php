<?php

namespace Larapackages\Tests\Unit\Interceptor;

use Larapackages\Interceptor\Interceptor;
use Larapackages\Interceptor\InterceptorInterface;
use Larapackages\Tests\TestCase;

/**
 * Class GetTest.
 */
class GetTest extends TestCase
{
    public function testGet()
    {
        $interceptable = new GetTestInterceptable();
        $interceptor = new Interceptor($interceptable);

        $this->assertSame('original', $interceptor->property);
    }
}

class GetTestInterceptable implements InterceptorInterface
{
    public $property = 'original';

    public static function interceptors(): array
    {
        return [];
    }
}
