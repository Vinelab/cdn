<?php namespace Vinelab\Cdn\Tests;

use Mockery as M;
use Vinelab\Cdn\Paths;

class FinderTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
        $this->paths = new Paths();
    }

    public function tearDown()
    {
        parent::tearDown();
        M::close();
    }


    public function testFirstCase(){
        $this->assertEquals('1', '1');
    }



}