<?php

namespace Larapackages\Tests\Unit\Interceptor;

use Larapackages\Interceptor\Interceptor;
use Larapackages\Interceptor\InterceptorInterface;
use Larapackages\Tests\TestCase;

/**
 * Class CallMethodReturnInterceptorResponseTest
 *
 * @package Larapackages\Tests\Unit\Interceptor
 */
class CallMethodReturnInterceptorResponseTest extends TestCase
{
    public function testCallMethodReturnInterceptorResponse()
    {
        $interceptable = new CallMethodReturnInterceptorResponseTestInterceptable();
        $interceptor   = new Interceptor($interceptable);

        $this->assertSame('Interceptor', $interceptor->getString());
    }
}

class CallMethodReturnInterceptorResponseTestInterceptable implements InterceptorInterface
{
    public function getString()
    {
        return 'Interceptable';
    }
    public static function interceptors(): array
    {
        return [
            CallMethodReturnInterceptorResponseTestInterceptorOne::class,
        ];
    }
}

class CallMethodReturnInterceptorResponseTestInterceptorOne
{
    public function getString()
    {
        return 'Interceptor';
    }
}