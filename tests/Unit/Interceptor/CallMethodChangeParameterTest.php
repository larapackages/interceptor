<?php

namespace Larapackages\Tests\Unit\Interceptor;

use Larapackages\Interceptor\Interceptor;
use Larapackages\Interceptor\InterceptorInterface;
use Larapackages\Tests\TestCase;

/**
 * Class CallMethodChangeParameterTest
 *
 * @package Larapackages\Tests\Unit\Interceptor
 */
class CallMethodChangeParameterTest extends TestCase
{
    public function testCallMethodChangeParameter()
    {
        $interceptable = new CallMethodChangeParameterTestInterceptable();
        $interceptor   = new Interceptor($interceptable);

        $this->assertSame('modified test', $interceptor->getParameter('test'));
    }
}

class CallMethodChangeParameterTestInterceptable implements InterceptorInterface
{
    public function getParameter($string)
    {
        return $string;
    }
    public static function interceptors(): array
    {
        return [
            CallMethodChangeParameterTestInterceptorOne::class,
        ];
    }
}

class CallMethodChangeParameterTestInterceptorOne
{
    public function getParameter($string)
    {
        $string = 'modified '.$string;

        return compact('string');
    }
}