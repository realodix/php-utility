<?php

namespace Realodix\Utils\Test;

use Faker\Factory as FakerFactory;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $faker;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->faker = FakerFactory::create();
    }

    /**
     * Testing private/protected PHP methods using the Reflection API.
     *
     * @param object $object     Instantiated object that we will run method on.
     * @param string $method     Method name to call.
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @throws \Exception
     *
     * @return mixed Method return.
     */
    protected function invokeMethod($object, string $method, array $parameters = [])
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
