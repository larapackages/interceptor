<?php

namespace Larapackages\Tests\Unit\Interceptor;

use Larapackages\Interceptor\Interceptor;
use Larapackages\Interceptor\InterceptorInterface;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;

/**
 * Class SetTest.
 */
class SetTest extends TestCase
{
    use ReflectionTrait;

    public function testSet()
    {
        $interceptable = new SetTestInterceptable();
        $interceptor = new Interceptor($interceptable);

        $interceptor->property = 'modified';

        $interceptor_class = $this->getClassProperty($interceptor, 'class');
        $this->assertSame('modified', $this->getClassProperty($interceptor_class, 'property'));
    }
}

class SetTestInterceptable implements InterceptorInterface
{
    public $property = 'original';

    public static function interceptors(): array
    {
        return [];
    }
}
