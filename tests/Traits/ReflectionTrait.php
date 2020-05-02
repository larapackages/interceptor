<?php

namespace Larapackages\Tests\Traits;

/**
 * Trait ReflectionTrait
 *
 * @package Tests\Traits
 */
trait ReflectionTrait
{
    /**
     * @param       $class
     * @param       $method
     * @param mixed ...$args
     *
     * @return mixed
     */
    private function getClassMethod($class, $method, ...$args)
    {
        $get_property_caller = function ($class, $method, $args) {
            return $class->{$method}(...$args);
        };

        return $get_property_caller->bindTo($class, $class)($class, $method, $args);
    }

    /**
     * @param $class
     * @param $property
     *
     * @return mixed
     */
    private function getClassProperty($class, $property)
    {
        $get_property_caller = function ($class, $property) {
            return $class->{$property};
        };

        return $get_property_caller->bindTo($class, $class)($class, $property);
    }

    /**
     * @param $class
     * @param $property
     * @param $value
     *
     * @return mixed
     */
    private function setClassProperty($class, $property, $value)
    {
        $get_property_caller = function ($class, $property, $value) {
            $class->{$property} = $value;
        };

        return $get_property_caller->bindTo($class, $class)($class, $property, $value);
    }
}
