<?php

namespace SimpleDemoBlog\Tests;

include __DIR__ . '/../vendor/autoload.php';
use Faker\Factory;
use PHPUnit\Framework\TestCase as BaseTestCase;



class TestCase extends BaseTestCase {

    protected \Faker\Generator $faker;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->faker = Factory::create();
    }

}
