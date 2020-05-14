<?php

namespace Larapackages\Interceptor;

/**
 * Class that allows to extend another class to do some actions or modifications before execute the class function.
 */
class Interceptor
{
    /**
     * @var mixed
     */
    private $class;

    /**
     * @var array
     */
    private $interceptors;

    /**
     * Interceptor constructor.
     *
     * @param $class
     */
    public function __construct($class)
    {
        $this->class = $class;
        $this->interceptors = collect($class::interceptors())->transform(function ($interceptor) {
            return new $interceptor($this->class);
        })->toArray();
    }

    /**
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        //Execute interceptors method before execute on class
        foreach ($this->interceptors as $interceptor) {
            if (!method_exists($interceptor, $method)) {
                continue;
            }

            $response = $interceptor->{$method}(...$arguments);
            /**
             * Check if response is modifying original arguments to set it.
             */
            if (is_array($response)) {
                $arguments = array_values($response);
            /**
             * When response is not array or null we will send the response.
             * It could be for example a validation error that we need send back.
             */
            } elseif ($response !== null) {
                return $response;
            }
        }

        //Finally return the original method call return
        return $this->class->{$method}(...$arguments);
    }

    /**
     * @param $name
     * @param $value
     *
     * @return void
     */
    public function __set($name, $value)
    {
        $this->class->{$name} = $value;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->class->{$name};
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return property_exists($this->class, $name);
    }

    /**
     * @param $name
     *
     * @return void
     */
    public function __unset($name)
    {
        unset($this->class->{$name});
    }
}
