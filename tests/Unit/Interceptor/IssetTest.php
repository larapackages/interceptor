<?php

namespace Larapackages\Tests\Unit\Interceptor;

use Larapackages\Interceptor\Interceptor;
use Larapackages\Interceptor\InterceptorInterface;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;

/**
 * Class IssetTest
 *
 * @package Larapackages\Tests\Unit\Interceptor
 */
class IssetTest extends TestCase
{
    use ReflectionTrait;

    public function testIsset()
    {
        $interceptable = new IssetTestInterceptable();
        $interceptor   = new Interceptor($interceptable);

        $this->assertFalse(isset($interceptor->another_property));
        $this->assertTrue(empty($interceptor->another_property));

        $this->assertTrue(isset($interceptor->property_string));
        $this->assertFalse(empty($interceptor->property_string));

        $this->assertTrue(isset($interceptor->property_array));
        $this->assertTrue(empty($interceptor->property_array));
    }
}

class IssetTestInterceptable implements InterceptorInterface
{
    public $property_string = 'original';
    public $property_array  = [];

    public static function interceptors(): array
    {
        return [];
    }
}