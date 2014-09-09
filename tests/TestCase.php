<?php namespace Vinelab\Cdn\Tests;

// requiring this file to reference assertions as global functions. (to skip the $this->)
require_once 'vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

use Mockery as M;
use PHPUnit_Framework_TestCase as PHPUnit;

class TestCase extends PHPUnit {

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

}
