<?php

namespace Larapackages\Tests\Unit\Interceptor;

use ErrorException;
use Larapackages\Interceptor\Interceptor;
use Larapackages\Interceptor\InterceptorInterface;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;

/**
 * Class UnsetTest.
 */
class UnsetTest extends TestCase
{
    use ReflectionTrait;

    public function testIsset()
    {
        $interceptable = new UnsetTestInterceptable();
        $interceptor = new Interceptor($interceptable);

        $interceptor->property;
        unset($interceptor->property);
        $this->expectException(ErrorException::class);
        $interceptor->property;
    }
}

class UnsetTestInterceptable implements InterceptorInterface
{
    public $property = 'original';

    public static function interceptors(): array
    {
        return [];
    }
}
