<?php

namespace Larapackages\Tests\Unit\Interceptor;

use Larapackages\Interceptor\Interceptor;
use Larapackages\Interceptor\InterceptorInterface;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;

/**
 * Class ConstructTest
 *
 * @package Larapackages\Tests\Unit\Interceptor
 */
class ConstructTest extends TestCase
{
    use ReflectionTrait;

    public function testConstruct()
    {
        $interceptable = new ConstructTestInterceptable();
        $interceptor   = new Interceptor($interceptable);
        $this->assertSame($interceptable, $this->getClassProperty($interceptor, 'class'));

        $interceptors = $this->getClassProperty($interceptor, 'interceptors');
        $this->assertCount(2, $interceptors);
        $this->assertEquals(new ConstructTestInterceptorOne($interceptable), $interceptors[0]);
        $this->assertEquals(new ConstructTestInterceptorTwo, $interceptors[1]);

    }
}

class ConstructTestInterceptable implements InterceptorInterface
{
    public static function interceptors(): array
    {
        return [
            ConstructTestInterceptorOne::class,
            ConstructTestInterceptorTwo::class,
        ];
    }
}

class ConstructTestInterceptorOne
{
    private $class;

    public function __construct($class)
    {
        $this->class = $class;
    }
}

class ConstructTestInterceptorTwo
{
}