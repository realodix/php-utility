<?php

namespace Realodix\Utils;

class Reflection
{
    /**
     * Get private/protected PHP methods using the Reflection API
     *
     * @param object $object     Instantiated object that we will run method on
     * @param string $method     Method name to call
     * @param array  $parameters Array of parameters to pass into method
     *
     * @throws \Exception
     *
     * @return mixed Method return
     */
    public static function method($object, string $method, array $parameters = [])
    {
        try {
            $className = get_class($object);
            $reflection = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }

        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
