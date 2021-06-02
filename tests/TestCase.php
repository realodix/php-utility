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
}
