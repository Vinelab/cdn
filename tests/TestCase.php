<?php

namespace Vinelab\Cdn\tests;

// requiring this file to reference assertions as global functions. (to skip the $this->)
require_once 'vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

use PHPUnit_Framework_TestCase as PHPUnit;

class TestCase extends PHPUnit
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
