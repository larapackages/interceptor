<?php

namespace Larapackages\Tests\Unit\Interceptor;

use Larapackages\Interceptor\Interceptor;
use Larapackages\Interceptor\InterceptorInterface;
use Larapackages\Tests\TestCase;

/**
 * Class CallMethodWithoutInterceptorTest
 *
 * @package Larapackages\Tests\Unit\Interceptor
 */
class CallMethodWithoutInterceptorTest extends TestCase
{
    public function testCallAnotherMethod()
    {
        $interceptable = new CallMethodWithoutInterceptorTestInterceptable();
        $interceptor   = new Interceptor($interceptable);

        $this->assertSame('test', $interceptor->getParameter('test'));
    }
}

class CallMethodWithoutInterceptorTestInterceptable implements InterceptorInterface
{
    public function getParameter($string)
    {
        return $string;
    }
    public static function interceptors(): array
    {
        return [
            CallMethodWithoutInterceptorTestInterceptorOne::class,
        ];
    }
}

class CallMethodWithoutInterceptorTestInterceptorOne
{
    public function anotherGet($string)
    {
        return 'another '.$string;
    }
}